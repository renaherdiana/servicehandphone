<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'invoice',
        'customer_id',
        'handphone_id',
        'technician_id',
        'cost',
        'status',
        'other_cost',
        'down_payment',
        'payment_amount',
        'paid',
        'change',
        'payment_method',
        'status_paid',
        'received_date',
        'completed_date',
    ];

    /** 🔹 Relasi ke Customer */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /** 🔹 Relasi ke Handphone */
    public function handphone()
    {
        return $this->belongsTo(Handphone::class);
    }

    /** 🔹 Relasi ke Technician */
    public function technician()
    {
        return $this->belongsTo(Technician::class, 'technician_id');
    }

    /** 🔹 Relasi ke ServiceItem (pivot table) */
    public function items()
    {
        return $this->belongsToMany(ServiceItem::class, 'service_service_item')
                    ->withPivot(['subtotal'])
                    ->withTimestamps();
    }

    /** 🔹 Alias (opsional, buat kompatibilitas lama) */
    public function service_items()
    {
        return $this->items();
    }

    /** 🔹 Hitung total biaya semua item + biaya lain */
    public function getTotalCostAttribute()
    {
        // Pastikan relasi items dimuat
        $items = $this->relationLoaded('items') ? $this->items : $this->items()->get();

        $itemsTotal = $items->sum(function ($item) {
            return $item->pivot->subtotal ?? ($item->price ?? 0);
        });

        return $itemsTotal + ($this->other_cost ?? 0);
    }
}
