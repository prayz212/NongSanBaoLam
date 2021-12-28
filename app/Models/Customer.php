<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'customer';

    protected $fillable = [
        'username', 'email', 'password', 'fullname', 'phone', 'address',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
