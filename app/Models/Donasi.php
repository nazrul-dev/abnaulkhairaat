<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donasi extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['jumlah', 'hidden_donator', 'bukti'];

    protected $searchableFields = ['*'];

    protected $casts = [
        'hidden_donator' => 'boolean',
    ];



}
