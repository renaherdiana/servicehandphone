<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Tampilkan semua pelanggan
     */
    public function index()
    {
        $customers = Customer::all();
        return view('page.customer.index', compact('customers'));
    }

    /**
     * Form tambah pelanggan baru
     */
    public function create()
    {
        return view('page.customer.create');
    }

    /**
     * Simpan pelanggan baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        Customer::create([
            'name'      => $request->name,
            'is_active' => $request->is_active,
        ]);

        // ✅ Tambahkan pesan sukses (kayak di HandphoneController)
        return redirect()->route('customer.index')->with('success', '✅ Pelanggan baru berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail pelanggan (opsional)
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return view('page.customer.show', compact('customer'));
    }

    /**
     * Form edit pelanggan
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('page.customer.edit', compact('customer'));
    }

    /**
     * Update pelanggan di database
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update([
            'name'      => $request->name,
            'is_active' => $request->is_active,
        ]);

        // ✅ Pesan sukses update
        return redirect()->route('customer.index')->with('success', '✅ Data pelanggan berhasil diperbarui.');
    }

    /**
     * Hapus pelanggan
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        // ✅ Pesan sukses hapus
        return redirect()->route('customer.index')->with('success', '🗑️ Pelanggan berhasil dihapus.');
    }
}
