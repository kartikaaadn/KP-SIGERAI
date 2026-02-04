<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'gerai_id',
        'is_active',
        'google_id',
        'avatar',
        'phone',
        'position',
        'organization'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relasi: User milik satu Gerai
     */
    public function gerai(): BelongsTo
    {
        return $this->belongsTo(Gerai::class, 'gerai_id');
    }

    /**
     * Relasi: User mengirim banyak Message
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_user_id');
    }
}
