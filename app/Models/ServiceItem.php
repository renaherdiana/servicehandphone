<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceItem extends Model
{
    protected $fillable = ['name', 'price', 'is_active'];

    // ✅ relasi balik ke Service
    public function service_items()
    {
        return $this->belongsToMany(ServiceItem::class)
                    ->withTimestamps();
    }

}
