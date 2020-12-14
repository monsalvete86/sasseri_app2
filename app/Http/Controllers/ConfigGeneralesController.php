<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ConfigGenerales;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ConfigGeneralesController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_empresa = $request->session()->get('id_empresa');
        
        if ($buscar==''){
            $configgenerales = ConfigGenerales::where('id','=',$id_empresa)->orderBy('id', 'desc')->paginate(6);
        }
        else{
            $configgenerales = ConfigGenerales::where($criterio, 'like', '%'. $buscar . '%')->where('id','=',$id_empresa)->orderBy('id', 'desc')->paginate(6);
        }
        return [
            'pagination' => [
                'total'        => $configgenerales->total(),
                'current_page' => $configgenerales->currentPage(),
                'per_page'     => $configgenerales->perPage(),
                'last_page'    => $configgenerales->lastPage(),
                'from'         => $configgenerales->firstItem(),
                'to'           => $configgenerales->lastItem(),
            ],
            'configgenerales' => $configgenerales,
        ];
    }

    public function store(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $id_usuario = Auth::user()->id;
        $id_empresa = $request->session()->get('id_empresa');

        $carpetaEmpresa = $id_empresa .'_empresa'; 
        $dirEmpresa = public_path("Empresas/$carpetaEmpresa/ImgLogos");
        if (!file_exists($dirEmpresa)) mkdir($dirEmpresa, 0777);

        try{
            $arrayExtensiones = array('image/jpg','image/jpeg','image/png','jpg','jpeg','png');
            if($request->hasFile('logo'))
            {
                if($request->file('logo')->isValid())
                {
                    $nombreLogo = $request->logo->getClientOriginalName();
                    if(in_array($request->logo->extension(), $arrayExtensiones))
                    {
                        $request->logo->move($dirEmpresa,$request->logo->getClientOriginalName());
                    }
                    else { return false; }
                }
            }
            else
            {
                $dirEmpresa = public_path("logos");
                $nombreLogo = 'default.png';
            }

            $archivo = [
                'nombre' => $request->nombre,
                'logo' => $nombreLogo,
                'repre_legal' => $request->repre_legal,
                'nit' => $request->nit,
                'nombre' => $request->nombre,
                'res_fact_elect' => $request->res_fact_elect,
                'res_fact_pos' => $request->res_fact_pos,
                'correo' => $request->correo,
                'celular' => $request->celular,
                'telefono' => $request->telefono,
                'usu_crea' => $id_usuario,
            ];

            ConfigGenerales::create($archivo);
        } catch (Exception $e) {
            report ($e);
            return false;
        }
    }

    /*public function update(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $id_usuario = Auth::user()->id;
        $id_empresa = $request->session()->get('id_empresa');
        
        $config = ConfigGenerales::findOrFail($request->id);

        $carpetaEmpresa = $id_empresa .'_empresa'; 
        $dirEmpresa = public_path("Empresas/$carpetaEmpresa/ImgLogos");
        if (!file_exists($dirEmpresa)) mkdir($dirEmpresa, 0777);

        if(isset($request->logo)){
            if(is_uploaded_file($_FILES['logo']['name']))
            {
                $nombreImg = $_FILES['logo']['name'];
                if($_FILES['logo']['type'] == "image/jpg" || $_FILES['logo']['type'] == "image/jpeg" || $_FILES['logo']['type'] == "image/png")
                {
                    copy($_FILES['logo']['tmp_name'],$dirEmpresa.'/'.$_FILES['logo']['name']);
                }
            }
        }
        else
        {
            $nombreImg = $config->logo;
        }
        
        $archivo = [
            'nombre' => $request->nombre,
            'logo' => $nombreImg,
            'repre_legal' => $request->repre_legal,
            'nit' => $request->nit,
            'nombre' => $request->nombre,
            'res_fact_elect' => $request->res_fact_elect,
            'res_fact_pos' => $request->res_fact_pos,
            'correo' => $request->correo,
            'celular' => $request->celular,
            'telefono' => $request->telefono,
        ];

        $config->update($archivo);
    }*/

    public function update(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $id_usuario = Auth::user()->id;
        $id_empresa = $request->session()->get('id_empresa');

        $carpetaEmpresa = $id_empresa .'_empresa'; 
        $dirEmpresa = public_path("Empresas/$carpetaEmpresa/ImgLogos");
        if (!file_exists($dirEmpresa)) mkdir($dirEmpresa, 0777);

        try{
            $config = ConfigGenerales::findOrFail($request->id);
            
            $arrayExtensiones = array('image/jpg','image/jpeg','image/png','jpg','jpeg','png');
            if($request->hasFile('logo'))
            {
                if($request->file('logo')->isValid())
                {
                    $nombreLogo = $request->logo->getClientOriginalName();
                    if(in_array($request->logo->extension(), $arrayExtensiones))
                    {
                        $request->logo->move($dirEmpresa,$request->logo->getClientOriginalName());
                    }
                    else { return false; }
                }
            }
            else
            {
                $nombreLogo = $config->logo;
            }

            $archivo = [
                'nombre' => $request->nombre,
                'logo' => $nombreLogo,
                'repre_legal' => $request->repre_legal,
                'nit' => $request->nit,
                'res_fact_elect' => $request->res_fact_elect,
                'res_fact_pos' => $request->res_fact_pos,
                'correo' => $request->correo,
                'celular' => $request->celular,
                'telefono' => $request->telefono,
            ];

            $config->update($archivo);
        } catch (Exception $e) {
            report ($e);
            return false;
        }
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $roles = ConfigGenerales::findOrFail($request->id);
        $roles->estado = '0';
        $roles->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $roles = ConfigGenerales::findOrFail($request->id);
        $roles->estado = '1';
        $roles->save();
    }
}
