<?php

namespace App\Http\Controllers;

use App\Models\Handphone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HandphoneController extends Controller
{
    // 🟦 TAMPIL SEMUA HANDPHONE (dengan fitur SEARCH)
    public function index(Request $request)
    {
        $query = Handphone::query();

        // 🔍 Jika ada pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            $query->where('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('release_year', 'like', "%{$search}%");
        }

        // Ambil data terbaru
        $handphones = $query->latest()->get();

        return view('page.handphone.index', compact('handphones'));
    }

    // 🟦 TAMPIL DATA YANG DIHAPUS (TRASH)
    public function trash()
    {
        $handphones = Handphone::onlyTrashed()->latest()->get();
        return view('page.handphone.trash', compact('handphones'));
    }

    // 🟩 FORM TAMBAH
    public function create()
    {
        return view('page.handphone.create');
    }

    // 🟨 SIMPAN DATA BARU
    public function store(Request $request)
    {
        $request->validate([
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'brand'        => 'required|string|max:255',
            'model'        => 'required|string|max:255',
            'release_year' => 'required|integer|min:2000|max:2099',
            'is_active'    => 'required|string|in:active,nonactive',
        ]);

        // 🔍 CEK DUPLIKAT BRAND + MODEL
        $existing = Handphone::where('brand', $request->brand)
            ->where('model', $request->model)
            ->first();

        if ($existing) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '⚠️ Handphone dengan brand dan model yang sama sudah ada!');
        }

        // 📸 SIMPAN GAMBAR
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('handphones', 'public');
        }

        // 💾 SIMPAN DATA
        Handphone::create([
            'image'        => $imagePath,
            'brand'        => $request->brand,
            'model'        => $request->model,
            'release_year' => $request->release_year,
            'is_active'    => $request->is_active,
        ]);

        return redirect()
            ->route('handphone.index')
            ->with('success', '✅ Data handphone berhasil ditambahkan.');
    }

    // 🟦 DETAIL HANDPHONE
    public function show($id)
    {
        $handphone = Handphone::findOrFail($id);
        return view('page.handphone.show', compact('handphone'));
    }

    // 🟩 FORM EDIT
    public function edit($id)
    {
        $handphone = Handphone::findOrFail($id);
        return view('page.handphone.edit', compact('handphone'));
    }

    // 🟨 UPDATE DATA
    public function update(Request $request, $id)
    {
        $request->validate([
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'brand'        => 'required|string|max:255',
            'model'        => 'required|string|max:255',
            'release_year' => 'required|integer|min:2000|max:2099',
            'is_active'    => 'required|string|in:active,nonactive',
        ]);

        $handphone = Handphone::findOrFail($id);

        // 🔍 CEK DUPLIKAT BRAND + MODEL (kecuali dirinya sendiri)
        $existing = Handphone::where('brand', $request->brand)
            ->where('model', $request->model)
            ->where('id', '!=', $id)
            ->first();

        if ($existing) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '⚠️ Handphone dengan brand dan model yang sama sudah ada!');
        }

        // 📸 UPDATE GAMBAR (kalau ada yang baru)
        if ($request->hasFile('image')) {
            if ($handphone->image && Storage::disk('public')->exists($handphone->image)) {
                Storage::disk('public')->delete($handphone->image);
            }
            $handphone->image = $request->file('image')->store('handphones', 'public');
        }

        // 💾 UPDATE DATA
        $handphone->update([
            'brand'        => $request->brand,
            'model'        => $request->model,
            'release_year' => $request->release_year,
            'is_active'    => $request->is_active,
            'image'        => $handphone->image,
        ]);

        return redirect()
            ->route('handphone.index')
            ->with('success', '🔄 Data handphone berhasil diperbarui.');
    }

    // 🟥 HAPUS DATA (SOFT DELETE)
    public function destroy($id)
    {
        $handphone = Handphone::findOrFail($id);
        $handphone->delete(); // sekarang hanya soft delete

        return redirect()
            ->route('handphone.index')
            ->with('success', '🗑️ Data handphone berhasil dipindahkan ke trash.');
    }

    // ♻️ RESTORE DATA
    public function restore($id)
    {
        $handphone = Handphone::onlyTrashed()->findOrFail($id);
        $handphone->restore();

        return redirect()
            ->route('handphone.trash')
            ->with('success', '✅ Data handphone berhasil dipulihkan.');
    }

    // 🚮 HAPUS PERMANEN
    public function forceDelete($id)
    {
        $handphone = Handphone::onlyTrashed()->findOrFail($id);

        // hapus gambar dari storage juga
        if ($handphone->image && Storage::disk('public')->exists($handphone->image)) {
            Storage::disk('public')->delete($handphone->image);
        }

        $handphone->forceDelete();

        return redirect()
            ->route('handphone.trash')
            ->with('success', '❌ Data handphone dihapus permanen.');
    }
}
