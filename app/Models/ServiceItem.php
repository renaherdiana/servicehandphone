<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceItem extends Model
{
    use HasFactory, SoftDeletes; 

    protected $fillable = [
        'name',
        'price',
        'is_active',
    ];

    public function services()
    {
        return $this->hasMany(Service::class, 'service_item_id');
    }
}
