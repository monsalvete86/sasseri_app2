<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bancos extends Model
{
    protected $table = 'bancos';
    protected $fillable = ['id','nombre','estado'];
}
