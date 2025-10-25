<?php

namespace App\Http\Controllers;

use App\Models\ServiceItem;
use Illuminate\Http\Request;

class ServiceItemController extends Controller
{
    /**
     * 🟦 Tampilkan semua data + fitur pencarian
     */
    public function index(Request $request)
    {
        $query = ServiceItem::query();

        // 🔍 Jika ada pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('price', 'like', "%{$search}%");
        }

        $serviceItems = $query->latest()->get();

        return view('page.serviceitem.index', compact('serviceItems'));
    }

    /**
     * 🟩 Form tambah data
     */
    public function create()
    {
        return view('page.serviceitem.create');
    }

    /**
     * 🟨 Simpan data baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'is_active' => 'required|boolean',
        ]);

        // 🔍 Cek duplikat
        $exists = ServiceItem::where('name', $request->name)->first();
        if ($exists) {
            return back()->withInput()->with('error', '⚠️ Nama item servis sudah ada!');
        }

        ServiceItem::create($request->only(['name', 'price', 'is_active']));

        return redirect()->route('service.item')->with('success', '✅ Item servis berhasil ditambahkan!');
    }

    /**
     * 🟦 Form edit item
     */
    public function edit($id)
    {
        $serviceItem = ServiceItem::findOrFail($id);
        return view('page.serviceitem.edit', compact('serviceItem'));
    }

    /**
     * 🟨 Update item
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'is_active' => 'required|boolean',
        ]);

        $serviceItem = ServiceItem::findOrFail($id);

        // Cek duplikat nama (kecuali dirinya sendiri)
        $exists = ServiceItem::where('name', $request->name)
            ->where('id', '!=', $id)
            ->first();

        if ($exists) {
            return back()->withInput()->with('error', '⚠️ Nama item servis sudah ada!');
        }

        $serviceItem->update($request->only(['name', 'price', 'is_active']));

        return redirect()->route('service.item')->with('success', '🔄 Item servis berhasil diperbarui!');
    }

    /**
     * 🟥 Soft delete item
     */
    public function destroy($id)
    {
        $serviceItem = ServiceItem::findOrFail($id);
        $serviceItem->delete();

        return redirect()->route('service.item')->with('success', '🗑️ Item servis berhasil dihapus (masuk trash)!');
    }

    /**
     * 🗑️ Tampilkan data yang dihapus (trash)
     */
    public function trash()
    {
        $serviceItems = ServiceItem::onlyTrashed()->latest()->get();
        return view('page.serviceitem.trash', compact('serviceItems'));
    }

    /**
     * ♻️ Restore data dari trash
     */
    public function restore($id)
    {
        $serviceItem = ServiceItem::onlyTrashed()->findOrFail($id);
        $serviceItem->restore();

        return redirect()->route('service.item.trash')->with('success', '♻️ Item servis berhasil dipulihkan!');
    }

    /**
     * ❌ Hapus permanen dari trash
     */
    public function forceDelete($id)
    {
        $serviceItem = ServiceItem::onlyTrashed()->findOrFail($id);
        $serviceItem->forceDelete();

        return redirect()->route('service.item.trash')->with('success', '🧹 Item servis berhasil dihapus permanen!');
    }
}
