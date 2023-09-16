<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AngkatanUser extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'angkatan',
        'tipe_angkatan',
        'tahun_kelulusan',
        'user_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'angkatan_users';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function angkatanTerendah()
    {
        return self::min('angkatan');
    }

    public static function angkatanTertinggi()
    {
        return self::max('angkatan');
    }

    public static function hitungAngkatanUnik()
{
    return self::distinct()->count('angkatan');
}
}
