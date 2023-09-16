<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatsAngkatan extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['user_id', 'pesan', 'angkatan', 'tipe_angkatan'];

    protected $searchableFields = ['*'];

    protected $table = 'chats_angkatans';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chatReads()
    {
        return $this->hasMany(ChatRead::class);
    }
}
