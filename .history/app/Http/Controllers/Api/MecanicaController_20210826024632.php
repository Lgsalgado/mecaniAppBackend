<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mecanica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MecanicaController extends Controller
{
    public function saveWorkshop(Request $request)
    {
        $fileResult = $request->file('image')->store('apiDocs');
        $mecanica = Mecanica::create([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'service' => $request->service,
            'image' => $fileResult,
            'state' => true,
        ]);
        if (!$mecanica) {
            return response()->json([
                'success' => false,
                'message' => 'No se creó la mecánica, revise los datos'
            ], 500);
        }
        return response()->json([
            'success' => true,
            'solicitud' => $mecanica
        ]);
    }

    public function updateWorkshop(Request $request, $id)
    {
        $fileResult = $request->file('image')->store('apiDocs');
        $mecanica = Mecanica::find($id)->where('user_id', auth()->user()->id);
        if (!$mecanica) {
            return response()->json([
                'success' => false,
                'message' => 'La mecanica no existe o no tiene acceso'
            ], 404);
        }
        $mecanica = Mecanica::find($id)->update($request->all());
        return response()->json([
            'success' => true,
            'result' => Mecanica::find($id),
        ]);
    }

    public function listAll()
    {
        return Mecanica::where('state', true)
            ->with('user')
            ->get();
    }

    public function userWorkshop()
    {
        return Mecanica::find('user_id', auth()->user()->id);
    }

    public function getById($id)
    {
        $mecanica = Mecanica::find($id);
        Log::info($mecanica);
    }

    public function deleteWorkshop($id)
    {
        $mecanica = Mecanica::find($id);
        if (!$mecanica) {
            return response()->json([
                'success' => false,
                'message' => 'La mecanica no existe'
            ], 404);
        }
        // Valida si es el usuario que crea la solicitud o el administrador para poder eliminarla
        if ($mecanica->user_id == auth()->user()->id || auth()->user()->role == 'admin') {
            $mecanica = Mecanica::find($id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'La mecánica ha sido eliminada',
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'No tiene permisos para ejecutar esta acción',
            ], 403);
        }
    }
}
