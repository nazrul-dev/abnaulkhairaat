<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatRead extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['chats_angkatan_id', 'user_id'];

    protected $searchableFields = ['*'];

    protected $table = 'chat_reads';

    public function chatsAngkatan()
    {
        return $this->belongsTo(ChatsAngkatan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
