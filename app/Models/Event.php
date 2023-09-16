<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'nama',
        'tanggal_mulai',
        'tanggal_berakhir',
        'lokasi',
        'poster',
        'penanggung_jawab',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_berakhir' => 'datetime',
    ];

    public function getTotalDonation() {
        $transaksi_total = Transaksi::where('tipe_donasi', 'event')->where('relation_id', $this->id)->count();
        return $transaksi_total;
    }
}
