<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Biodata extends Model
{
    use HasFactory;
    use Searchable;
    protected $table = 'biodata';
    protected $fillable = [
        'phone',
        'phone_wa',
        'status_hubungan',
        'current_address',
        'user_id',
        'pekerjaan',
        'city',
        'province',
        'district',
    ];

    protected $searchableFields = ['*'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
