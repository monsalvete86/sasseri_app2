<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = ['id','nombre','tipo_documento','num_documento','direccion','telefono1','telefono2','email','email2','sexo','fec_nac','regimen','reside','representante','tipo_persona','nombre1','nombre2','apellido1','apellido2','digito_verif','entidad','num_verif','autoretenedor','declarante','cliente','proveedor','id_vendedor','id_zona','plazo_pago','bloquear','cupo_credito','vr_cupo_credito','retenedor_fuente','retenedor_iva','excluido_iva','autoretefuente','autoreteiva','autoreteica','id_banco','num_cuenta_banco','tipo_cuenta','representante_cuenta','tipo_nacionalidad','departamento','municipio','img','id_empresa'];

    public function provedor()
    {
        return $this->hasOne('App\Proveedor');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function factura()
    {
        return $this->hasMany('App\Facturacion');
    }
}
