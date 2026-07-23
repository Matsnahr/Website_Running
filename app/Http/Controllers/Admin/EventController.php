<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventCity;
use App\Models\EventFacility;
use App\Models\EventRunCategory;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $events = $query->orderBy('tanggal', 'desc')->paginate(10);

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $categories = EventCategory::aktif()->get();
        $cities     = EventCity::aktif()->get();
        return view('admin.events.create', compact('categories', 'cities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'                    => 'required|string|max:255',
            'kota'                    => 'required|string|max:255',
            'tanggal'                 => 'required|date',
            'waktu_mulai'             => 'required',
            'status'                  => 'required|in:draft,aktif,selesai',
            'deskripsi'               => 'nullable|string',
            'lokasi_detail'           => 'nullable|string',
            'thumbnail'               => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            // Warisan field lama (diisi dari kategori pertama jika tidak ada multi-kategori)
            'harga'                   => 'nullable|numeric|min:0',
            'kuota'                   => 'nullable|integer|min:1',
            // Multi-kategori
            'run_categories'          => 'nullable|array',
            'run_categories.*.nama'   => 'required_with:run_categories|string|max:100',
            'run_categories.*.jarak_km' => 'nullable|numeric|min:0',
            'run_categories.*.harga'  => 'required_with:run_categories|numeric|min:0',
            'run_categories.*.kuota'  => 'required_with:run_categories|integer|min:1',
            'run_categories.*.deskripsi' => 'nullable|string',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('events', 'public');
        }

        // Hitung harga & kuota event dari kategori jika ada multi-kategori
        $runCats = $request->input('run_categories', []);
        $runCats = array_filter($runCats, fn($c) => !empty(trim($c['nama'] ?? '')));

        if (count($runCats) > 0) {
            // Harga event = harga kategori terendah; kuota = total semua kategori
            $hargaMin = min(array_column($runCats, 'harga'));
            $kuotaTotal = array_sum(array_column($runCats, 'kuota'));
            $validated['harga'] = $hargaMin;
            $validated['kuota'] = $kuotaTotal;
            // kategori & jarak_km dari yang pertama
            $validated['kategori'] = $runCats[0]['nama'];
            $validated['jarak_km'] = $runCats[0]['jarak_km'] ?? 0;
        } else {
            // Fallback ke mode lama: satu kategori
            $validated['harga']     = $validated['harga'] ?? 0;
            $validated['kuota']     = $validated['kuota'] ?? 100;
            $validated['kategori']  = $request->input('kategori', '');
            $validated['jarak_km']  = $request->input('jarak_km', 0);
        }

        $event = Event::create($validated);

        // Simpan multi-kategori
        if (count($runCats) > 0) {
            foreach (array_values($runCats) as $i => $cat) {
                EventRunCategory::create([
                    'event_id'   => $event->id,
                    'nama'       => $cat['nama'],
                    'jarak_km'   => $cat['jarak_km'] ?? null,
                    'harga'      => $cat['harga'],
                    'kuota'      => $cat['kuota'],
                    'deskripsi'  => $cat['deskripsi'] ?? null,
                    'urutan'     => $i,
                ]);
            }
        }

        // Fasilitas
        if ($request->filled('fasilitas')) {
            foreach ($request->fasilitas as $nama) {
                if (trim($nama) !== '') {
                    EventFacility::create([
                        'event_id'       => $event->id,
                        'nama_fasilitas' => $nama,
                    ]);
                }
            }
        }

        return redirect()->route('admin.events.index')
            ->with('success', 'Acara berhasil dibuat.');
    }

    public function show(Event $event)
    {
        return redirect()->route('admin.events.edit', $event);
    }

    public function edit(Event $event)
    {
        $event->load('facilities', 'runCategories');
        $categories = EventCategory::aktif()->get();
        $cities     = EventCity::aktif()->get();
        return view('admin.events.edit', compact('event', 'categories', 'cities'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'nama'                    => 'required|string|max:255',
            'kota'                    => 'required|string|max:255',
            'tanggal'                 => 'required|date',
            'waktu_mulai'             => 'required',
            'status'                  => 'required|in:draft,aktif,selesai',
            'deskripsi'               => 'nullable|string',
            'lokasi_detail'           => 'nullable|string',
            'thumbnail'               => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'harga'                   => 'nullable|numeric|min:0',
            'kuota'                   => 'nullable|integer|min:1',
            'run_categories'          => 'nullable|array',
            'run_categories.*.nama'   => 'required_with:run_categories|string|max:100',
            'run_categories.*.jarak_km' => 'nullable|numeric|min:0',
            'run_categories.*.harga'  => 'required_with:run_categories|numeric|min:0',
            'run_categories.*.kuota'  => 'required_with:run_categories|integer|min:1',
            'run_categories.*.deskripsi' => 'nullable|string',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($event->thumbnail) {
                \Storage::disk('public')->delete($event->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('events', 'public');
        }

        $runCats = $request->input('run_categories', []);
        $runCats = array_filter($runCats, fn($c) => !empty(trim($c['nama'] ?? '')));

        if (count($runCats) > 0) {
            $hargaMin   = min(array_column($runCats, 'harga'));
            $kuotaTotal = array_sum(array_column($runCats, 'kuota'));
            $validated['harga']    = $hargaMin;
            $validated['kuota']    = $kuotaTotal;
            $validated['kategori'] = $runCats[0]['nama'];
            $validated['jarak_km'] = $runCats[0]['jarak_km'] ?? 0;
        } else {
            $validated['harga']    = $validated['harga'] ?? $event->harga;
            $validated['kuota']    = $validated['kuota'] ?? $event->kuota;
            $validated['kategori'] = $request->input('kategori', $event->kategori ?? '');
            $validated['jarak_km'] = $request->input('jarak_km', $event->jarak_km ?? 0);
        }

        $event->update($validated);

        // Sync multi-kategori (hapus semua, buat ulang)
        $event->runCategories()->delete();
        if (count($runCats) > 0) {
            foreach (array_values($runCats) as $i => $cat) {
                EventRunCategory::create([
                    'event_id'   => $event->id,
                    'nama'       => $cat['nama'],
                    'jarak_km'   => $cat['jarak_km'] ?? null,
                    'harga'      => $cat['harga'],
                    'kuota'      => $cat['kuota'],
                    'deskripsi'  => $cat['deskripsi'] ?? null,
                    'urutan'     => $i,
                ]);
            }
        }

        // Fasilitas
        $event->facilities()->delete();
        if ($request->filled('fasilitas')) {
            foreach ($request->fasilitas as $nama) {
                if (trim($nama) !== '') {
                    EventFacility::create([
                        'event_id'       => $event->id,
                        'nama_fasilitas' => $nama,
                    ]);
                }
            }
        }

        return redirect()->route('admin.events.index')
            ->with('success', 'Acara berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')
            ->with('success', 'Acara berhasil dihapus.');
    }
}