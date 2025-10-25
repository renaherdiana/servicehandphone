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

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id')->withTrashed();
    }
    
    public function handphone()
    {
        return $this->belongsTo(Handphone::class, 'handphone_id')->withTrashed();
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class, 'technician_id')->withTrashed();
    }

    public function items()
    {
        return $this->belongsToMany(ServiceItem::class, 'service_service_item')
                    ->withPivot(['subtotal'])
                    ->withTimestamps()
                    ->withTrashed(); 
    }

    public function service_items()
    {
        return $this->items();
    }

    public function getTotalCostAttribute()
    {
        $items = $this->relationLoaded('items') ? $this->items : $this->items()->get();

        $itemsTotal = $items->sum(function ($item) {
            return $item->pivot->subtotal ?? ($item->price ?? 0);
        });

        return $itemsTotal + ($this->other_cost ?? 0);
    }
}
