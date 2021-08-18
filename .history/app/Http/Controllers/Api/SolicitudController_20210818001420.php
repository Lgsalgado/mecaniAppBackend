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
        $solicitud = Solicitud::create(array_merge(
            $request,
            ['certificate' => $fileResult]
        ));
        if ($solicitud) {
            return response()->json([
                'success' => true,
                'product' => $solicitud
            ]);
        }
        
    }
}
