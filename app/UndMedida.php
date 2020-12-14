<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UndMedida extends Model
{
    protected $table = 'und_medidas';
    protected $fillable = ['id','nombre'];

    public function articulos()
    {
        return $this->hasMany('App\Articulo');
    }
}
