<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Technician;

class TechnicianController extends Controller
{
    /** 🔹 Tampilkan daftar teknisi */
    public function index()
    {
        $technicians = Technician::latest()->get();
        return view('page.teknisi.index', compact('technicians'));
    }

    /** 🔹 Form tambah teknisi */
    public function create()
    {
        return view('page.teknisi.create');
    }

    /** 🔹 Simpan teknisi baru */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'is_active' => 'required|boolean',
        ]);

        Technician::create([
            'name' => $request->name,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('technician.index')
                         ->with('success', '✅ Teknisi berhasil ditambahkan!');
    }

    /** 🔹 Detail teknisi */
    public function show($id)
    {
        $technician = Technician::findOrFail($id);
        return view('page.teknisi.show', compact('technician'));
    }

    /** 🔹 Form edit teknisi */
    public function edit($id)
    {
        $technician = Technician::findOrFail($id);
        return view('page.teknisi.edit', compact('technician'));
    }

    /** 🔹 Update data teknisi */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'is_active' => 'required|boolean',
        ]);

        $technician = Technician::findOrFail($id);
        $technician->update([
            'name' => $request->name,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('technician.index')
                         ->with('success', '✅ Data teknisi berhasil diperbarui!');
    }

    /** 🔹 Hapus teknisi */
    public function destroy($id)
    {
        $technician = Technician::findOrFail($id);
        $technician->delete();

        return redirect()->route('technician.index')
                         ->with('success', '🗑️ Data teknisi berhasil dihapus!');
    }
}
