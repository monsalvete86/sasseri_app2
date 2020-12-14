<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvidenciasEgresos extends Model
{
    protected $table = 'evidencias_egresos';
    protected $fillable = ['id','nombre','observacion','link'];

}
