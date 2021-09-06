<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mecanica;
use Illuminate\Http\Request;

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
    }
}
