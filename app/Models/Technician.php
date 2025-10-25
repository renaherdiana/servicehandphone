<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Technician extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel di database
     */
    protected $table = 'technicians';

    /**
     * Kolom yang bisa diisi
     */
    protected $fillable = [
        'name',
        'is_active',
    ];

    /**
     * Casting otomatis
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Otomatis timestamps aktif (created_at & updated_at)
     */
    public $timestamps = true;

    /**
     * Relasi ke tabel Service
     * 1 teknisi bisa menangani banyak service
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Accessor — menampilkan status teknisi dalam bentuk teks
     */
    public function getStatusTextAttribute()
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }

    /**
     * Accessor — menampilkan badge status HTML (opsional, untuk langsung di view)
     */
    public function getStatusBadgeAttribute()
    {
        return $this->is_active
            ? '<span class="badge bg-success">Active</span>'
            : '<span class="badge bg-danger">Inactive</span>';
    }
}
