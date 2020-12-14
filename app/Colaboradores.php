<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colaboradores extends Model
{
    protected $table = 'colaboradores';
    protected $fillable = ['id','colaborador','observacion','estado','vendedor','cobrador'];
}
