<?php


namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // extend Authenticatable
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registration extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'registration'; // your table name

    protected $fillable = [
        'name',
        'email',
        'rollno',
        'password',
        'year',
        'branch',
        'role',
        'google_access_token',
        'google_refresh_token',
        'google_token_expires_at',
    ];

    protected $hidden = [
        'password',
    ];
    public $timestamps = false;
    protected $casts = [
        'google_token_expires_at' => 'datetime',
    ];
}
