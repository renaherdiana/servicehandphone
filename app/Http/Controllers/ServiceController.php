<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceItem;
use App\Models\Handphone;
use App\Models\Customer;
use App\Models\Technician;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /** 🔹 Daftar Servis */
    public function index()
    {
        $services = Service::with(['handphone', 'customer', 'technician'])
            ->latest()
            ->get();

        return view('page.services.index', compact('services'));
    }

    /** 🔹 Form Tambah Servis */
    public function create()
    {
        $serviceItems = ServiceItem::where('is_active', 1)->get();
        $handphones   = Handphone::where('is_active', 1)->get();
        $customers    = Customer::where('is_active', 1)->get();
        $technicians  = Technician::where('is_active', 1)->get();

        return view('page.services.create', compact('serviceItems', 'handphones', 'customers', 'technicians'));
    }

    /** 🔹 Simpan Servis Baru */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice'            => 'required|string|max:255|unique:services,invoice',
            'customer_id'        => 'required|exists:customers,id',
            'handphone_id'       => 'required|exists:handphones,id',
            'technician_id'      => 'required|exists:technicians,id',
            'payment_amount'     => 'nullable|numeric|min:0',
            'payment_method'     => 'nullable|string|max:50',
            'products'           => 'array',
            'products.*.id'      => 'required|exists:service_items,id',
            'products.*.subtotal'=> 'required|numeric|min:0',
        ]);

        $validated['payment_amount'] = $validated['payment_amount'] ?? 0;

        // 🔹 Hitung total biaya dari produk
        $totalCost = collect($validated['products'] ?? [])->sum('subtotal');

        // 🔹 Tentukan status pembayaran otomatis
        $statusPaid = 'unpaid';
        if ($validated['payment_amount'] >= $totalCost && $totalCost > 0) {
            $statusPaid = 'paid';
        } elseif ($validated['payment_amount'] > 0 && $validated['payment_amount'] < $totalCost) {
            $statusPaid = 'debt';
        }

        // 🔹 Simpan data utama servis
        $service = Service::create([
            'invoice'        => $validated['invoice'],
            'customer_id'    => $validated['customer_id'],
            'handphone_id'   => $validated['handphone_id'],
            'technician_id'  => $validated['technician_id'],
            'cost'           => $totalCost,
            'status'         => 'accepted', // otomatis
            'payment_amount' => $validated['payment_amount'],
            'payment_method' => $validated['payment_method'],
            'status_paid'    => $statusPaid, // ✅ otomatis
        ]);

        // 🔹 Simpan relasi pivot (service_items)
        if (!empty($validated['products'])) {
            $syncData = [];
            foreach ($validated['products'] as $prod) {
                $syncData[$prod['id']] = [
                    'subtotal' => $prod['subtotal'],
                ];
            }
            $service->items()->sync($syncData);
        }

        return redirect()->route('service')->with('success', '✅ Servis baru berhasil ditambahkan!');
    }

    /** 🔹 Detail Servis */
    public function show($id)
    {
        $service = Service::with(['items', 'handphone', 'customer', 'technician'])
            ->findOrFail($id);

        return view('page.services.show', compact('service'));
    }

    /** 🔹 Form Edit Servis */
    public function edit($id)
    {
        $service     = Service::with(['items', 'handphone', 'customer', 'technician'])->findOrFail($id);
        $allItems    = ServiceItem::where('is_active', 1)->get();
        $handphones  = Handphone::where('is_active', 1)->get();
        $customers   = Customer::where('is_active', 1)->get();
        $technicians = Technician::where('is_active', 1)->get();

        return view('page.services.edit', compact('service', 'allItems', 'handphones', 'customers', 'technicians'));
    }

    /** 🔹 Update Servis */
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'invoice'            => 'required|string|max:255|unique:services,invoice,' . $service->id,
            'customer_id'        => 'required|exists:customers,id',
            'handphone_id'       => 'required|exists:handphones,id',
            'technician_id'      => 'required|exists:technicians,id',
            'payment_amount'     => 'nullable|numeric|min:0',
            'payment_method'     => 'nullable|string|max:50',
            'products'           => 'array',
            'products.*.id'      => 'required|exists:service_items,id',
            'products.*.subtotal'=> 'required|numeric|min:0',
        ]);

        $validated['payment_amount'] = $validated['payment_amount'] ?? 0;

        // 🔹 Hitung ulang total biaya
        $totalCost = collect($validated['products'] ?? [])->sum('subtotal');

        // 🔹 Tentukan status pembayaran otomatis
        $statusPaid = 'unpaid';
        if ($validated['payment_amount'] >= $totalCost && $totalCost > 0) {
            $statusPaid = 'paid';
        } elseif ($validated['payment_amount'] > 0 && $validated['payment_amount'] < $totalCost) {
            $statusPaid = 'debt';
        }

        // 🔹 Update data utama servis
        $service->update([
            'invoice'        => $validated['invoice'],
            'customer_id'    => $validated['customer_id'],
            'handphone_id'   => $validated['handphone_id'],
            'technician_id'  => $validated['technician_id'],
            'cost'           => $totalCost,
            'payment_amount' => $validated['payment_amount'],
            'payment_method' => $validated['payment_method'],
            'status_paid'    => $statusPaid, // ✅ otomatis juga saat update
        ]);

        // 🔹 Update relasi pivot
        $syncData = [];
        if (!empty($validated['products'])) {
            foreach ($validated['products'] as $prod) {
                $syncData[$prod['id']] = [
                    'subtotal' => $prod['subtotal'],
                ];
            }
            $service->items()->sync($syncData);
        }

        return redirect()->route('service')->with('success', '✅ Data servis berhasil diperbarui!');
    }

    /** 🔹 Hapus Servis */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->items()->detach();
        $service->delete();

        return redirect()->route('service')->with('success', '🗑️ Servis berhasil dihapus!');
    }
}
