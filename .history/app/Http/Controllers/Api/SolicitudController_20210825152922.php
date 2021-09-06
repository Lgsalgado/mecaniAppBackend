<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SolicitudController extends Controller
{

    public function findById($id)
    {
        $file = Storage::disk('public')->get();
        Log::info($file);
        Log::info(Solicitud::find($id));
        return Solicitud::find($id);
    }

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
        Log::info($request);
        $fileResult = $request->file('certificate')->store('apiDocs');
        $solicitud = Solicitud::create([
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
        if ($solicitud) {
            return response()->json([
                'success' => true,
                'solicitud' => $solicitud
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
        $solicitud = Solicitud::find($id);
        if (!$solicitud) {
            return response()->json([
                'success' => false,
                'message' => 'La solicitud no existe'
            ], 404);
        }
        Solicitud::find($id)->update(['state' => 'aprobado']);
        return response()->json([
            'success' => true,
            'solicitud' => Solicitud::find($id)
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

        // Buscar solicitud y validar si existe
        $solicitud = Solicitud::find($id);
        if (!$solicitud) {
            return response()->json([
                'success' => false,
                'message' => 'La solicitud no existe'
            ], 404);
        }
        Solicitud::find($id)->update(['state' => 'rechazado']);
        return response()->json([
            'success' => true,
            'solicitud' => Solicitud::find($id)
        ]);
    }

    public function userRequest()
    {
        return Solicitud::where('user_id', auth()->user()->id)->get();
    }

    public function updateRequest(Request $request, $id)
    {
        $fileResult = $request->file('certificate')->store('apiDocs');
        $solicitud = Solicitud::find($id)->where('user_id', auth()->user()->id);
        if (!$solicitud) {
            return response()->json([
                'success' => false,
                'message' => 'La solicitud no existe o no tiene acceso'
            ], 404);
        }
        $solicitud = Solicitud::find($id)->update([
            'name' => $request->name,
            'type' => $request->type,
            'address' => $request->address,
            'certificate' => $fileResult
        ]);
        return response()->json([
            'success' => true,
            'result' => Solicitud::find($id),
        ]);
    }

    public function deleteRequest(Request $request, $id)
    {
        $solicitud = Solicitud::find($id);
        if (!$solicitud) {
            return response()->json([
                'success' => false,
                'message' => 'La solicitud no existe'
            ], 404);
        }
        // Valida si es el usuario que crea la solicitud o el administrador para poder eliminarla
        if ($solicitud->user_id == auth()->user()->id || auth()->user()->role == 'admin') {
            $solicitud = Solicitud::find($id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'La solicitud ha sido eliminada',
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'No tiene permisos para ejecutar esta acción',
            ], 403);
        }
    }
}
