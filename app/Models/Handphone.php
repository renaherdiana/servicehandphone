<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Handphone extends Model
{
    use HasFactory, SoftDeletes; 

    protected $fillable = [
        'brand',
        'model',
        'release_year',
        'image',
        'is_active',
    ];

    public function services()
    {
        return $this->hasMany(Service::class, 'handphone_id');
    }
}
