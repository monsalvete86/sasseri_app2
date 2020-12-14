<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retencion extends Model
{
    protected $table = 'retenciones';
    protected $fillable = ['id','retencion','cuenta','autodeclarante','declarante','monto_base','tipo_mov','usu_crea','estado'];
    // public $timestamps = false;

    public function users()
    {
        return $this->hasMany('App\User');
    }

}
