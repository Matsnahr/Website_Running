<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventCity;
use Illuminate\Http\Request;

class EventCityController extends Controller
{
    public function index()
    {
        $cities = EventCity::orderBy('nama')->get();
        return view('admin.master.cities.index', compact('cities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:150|unique:event_cities,nama',
            'provinsi' => 'nullable|string|max:150',
            'aktif'    => 'boolean',
        ]);

        $validated['aktif'] = $request->has('aktif');

        EventCity::create($validated);

        return back()->with('success', 'Kota berhasil ditambahkan.');
    }

    public function update(Request $request, EventCity $eventCity)
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:150|unique:event_cities,nama,' . $eventCity->id,
            'provinsi' => 'nullable|string|max:150',
            'aktif'    => 'boolean',
        ]);

        $validated['aktif'] = $request->has('aktif');

        $eventCity->update($validated);

        return back()->with('success', 'Kota berhasil diperbarui.');
    }

    public function destroy(EventCity $eventCity)
    {
        $eventCity->delete();
        return back()->with('success', 'Kota berhasil dihapus.');
    }
}
