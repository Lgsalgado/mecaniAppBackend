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
                'message' => 'La solicitud no pudo enviarse'
            ], 500);
        }
        return response()->json([
            'success' => true,
            'solicitud' => $mecanica
        ]);
    }
}
