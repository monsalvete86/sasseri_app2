<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cajas extends Model
{
    protected $table = 'cajas';
    protected $fillable = ['id','nombre'];
}
