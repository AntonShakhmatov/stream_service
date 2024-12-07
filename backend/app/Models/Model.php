<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    protected $fillable = ['name', 'rating'];

    public function streams()
    {
        return $this->hasMany(Stream::class);
    }
}
