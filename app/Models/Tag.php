<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $guarded = array();
    public function virus()
    {
        return $this->belongsTo('App\Models\Virus');
    }
}
