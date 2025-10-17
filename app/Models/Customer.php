<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'customers';

    // Primary key
    protected $primaryKey = 'id';

    // Kolom yang boleh diisi
    protected $fillable = [
        'name',
        'is_active',
    ];

    // Otomatis timestamps (created_at & updated_at)
    public $timestamps = true;

    // Cast agar is_active dibaca sebagai boolean
    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Accessor untuk menampilkan status dalam bentuk teks
    public function getStatusLabelAttribute()
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }
}
