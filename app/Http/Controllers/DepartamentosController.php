<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Departamentos;
use Illuminate\Support\Facades\Auth;

class DepartamentosController extends Controller
{
    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $departamentos = Departamentos::orderBy('id', 'desc')->get();

        return [
            'departamentos' => $departamentos
        ];
    }
}
