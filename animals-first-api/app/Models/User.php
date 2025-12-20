<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use HasFactory;


    protected $connection = 'mongodb';
    protected $collection = 'users';

    protected $fillable = ['first_name', 'last_name', 'email', 'password'];
    protected $hidden = ['password'];
}
