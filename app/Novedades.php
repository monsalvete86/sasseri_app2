<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Novedades extends Model
{
    protected $table = 'novedades';
    protected $fillable = ['id','nombre','observacion','link'];

}
