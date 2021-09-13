<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Promocion;

class PromocionController extends Controller
{
   public function savePromocion(Request $request){
       $fileResult = $request->file('image')->store('apiDocs');
       $promocion = Promocion::create([
           'mech_id' => $request->mech_id,
           'title' => $request->title,
           'description' => $request->description,
           'image' => $fileResult,

       ]);
       if ($promocion) {
           return response()->json([
               'success' => true,
               'Promocion' => $promocion
           ]);
       }
       return response()->json([
           'success' => false,
           'message' => 'La Promocion no pudo enviarse'
       ], 500);
   }
    public function actived($id)
    {
        $promocion = Promocion::where('state', 'activo')
            ->where('mech_id',$id)
            //->with('user')
            ->get();
        return $promocion;
    }
    public function inactived($id)
    {
        $promocion = Promocion::where('state', 'inactivo')
            ->where('mech_id',$id)
            //->with('user')
            ->get();
        return $promocion;
    }

    public function inactivePromocion(Request $request, $id)
    {
        // Validar rol administrador
        if (auth()->user()->role !== 'user') {
            return response()->json([
                'success' => false,
                'message' => 'No tiene permisos para ejecutar esta acción'
            ], 403);
        }

        // Buscar promocion y validar si existe
        $promocion = Promocion::find($id);
        if (!$promocion) {
            return response()->json([
                'success' => false,
                'message' => 'La Promocion no existe'
            ], 404);
        }
        Promocion::find($id)->update(['state' => 'inactivo']);
        return response()->json([
            'success' => true,
            'Promocion' => Promocion::find($id)
        ]);
    }
    public function activePromocion(Request $request, $id)
    {
        // Validar rol administrador
        if (auth()->user()->role !== 'user') {
            return response()->json([
                'success' => false,
                'message' => 'No tiene permisos para ejecutar esta acción'
            ], 403);
        }

        // Buscar promocion y validar si existe
        $promocion = Promocion::find($id);
        if (!$promocion) {
            return response()->json([
                'success' => false,
                'message' => 'La Promocion no existe'
            ], 404);
        }
        Promocion::find($id)->update(['state' => 'activo']);
        return response()->json([
            'success' => true,
            'Promocion' => Promocion::find($id)
        ]);
    }

}
