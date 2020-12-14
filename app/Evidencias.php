<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evidencias extends Model
{
    protected $table = 'evidencias_ingresos';
    protected $fillable = ['id','nombre','observacion','link'];

}
