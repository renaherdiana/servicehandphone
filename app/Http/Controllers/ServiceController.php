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
    /** 🔹 List all services (dengan pencarian) */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $services = Service::with(['handphone', 'customer', 'technician'])
            ->when($search, function ($query, $search) {
                $query->where('invoice', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('handphone', function ($q) use ($search) {
                        $q->where('brand', 'like', "%{$search}%")
                          ->orWhere('model', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->get();

        return view('page.services.index', compact('services', 'search'));
    }

    /** 🔹 Show form to create a new service */
    public function create()
    {
        $serviceItems = ServiceItem::where('is_active', 1)->get();
        $handphones   = Handphone::where('is_active', 1)->get();
        $customers    = Customer::where('is_active', 1)->get();
        $technicians  = Technician::where('is_active', 1)->get();

        return view('page.services.create', compact('serviceItems', 'handphones', 'customers', 'technicians'));
    }

    /** 🔹 Store new service */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice'             => 'required|string|max:255|unique:services,invoice',
            'customer_id'         => 'required|exists:customers,id',
            'handphone_id'        => 'required|exists:handphones,id',
            'technician_id'       => 'required|exists:technicians,id',
            'payment_amount'      => 'nullable|numeric|min:0',
            'payment_method'      => 'nullable|string|max:50',
            'products'            => 'array',
            'products.*.id'       => 'required|exists:service_items,id',
            'products.*.subtotal' => 'required|numeric|min:0',
        ]);

        $validated['payment_amount'] = $validated['payment_amount'] ?? 0;

        $totalCost = collect($validated['products'] ?? [])->sum('subtotal');

        $statusPaid = 'unpaid';
        if ($validated['payment_amount'] >= $totalCost && $totalCost > 0) {
            $statusPaid = 'paid';
        } elseif ($validated['payment_amount'] > 0 && $validated['payment_amount'] < $totalCost) {
            $statusPaid = 'debt';
        }

        $service = Service::create([
            'invoice'        => $validated['invoice'],
            'customer_id'    => $validated['customer_id'],
            'handphone_id'   => $validated['handphone_id'],
            'technician_id'  => $validated['technician_id'],
            'cost'           => $totalCost,
            'status'         => 'accepted',
            'payment_amount' => $validated['payment_amount'],
            'payment_method' => $validated['payment_method'],
            'status_paid'    => $statusPaid,
        ]);

        if (!empty($validated['products'])) {
            $syncData = [];
            foreach ($validated['products'] as $prod) {
                $syncData[$prod['id']] = ['subtotal' => $prod['subtotal']];
            }
            $service->items()->sync($syncData);
        }

        return redirect()->route('service')->with('success', '✅ New service successfully added!');
    }

    /** 🔹 Show service details */
    public function show($id)
    {
        $service = Service::with(['items', 'handphone', 'customer', 'technician'])->findOrFail($id);
        return view('page.services.show', compact('service'));
    }

    /** 🔹 Edit service form */
    public function edit($id)
    {
        $service     = Service::with(['items', 'handphone', 'customer', 'technician'])->findOrFail($id);
        $allItems    = ServiceItem::where('is_active', 1)->get();
        $handphones  = Handphone::where('is_active', 1)->get();
        $customers   = Customer::where('is_active', 1)->get();
        $technicians = Technician::where('is_active', 1)->get();

        return view('page.services.edit', compact('service', 'allItems', 'handphones', 'customers', 'technicians'));
    }

    /** 🔹 Update service */
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'invoice'             => 'required|string|max:255|unique:services,invoice,' . $service->id,
            'customer_id'         => 'required|exists:customers,id',
            'handphone_id'        => 'required|exists:handphones,id',
            'technician_id'       => 'required|exists:technicians,id',
            'payment_amount'      => 'nullable|numeric|min:0',
            'payment_method'      => 'nullable|string|max:50',
            'status'              => 'required|string|in:accepted,process,finished,taken,cancelled',
            'products'            => 'array',
            'products.*.id'       => 'required|exists:service_items,id',
            'products.*.subtotal' => 'required|numeric|min:0',
        ]);

        $validated['payment_amount'] = $validated['payment_amount'] ?? 0;

        $totalCost = collect($validated['products'] ?? [])->sum('subtotal');

        $statusPaid = 'unpaid';
        if ($validated['payment_amount'] >= $totalCost && $totalCost > 0) {
            $statusPaid = 'paid';
        } elseif ($validated['payment_amount'] > 0 && $validated['payment_amount'] < $totalCost) {
            $statusPaid = 'debt';
        }

        $service->update([
            'invoice'        => $validated['invoice'],
            'customer_id'    => $validated['customer_id'],
            'handphone_id'   => $validated['handphone_id'],
            'technician_id'  => $validated['technician_id'],
            'cost'           => $totalCost,
            'status'         => $validated['status'],
            'payment_amount' => $validated['payment_amount'],
            'payment_method' => $validated['payment_method'],
            'status_paid'    => $statusPaid,
        ]);

        $syncData = [];
        if (!empty($validated['products'])) {
            foreach ($validated['products'] as $prod) {
                $syncData[$prod['id']] = ['subtotal' => $prod['subtotal']];
            }
            $service->items()->sync($syncData);
        }

        return redirect()->route('service')->with('success', '✅ Service updated successfully!');
    }

    /** 🔹 Delete service */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->items()->detach();
        $service->delete();

        return redirect()->route('service')->with('success', '🗑️ Service successfully deleted!');
    }
}
