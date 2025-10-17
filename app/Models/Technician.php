<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    use HasFactory;

    protected $table = 'technicians'; // nama tabel di database

    protected $fillable = [
        'name',
        'is_active',
    ];

    // 🔹 Optional: accessor untuk ubah nilai status jadi teks (biar gampang dipakai di view)
    public function getStatusTextAttribute()
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }
    public function services()
    {
        return $this->hasMany(Service::class);
    }

}
