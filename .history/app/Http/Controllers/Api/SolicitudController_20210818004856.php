<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class SolicitudController extends Controller
{

    public function pending()
    {
        return Solicitud::where('state', 'pendiente')
            ->with('user')
            ->get();
    }

    public function approved()
    {
        return Solicitud::where('state', 'aprobado')
            ->with('user')
            ->get();
    }

    public function rejected()
    {
        return Solicitud::where('state', 'rechazado')
            ->with('user')
            ->get();
    }

    public function saveRequest(Request $request)
    {
        $fileResult = $request->file('file')->store('apiDocs');
        $solicitud = Solicitud::create([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'type' => $request->type,
            'address' => $request->address,
            'certificate' => $fileResult
        ]);
        if ($solicitud) {
            return response()->json([
                'success' => true,
                'product' => $solicitud
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'La solicitud no pudo enviarse'
        ], 500);
    }

    public function approveRequest(Request $request, $id)
    {
        // Validar rol administrador
        if (auth()->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'No tiene permisos para ejecutar esta acción'
            ], 403);
        }

        // Buscar solicitud y validar si existe
        $solicitud = Solicitud::find($id)->update(['state' => 'approved']);
        if (!$solicitud) {
            return response()->json([
                'success' => false,
                'message' => 'La solicitud no existe'
            ], 404);
        }
    }
}
