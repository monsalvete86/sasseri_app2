<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_empresa = $request->session()->get('id_empresa');
        
        if ($buscar==''){
            $personas = Persona::where('id_empresa','=',$id_empresa)->orderBy('id', 'desc')->paginate(20);
        }
        else{
            $personas = Persona::where($criterio, 'like', '%'. $buscar . '%')->where('id_empresa','=',$id_empresa)->orderBy('id', 'desc')->paginate(20);
        }
        

        return [
            'pagination' => [
                'total'        => $personas->total(),
                'current_page' => $personas->currentPage(),
                'per_page'     => $personas->perPage(),
                'last_page'    => $personas->lastPage(),
                'from'         => $personas->firstItem(),
                'to'           => $personas->lastItem(),
            ],
            'personas' => $personas
        ];
    }

    public function selectCliente(Request $request){
       // if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $id_empresa = $request->session()->get('id_empresa');
        /*$clientes = Persona::Where('num_documento', 'like', '%'. $filtro . '%')
        ->orWhere('nombre', 'like', '%'. $filtro . '%')
        ->select('id','nombre','num_documento')
        ->orderBy('nombre', 'asc')->get();
*/
        $cons="select *,case tipo_persona when 'Juridica' then concat(nombre,' - ',num_documento) when 'Natural' then concat(nombre1,' ',nombre2,' ',apellido1,' ',apellido2,' - ',num_documento) when '' then concat(nombre,' - ',num_documento) end as nom_y_ced from personas where nombre like '%$filtro%' or num_documento like '%$filtro%' or nombre1 like '%$filtro%' or nombre2 like '%$filtro%' or apellido1 like '%$filtro%' or apellido2 like '%$filtro%' 
        or concat(nombre1,' ',nombre2,' ',apellido1,' ',apellido2) like '%$filtro%' or concat(nombre1,' ',apellido1,' ',apellido2) like '%$filtro%' or concat(nombre1,' ',nombre2,' ',apellido1) like '%$filtro%' or concat(nombre1,' ',apellido1) like '%$filtro%' or entidad like '%$filtro%' order by nombre asc";
        //echo $cons;

        $clientes = DB::select($cons);
        
        return ['clientes' => $clientes];
    }
    public function selectCliente2(Request $request){
        // if (!$request->ajax()) return redirect('/');
 
         $id = $request->id;
        
         $cons="select *,case tipo_persona when 'Juridica' then concat(nombre,' - ',num_documento) when 'Natural' then concat(nombre1,' ',nombre2,' ',apellido1,' ',apellido2,' - ',num_documento) when '' then concat(nombre,' - ',num_documento) end as nom_y_ced from personas 
         where id = $id and where 'id_empresa'='$id_empresa' order by nombre asc";
         //echo $cons;
         $clientes = DB::select($cons);
         return ['clientes' => $clientes]; 
     }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_usuario = Auth::user()->id;
        $id_empresa = $request->session()->get('id_empresa');

        try{
            $carpetaEmpresa = $id_empresa .'_empresa'; 
            $dirEmpresa = public_path("Empresas/$carpetaEmpresa/ImgPerfil");
            if (!file_exists($dirEmpresa)) mkdir("Empresas/$carpetaEmpresa", 0777);
            if (!file_exists($dirEmpresa)) mkdir($dirEmpresa, 0777);
            
            $arrayExtensiones = array('image/jpg','image/jpeg','image/png','jpg','jpeg','png');
            if($request->hasFile('img'))
            {
                if($request->file('img')->isValid())
                {
                    $nombreImg = $request->img->getClientOriginalName();
                    if(in_array($request->img->extension(), $arrayExtensiones))
                    {
                        $request->img->move($dirEmpresa,$request->img->getClientOriginalName());
                    }
                    else { return false; }
                }
            }
            else
            {
                $dirEmpresa = public_path("img_productos");
                $nombreImg = 'default.png';
            }

            if(!$request->nombre)  $nombre = ''; else    $nombre = $request->nombre;
            if(!$request->nombre1)  $nombre1 = ''; else    $nombre1 = $request->nombre1;
            if(!$request->nombre2)  $nombre2 = ''; else    $nombre2 = $request->nombre2;
            if(!$request->apellido1)  $apellido1 = ''; else    $apellido1 = $request->apellido1;
            if(!$request->apellido2)  $apellido2 = ''; else    $apellido2 = $request->apellido2;
            if($request->digito_verif) {
                $digito_verif = "1";  
                $num_verif = $request->num_verif;  
            }
            else{
                $digito_verif = "0";  
                $num_verif = "";  
            } 

            $digito_verif = json_decode($request->digito_verif);
            $cliente = json_decode($request->cliente);
            $proveedor = json_decode($request->proveedor);

            $archivo = [
                'nombre' => $nombre,
                'tipo_documento' => $request->tipo_documento,
                'num_documento' => $request->num_documento,
                'direccion' => $request->direccion,
                'telefono1' => $request->telefono1,
                'telefono2' => $request->telefono2,
                'celular' => $request->celular,
                'sexo' => $request->sexo,
                'regimen' => $request->regimen,
                'fec_nac' => $request->fec_nac,
                'reside' => $request->reside,
                'representante' => $request->representante,
                'email' => $request->email,
                'email2' => $request->email2,
                'tipo_persona' => $request->tipo_persona,
                'entidad' => $request->entidad,
                'nombre1' => $nombre1,
                'nombre2' => $nombre2,
                'apellido1' => $apellido1,
                'apellido2' => $apellido2,
                'digito_verif' => $digito_verif,
                'num_verif' => $num_verif,
                'autoretenedor' => $request->autoretenedor,
                'declarante' => $request->declarante,
                'cliente' => $cliente,
                'proveedor' => $proveedor,
                'id_vendedor' => $request->id_vendedor,
                'id_zona' => $request->id_zona,
                'plazo_pago' => $request->plazo_pago,
                'bloquear' => $request->bloquear,
                'cupo_credito' => $request->cupo_credito,
                'vr_cupo_credito' => $request->vr_cupo_credito,
                'retenedor_fuente' => $request->retenedor_fuente,
                'retenedor_iva' => $request->retenedor_iva,
                'excluido_iva' => $request->excluido_iva,
                'autoretefuente' => $request->autoretefuente,
                'autoreteiva' => $request->autoreteiva,
                'autoreteica' => $request->autoreteica,
                'id_banco' => $request->id_banco,
                'num_cuenta_banco' => $request->num_cuenta_banco,
                'tipo_cuenta' => $request->tipo_cuenta,
                'representante_cuenta' => $request->representante_cuenta,
                'tipo_nacionalidad' => $request->tipo_nacionalidad,
                'departamento' => $request->departamento,
                'municipio' => $request->municipio,
                'img' => $nombreImg,
                'id_empresa' => $id_empresa,
            ];

            Persona::create($archivo);
        } catch (Exception $e) {
            report ($e);
            return false;
        }
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_usuario = Auth::user()->id;
        $id_empresa = $request->session()->get('id_empresa');

        $persona = Persona::findOrFail($request->id);

        try{
            $carpetaEmpresa = $id_empresa .'_empresa'; 
            $dirEmpresa = public_path("Empresas/$carpetaEmpresa/ImgPerfil");
            if (!file_exists($dirEmpresa)) mkdir("Empresas/$carpetaEmpresa", 0777);
            if (!file_exists($dirEmpresa)) mkdir($dirEmpresa, 0777);
            
            $arrayExtensiones = array('image/jpg','image/jpeg','image/png','jpg','jpeg','png');
            if($request->hasFile('img'))
            {
                if($request->file('img')->isValid())
                {
                    $nombreImg = $request->img->getClientOriginalName();
                    if(in_array($request->img->extension(), $arrayExtensiones))
                    {
                        $request->img->move($dirEmpresa,$request->img->getClientOriginalName());
                    }
                    else { return false; }
                }
            }
            else
            {
                $nombreImg = $persona->img;
            }

            if(!$request->nombre)  $nombre = ''; else    $nombre = $request->nombre;
            if(!$request->nombre1)  $nombre1 = ''; else    $nombre1 = $request->nombre1;
            if(!$request->nombre2)  $nombre2 = ''; else    $nombre2 = $request->nombre2;
            if(!$request->apellido1)  $apellido1 = ''; else    $apellido1 = $request->apellido1;
            if(!$request->apellido2)  $apellido2 = ''; else    $apellido2 = $request->apellido2;
            if($request->digito_verif) {
                $digito_verif = "1";  
                $num_verif = $request->num_verif;  
            }
            else{
                $digito_verif = "0";  
                $num_verif = "";  
            } 
            
            $digito_verif = json_decode($request->digito_verif);
            $cliente = json_decode($request->cliente);
            $proveedor = json_decode($request->proveedor);

            $archivo = [
                'nombre' => $nombre,
                'tipo_documento' => $request->tipo_documento,
                'num_documento' => $request->num_documento,
                'direccion' => $request->direccion,
                'telefono1' => $request->telefono1,
                'telefono2' => $request->telefono2,
                'celular' => $request->celular,
                'sexo' => $request->sexo,
                'regimen' => $request->regimen,
                'fec_nac' => $request->fec_nac,
                'reside' => $request->reside,
                'representante' => $request->representante,
                'email' => $request->email,
                'email2' => $request->email2,
                'tipo_persona' => $request->tipo_persona,
                'entidad' => $request->entidad,
                'nombre1' => $nombre1,
                'nombre2' => $nombre2,
                'apellido1' => $apellido1,
                'apellido2' => $apellido2,
                'digito_verif' => $digito_verif,
                'num_verif' => $num_verif,
                'autoretenedor' => $request->autoretenedor,
                'declarante' => $request->declarante,
                'cliente' => $cliente,
                'proveedor' => $proveedor,
                'id_vendedor' => $request->id_vendedor,
                'id_zona' => $request->id_zona,
                'plazo_pago' => $request->plazo_pago,
                'bloquear' => $request->bloquear,
                'cupo_credito' => $request->cupo_credito,
                'vr_cupo_credito' => $request->vr_cupo_credito,
                'retenedor_fuente' => $request->retenedor_fuente,
                'retenedor_iva' => $request->retenedor_iva,
                'excluido_iva' => $request->excluido_iva,
                'autoretefuente' => $request->autoretefuente,
                'autoreteiva' => $request->autoreteiva,
                'autoreteica' => $request->autoreteica,
                'id_banco' => $request->id_banco,
                'num_cuenta_banco' => $request->num_cuenta_banco,
                'tipo_cuenta' => $request->tipo_cuenta,
                'representante_cuenta' => $request->representante_cuenta,
                'tipo_nacionalidad' => $request->tipo_nacionalidad,
                'departamento' => $request->departamento,
                'municipio' => $request->municipio,
                'img' => $nombreImg,
                'id_empresa' => $id_empresa,
            ];

            $persona->update($archivo);
        } catch (Exception $e) {
            report ($e);
            return false;
        }
    }
}
