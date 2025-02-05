<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_penghapusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_penghapusan',
        'no_barang',
        'kode_barcode',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
