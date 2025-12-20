<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Pet extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'pets';

    protected $fillable = ['name', 'species', 'age', 'adopted', 'location', 'gender', 'breed'];
}
