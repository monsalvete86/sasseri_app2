<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Municipios;
use Illuminate\Support\Facades\Auth;

class MunicipiosController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $municipios = Municipios::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $municipios = Municipios::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $municipios->total(),
                'current_page' => $municipios->currentPage(),
                'per_page'     => $municipios->perPage(),
                'last_page'    => $municipios->lastPage(),
                'from'         => $municipios->firstItem(),
                'to'           => $municipios->lastItem(),
            ],
            'municipios' => $municipios
        ];
    }

    public function listarMunicipios(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $municipios = Municipios::where('id_departamento','=', $request->id)->get();

        return ['municipios' => $municipios];
    }
}
