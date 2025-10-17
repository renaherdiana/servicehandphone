<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class PaymentController extends Controller
{
    /** 🔹 Daftar semua pembayaran servis */
    public function index()
    {
        $services = Service::with(['customer', 'items'])->latest()->get();

        // Pastikan nama pelanggan bisa diakses tanpa error JSON
        foreach ($services as $service) {
            if (is_string($service->customer)) {
                $decoded = json_decode($service->customer, true);
                $service->customer_name = $decoded['name'] ?? '-';
            } else {
                $service->customer_name = $service->customer->name ?? '-';
            }

            // Hitung total biaya (produk + biaya lain)
            $service->total_cost = $service->items->sum('pivot.subtotal') + ($service->other_cost ?? 0);

            // Tentukan status pembayaran otomatis
            $bayar = $service->payment_amount ?? 0;
            if ($bayar == 0) {
                $service->status_paid = 'unpaid';
            } elseif ($bayar > 0 && $bayar < $service->total_cost) {
                $service->status_paid = 'debt';
            } elseif ($bayar >= $service->total_cost) {
                $service->status_paid = 'paid';
            }
        }

        return view('page.payment.list', compact('services'));
    }

    /** 🔹 Form pembayaran */
    public function create($id)
    {
        $service = Service::with(['items', 'customer'])->findOrFail($id);

        // Hitung total otomatis
        $service->total_cost = $service->items->sum('pivot.subtotal') + ($service->other_cost ?? 0);

        return view('page.payment.index', compact('service'));
    }

    /** 🔹 Simpan pembayaran */
    public function store(Request $request, $id)
    {
        $service = Service::with('items')->findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'paid'           => 'required|numeric|min:0',
            'paymentmethod'  => 'nullable|string|max:50',
            'other_cost'     => 'nullable|numeric|min:0',
            'received_date'  => 'nullable|date',
            'completed_date' => 'nullable|date',
        ]);

        // Total biaya dari DB (produk + biaya lain)
        $totalCost = $service->items->sum('pivot.subtotal') + ($validated['other_cost'] ?? 0);

        // Pembayaran sebelumnya (kalau ada)
        $existingPaid = $service->payment_amount ?? 0;
        $paidNow      = $validated['paid'] ?? 0;
        $totalPaid    = $existingPaid + $paidNow;

        // Hitung sisa & kembalian
        $change    = max($totalPaid - $totalCost, 0);
        $remaining = max($totalCost - $totalPaid, 0);

        // Tentukan status pembayaran otomatis
        if ($totalPaid >= $totalCost) {
            $status = 'paid';
        } elseif ($totalPaid > 0) {
            $status = 'debt';
        } else {
            $status = 'unpaid';
        }

        // Simpan ke database
        $service->update([
            'other_cost'     => $validated['other_cost'] ?? 0,
            'total_cost'     => $totalCost,
            'payment_amount' => $totalPaid,
            'change'         => $change,
            'status_paid'    => $status,
            'paymentmethod'  => $validated['paymentmethod'] ?? null,
            'received_date'  => $validated['received_date'] ?? null,
            'completed_date' => $validated['completed_date'] ?? null,
        ]);

        return redirect()->route('payment.index')->with('success', '✅ Pembayaran berhasil disimpan!');
    }

    /** 🔹 Detail pembayaran */
    public function show($id)
    {
        $service = Service::with(['customer', 'items'])->findOrFail($id);

        // Hitung total dan status real-time
        $totalCost = $service->items->sum('pivot.subtotal') + ($service->other_cost ?? 0);
        $bayar = $service->payment_amount ?? 0;

        if ($bayar == 0) {
            $status = 'unpaid';
        } elseif ($bayar > 0 && $bayar < $totalCost) {
            $status = 'debt';
        } else {
            $status = 'paid';
        }

        $service->status_paid = $status;
        $service->total_cost = $totalCost;

        return view('page.payment.show', compact('service'));
    }
}
