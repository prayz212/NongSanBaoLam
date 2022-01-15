<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admin';

    protected $guarded = 'admin';

    protected $fillable = [
        'username', 'email', 'password', 'fullname',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
