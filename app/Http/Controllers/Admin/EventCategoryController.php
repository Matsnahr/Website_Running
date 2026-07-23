<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventCategoryController extends Controller
{
    public function index()
    {
        $categories = EventCategory::orderBy('urutan')->orderBy('nama')->get();
        return view('admin.master.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'              => 'required|string|max:100|unique:event_categories,nama',
            'jarak_km_default'  => 'nullable|numeric|min:0',
            'urutan'            => 'nullable|integer|min:0',
            'aktif'             => 'boolean',
        ]);

        $validated['aktif']  = $request->has('aktif');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        EventCategory::create($validated);

        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, EventCategory $eventCategory)
    {
        $validated = $request->validate([
            'nama'             => 'required|string|max:100|unique:event_categories,nama,' . $eventCategory->id,
            'jarak_km_default' => 'nullable|numeric|min:0',
            'urutan'           => 'nullable|integer|min:0',
            'aktif'            => 'boolean',
        ]);

        $validated['aktif']  = $request->has('aktif');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        $eventCategory->update($validated);

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(EventCategory $eventCategory)
    {
        $eventCategory->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
