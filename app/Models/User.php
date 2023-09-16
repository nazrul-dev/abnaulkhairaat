<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'email', 'password', 'avatar', 'isadmin','isbiodata'];

    protected $searchableFields = ['*'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'isadmin' => 'boolean',
        'isbiodata' => 'boolean',
    ];

    public function angkatanUsers()
    {
        return $this->hasMany(AngkatanUser::class);
    }

    public function biodata()
    {
        return $this->hasOne(Biodata::class);
    }

    public function sender()
    {
        return $this->hasMany(ChatsAngkatan::class);
    }

    public function chatReads()
    {
        return $this->hasMany(ChatRead::class);
    }

    public function isSuperAdmin()
    {
        return in_array($this->email, config('auth.super_admins'));
    }
}
