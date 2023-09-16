<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembangunan extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'nama',
        'tanggal_pembangunan',
        'keterangan',
        'penanggung_jawab',
        'status',
        'image',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'tanggal_pembangunan' => 'datetime',
    ];
}
