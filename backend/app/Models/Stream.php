<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    protected $fillable = ['name', 'description'];

    public function affiliateLinks()
    {
        return $this->hasMany(AffiliateLink::class);
    }

    public function model()
    {
        return $this->belongsTo(Model::class);
    }
}
