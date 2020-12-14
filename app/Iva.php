<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Iva extends Model
{
    protected $table = 'iva';
    protected $fillable = ['id','nombre','tipo','porcentaje','estado'];
}
