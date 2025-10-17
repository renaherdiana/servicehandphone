<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Handphone extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'release_year',
        'image',
        'is_active',
    ];

    /**
     * Relasi ke tabel services
     * Satu handphone bisa punya banyak service
     */
    public function services()
    {
        return $this->hasMany(Service::class, 'handphone_id');
    }
}
