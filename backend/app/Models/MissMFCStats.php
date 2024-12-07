<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MissMFCStats extends Model
{
    use SoftDeletes;

    protected $fillable = ['upload_date', 'mfc_id', 'name', 'rank', 'archived_at'];


}
