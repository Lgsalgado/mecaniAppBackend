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
        return Solicitud::where('state', 'pendiente')->user()->get();
    }
}
