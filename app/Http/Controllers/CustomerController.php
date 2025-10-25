<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * 🧾 Tampilkan daftar pelanggan (dengan search)
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $customers = Customer::when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name', 'asc')
            ->get();

        return view('page.customer.index', compact('customers'));
    }

    /**
     * ➕ Form tambah pelanggan
     */
    public function create()
    {
        return view('page.customer.create');
    }

    /**
     * 💾 Simpan pelanggan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        Customer::create($request->only(['name', 'is_active']));

        return redirect()->route('customer.index')
            ->with('success', '✅ Pelanggan baru berhasil ditambahkan.');
    }

    /**
     * 👁️ Detail pelanggan
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return view('page.customer.show', compact('customer'));
    }

    /**
     * ✏️ Form edit pelanggan
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('page.customer.edit', compact('customer'));
    }

    /**
     * 🔄 Update pelanggan
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($request->only(['name', 'is_active']));

        return redirect()->route('customer.index')
            ->with('success', '✅ Data pelanggan berhasil diperbarui.');
    }

    /**
     * 🗑️ Soft Delete pelanggan
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customer.index')
            ->with('success', '🗑️ Pelanggan berhasil dipindahkan ke Trash.');
    }

    /**
     * 🧹 Tampilkan daftar pelanggan di Trash
     */
    public function trash()
    {
        $customers = Customer::onlyTrashed()->get();

        return view('page.customer.trash', compact('customers'));
    }

    /**
     * 🔁 Restore pelanggan dari Trash
     */
    public function restore($id)
    {
        $customer = Customer::onlyTrashed()->findOrFail($id);
        $customer->restore();

        return redirect()->route('customer.trash')
            ->with('success', '✅ Pelanggan berhasil dikembalikan.');
    }

    /**
     * ❌ Hapus permanen pelanggan dari database
     */
    public function forceDelete($id)
    {
        $customer = Customer::onlyTrashed()->findOrFail($id);
        $customer->forceDelete();

        return redirect()->route('customer.trash')
            ->with('success', '❌ Pelanggan berhasil dihapus permanen.');
    }
}
