<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Virus extends Model
{
    use HasFactory;

    protected $guarded = array();

    public function tags()
    {
        return $this->hasMany('App\Models\Tag');
    }
}
