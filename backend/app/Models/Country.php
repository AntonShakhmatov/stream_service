<?php

namespace App\Models;


use MongoDB\Laravel\Eloquent\Model;

class Country extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'countries';

    protected $fillable = ['name', 'flag', 'img_flag'];
}
