<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mecanica;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SolicitudController extends Controller
{

    public function findById($id)
    {
        $mecanica = Mecanica::find($id)
            ->where('id', $id)
            ->with('user')
            ->first();
        return $mecanica;
    }

    public function pending()
    {
        return Mecanica::where('state', 'pendiente')
            ->with('user')
            ->get();
    }

    public function approved()
    {
        return Mecanica::where('state', 'aprobado')
            ->with('user')
            ->get();
    }

    public function rejected()
    {
        return Mecanica::where('state', 'rechazado')
            ->with('user')
            ->get();
    }

    public function completed()
    {
        $mecanica = Mecanica::where('state', 'completado')
            ->with('user')
            ->get();
            Log::($mecanica);
    }

    public function saveRequest(Request $request)
    {
        $fileResult = $request->file('certificate')->store('apiDocs');
        $mecanica = Mecanica::create([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'open_hour' => $request->open_hour,
            'close_hour' => $request->close_hour,
            'services' => $request->services,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'certificate' => $fileResult
        ]);
        if ($mecanica) {
            return response()->json([
                'success' => true,
                'Mecanica' => $mecanica
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'La Mecanica no pudo enviarse'
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

        // Buscar Mecanica y validar si existe
        $mecanica = Mecanica::find($id);
        if (!$mecanica) {
            return response()->json([
                'success' => false,
                'message' => 'La Mecanica no existe'
            ], 404);
        }
        Mecanica::find($id)->update(['state' => 'aprobado']);
        return response()->json([
            'success' => true,
            'Mecanica' => Mecanica::find($id)
        ]);
    }

    public function rejectRequest(Request $request, $id)
    {
        // Validar rol administrador
        if (auth()->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'No tiene permisos para ejecutar esta acción'
            ], 403);
        }

        // Buscar Mecanica y validar si existe
        $mecanica = Mecanica::find($id);
        if (!$mecanica) {
            return response()->json([
                'success' => false,
                'message' => 'La Mecanica no existe'
            ], 404);
        }
        Mecanica::find($id)->update(['state' => 'rechazado']);
        return response()->json([
            'success' => true,
            'Mecanica' => Mecanica::find($id)
        ]);
    }

    public function userRequest()
    {
        return Mecanica::where('user_id', auth()->user()->id)->get();
    }

    public function updateRequest(Request $request, $id)
    {
        $fileResult = $request->file('certificate')->store('apiDocs');
        $mecanica = Mecanica::find($id)->where('user_id', auth()->user()->id);
        if (!$mecanica) {
            return response()->json([
                'success' => false,
                'message' => 'La Mecanica no existe o no tiene acceso'
            ], 404);
        }
        $mecanica = Mecanica::find($id)->update([
            'name' => $request->name,
            'type' => $request->type,
            'address' => $request->address,
            'certificate' => $fileResult
        ]);
        return response()->json([
            'success' => true,
            'result' => Mecanica::find($id),
        ]);
    }

    public function deleteRequest(Request $request, $id)
    {
        $mecanica = Mecanica::find($id);
        if (!$mecanica) {
            return response()->json([
                'success' => false,
                'message' => 'La Mecanica no existe'
            ], 404);
        }
        // Valida si es el usuario que crea la Mecanica o el administrador para poder eliminarla
        if ($mecanica->user_id == auth()->user()->id || auth()->user()->role == 'admin') {
            $mecanica = Mecanica::find($id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'La Mecanica ha sido eliminada',
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'No tiene permisos para ejecutar esta acción',
            ], 403);
        }
    }
}
