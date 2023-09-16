<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'tipe_donasi',
        'relation_id',
        'jumlah_donasi',
        'biaya_admin',
        'total_donasi',
        'merchant_ref',
        'expired_time',
        'status',
        'reference',
        'payment_method',
        'payment_name',
        'pay_code',
        'user_id',
        'qr_url'
    ];

    protected $searchableFields = ['*'];

    protected $table = 'transaksis';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
