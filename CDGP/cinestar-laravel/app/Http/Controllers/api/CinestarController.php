<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CinestarController extends Controller
{
    public function cines ($id = null) {
        $cines = null;
        if ( $id == null ) $cines = DB::select('call sp_getCines');
        else if ( is_numeric($id) ){
                $cines = DB::selectOne('call sp_getCine(?)', [$id]);
                $peliculas = DB::select('call sp_getCinePeliculas(?)', [$id]);
                $tarifas = DB::select('call sp_getCineTarifas(?)', [$id]);

                if ( isset($cines) ) {
                $cines = [
                    'cine' => $cines,
                    'peliculas' => $peliculas,
                    'tarifas' => $tarifas
                ];
            }
        }
        $success = isset($cines);
        $status = $success ? 200 : 404;
        $cines = [
            'success' => $success,
            'data' => $success? $cines : null,
            'message' => $success ? 'Registros encontrados' : 'Registros no encontrados',
            'status' => $status
        ];
        return response()->json($cines,$status);
    }
}
