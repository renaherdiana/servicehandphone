<?php

namespace App\Http\Controllers;

use App\Models\ServiceItem;
use Illuminate\Http\Request;

class ServiceItemController extends Controller
{
    // 🟦 Tampilkan semua data
    public function index()
    {
        $serviceItems = ServiceItem::orderBy('created_at', 'desc')->get();
        return view('page.serviceitem.index', compact('serviceItems'));
    }

    // 🟩 Form tambah data
    public function create()
    {
        return view('page.serviceitem.create');
    }

    // 🟨 Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'is_active' => 'required|boolean',
        ]);

        // 🔍 Cek apakah sudah ada nama service yang sama
        $existing = ServiceItem::where('name', $request->name)->first();
        if ($existing) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '⚠️ Item servis dengan nama yang sama sudah ada!');
        }

        ServiceItem::create([
            'name' => $request->name,
            'price' => $request->price,
            'is_active' => $request->is_active,
        ]);

        return redirect()
            ->route('service.item')
            ->with('success', '✅ Item servis berhasil ditambahkan!');
    }

    // 🟦 Form edit item
    public function edit($id)
    {
        $serviceItem = ServiceItem::findOrFail($id);
        return view('page.serviceitem.edit', compact('serviceItem'));
    }

    // 🟨 Update item
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'is_active' => 'required|boolean',
        ]);

        $serviceItem = ServiceItem::findOrFail($id);

        // 🔍 Cek duplikat nama (kecuali dirinya sendiri)
        $existing = ServiceItem::where('name', $request->name)
            ->where('id', '!=', $id)
            ->first();

        if ($existing) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '⚠️ Item servis dengan nama yang sama sudah ada!');
        }

        $serviceItem->update([
            'name' => $request->name,
            'price' => $request->price,
            'is_active' => $request->is_active,
        ]);

        return redirect()
            ->route('service.item')
            ->with('success', '🔄 Item servis berhasil diperbarui!');
    }

    // 🟥 Hapus item
    public function destroy($id)
    {
        $serviceItem = ServiceItem::findOrFail($id);
        $serviceItem->delete();

        return redirect()
            ->route('service.item')
            ->with('success', '🗑️ Item servis berhasil dihapus!');
    }
}
