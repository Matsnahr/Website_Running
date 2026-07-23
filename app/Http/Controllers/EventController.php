<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventCity;
use App\Models\EventRunCategory;
use App\Models\Registration;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::where('status', 'aktif');

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('kota')) {
            $query->where('kota', $request->kota);
        }
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $events     = $query->orderBy('tanggal')->paginate(8);
        $categories = EventCategory::aktif()->get();
        $cities     = EventCity::aktif()->get();
        $kotaList   = Event::where('status', 'aktif')->distinct()->pluck('kota');

        return view('events.index', compact('events', 'kotaList', 'categories', 'cities'));
    }

    public function show(Event $event)
    {
        $event->load('facilities', 'runCategories');
        return view('events.show', compact('event'));
    }

    public function registerForm(Event $event)
    {
        if ($event->tanggal->lt(today())) {
            return redirect()->route('events.show', $event)
                ->with('error', 'Pendaftaran gagal. Event ini sudah berlalu.');
        }

        if ($event->terisi >= $event->kuota) {
            return redirect()->route('events.show', $event)
                ->with('error', 'Pendaftaran gagal. Kuota event ini sudah penuh.');
        }

        // Cek apakah akun user ini sudah terdaftar di event ini
        if (auth()->check()) {
            $user = auth()->user();

            // 1. Cek berdasarkan user_id (akun yang sama)
            $akunSudahDaftar = Registration::where('event_id', $event->id)
                ->where('user_id', $user->id)
                ->exists();

            if ($akunSudahDaftar) {
                return redirect()->route('events.show', $event)
                    ->with('error', 'Akun Anda sudah terdaftar di event ini. Setiap peserta hanya diperbolehkan mendaftar 1 kali per event.');
            }

            // 2. Cek berdasarkan NIK profil user (jika tersimpan di profil)
            if ($user->nik) {
                $nikSudahDaftar = Registration::where('event_id', $event->id)
                    ->where('nik', trim($user->nik))
                    ->exists();

                if ($nikSudahDaftar) {
                    return redirect()->route('events.show', $event)
                        ->with('error', 'NIK Anda sudah digunakan untuk mendaftar di event ini. Setiap peserta hanya diperbolehkan mendaftar 1 kali per event.');
                }
            }
        }

        $event->load('runCategories');
        return view('events.register', compact('event'));
    }

    public function registerStore(Request $request, Event $event)
    {
        if ($event->tanggal->lt(today())) {
            return redirect()->route('events.show', $event)
                ->with('error', 'Pendaftaran gagal. Event ini sudah berlalu.');
        }

        if ($event->terisi >= $event->kuota) {
            return redirect()->route('events.show', $event)
                ->with('error', 'Pendaftaran gagal. Kuota event ini sudah penuh.');
        }

        $event->load('runCategories');
        $hasRunCategories = $event->runCategories->count() > 0;

        $rules = [
            'nama_lengkap'  => 'required|string|max:255',
            'email'         => 'required|email',
            'no_hp'         => 'required|string|max:20',
            'nik'           => ['required', 'digits:16'],
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'ukuran_jersey' => 'required|in:S,M,L,XL,XXL',
            'kode_kupon'    => 'nullable|string',
        ];

        if ($hasRunCategories) {
            $rules['event_run_category_id'] = [
                'required',
                'exists:event_run_categories,id',
                function ($attribute, $value, $fail) use ($event) {
                    $valid = $event->runCategories->pluck('id')->contains((int)$value);
                    if (!$valid) {
                        $fail('Kategori lari yang dipilih tidak valid untuk event ini.');
                    }
                },
            ];
        }

        $validated = $request->validate($rules, [
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits'   => 'NIK harus terdiri dari 16 digit angka.',
            'event_run_category_id.required' => 'Pilih salah satu kategori lari.',
        ]);

        $nik = trim($validated['nik']);
        $userId = auth()->id();

        // Cek 1: Akun yang sama (user_id) sudah terdaftar di event ini
        $akunSudahDaftar = Registration::where('event_id', $event->id)
            ->where('user_id', $userId)
            ->exists();

        if ($akunSudahDaftar) {
            return back()->withInput()
                ->withErrors(['nik' => 'Akun Anda sudah terdaftar di event ini. Setiap peserta hanya diperbolehkan mendaftar 1 kali per event.']);
        }

        // Cek 2: NIK yang sama sudah digunakan di event ini (oleh akun lain)
        $nikSudahDaftar = Registration::where('event_id', $event->id)
            ->where('nik', $nik)
            ->exists();

        if ($nikSudahDaftar) {
            return back()->withInput()
                ->withErrors(['nik' => 'NIK (' . $nik . ') sudah digunakan untuk mendaftar di event ini. Setiap peserta hanya diperbolehkan mendaftar 1 kali per event.']);
        }

        // Tentukan harga dan kuota kategori
        $runCategory    = null;
        $biayaLayanan   = 5000;
        $diskon         = 0;

        if ($hasRunCategories) {
            $runCategory = EventRunCategory::find($validated['event_run_category_id']);

            if (!$runCategory || $runCategory->terisi >= $runCategory->kuota) {
                return back()->withInput()
                    ->withErrors(['event_run_category_id' => 'Kuota untuk kategori ini sudah penuh. Pilih kategori lain.']);
            }

            $biayaPendaftaran = $runCategory->harga;
        } else {
            $biayaPendaftaran = $event->harga;
        }

        // Hitung diskon kupon
        if ($request->filled('kode_kupon')) {
            $coupon = Coupon::where('code', strtoupper(trim($request->kode_kupon)))
                ->where('is_active', true)
                ->first();
            if ($coupon) {
                if (!$coupon->expired_at || now()->lte($coupon->expired_at)) {
                    if ($coupon->discount_type === 'percentage') {
                        $diskon = ($biayaPendaftaran * $coupon->discount) / 100;
                    } else {
                        $diskon = $coupon->discount;
                    }
                }
            }
        }

        $total = max($biayaPendaftaran + $biayaLayanan - $diskon, 0);

        try {
            DB::transaction(function () use ($event, $runCategory, $validated, $total, $biayaPendaftaran, $diskon, $request, $nik) {
                Registration::create([
                    'event_id'               => $event->id,
                    'event_run_category_id'  => $runCategory?->id,
                    'user_id'                => auth()->id(),
                    'nama_lengkap'           => $validated['nama_lengkap'],
                    'email'                  => $validated['email'],
                    'no_hp'                  => $validated['no_hp'],
                    'jenis_kelamin'          => $validated['jenis_kelamin'],
                    'ukuran_jersey'          => $validated['ukuran_jersey'],
                    'nik'                    => $nik,
                    'kode_kupon'             => $request->kode_kupon ? strtoupper(trim($request->kode_kupon)) : null,
                    'nominal_bayar'          => $biayaPendaftaran,
                    'diskon'                 => $diskon,
                    'total_bayar'            => $total,
                    'status_bayar'           => 'lunas',
                ]);

                // Increment kuota terisi
                $event->increment('terisi');
                if ($runCategory) {
                    $runCategory->increment('terisi');
                }
            });
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withInput()
                ->withErrors(['nik' => 'NIK (' . $nik . ') ini atau akun Anda sudah terdaftar di event ini. Setiap peserta hanya diperbolehkan mendaftar 1 kali per event.']);
        }

        return redirect()->route('registrations.index')
            ->with('success', 'Pendaftaran berhasil! Slot Anda telah dikonfirmasi. ✅');
    }

    public function checkCoupon(Request $request)
    {
        $code = strtoupper(trim($request->kode_kupon ?? ''));

        if (!$code) {
            return response()->json(['valid' => false, 'message' => 'Kode kupon tidak boleh kosong.']);
        }

        $coupon = Coupon::where('code', $code)->where('is_active', true)->first();

        if (!$coupon) {
            return response()->json(['valid' => false, 'message' => 'Kode kupon tidak valid atau sudah tidak aktif.']);
        }

        if ($coupon->expired_at && now()->gt($coupon->expired_at)) {
            return response()->json(['valid' => false, 'message' => 'Kode kupon sudah kadaluarsa.']);
        }

        return response()->json([
            'valid'         => true,
            'discount'      => $coupon->discount,
            'discount_type' => $coupon->discount_type,
            'message'       => 'Kupon berhasil diterapkan! Diskon ' . ($coupon->discount_type === 'percentage'
                ? (float)$coupon->discount . '%'
                : 'Rp ' . number_format($coupon->discount, 0, ',', '.')),
        ]);
    }
}