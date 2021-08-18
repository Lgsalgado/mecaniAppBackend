<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class SolicitudController extends Controller
{

    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function pending()
    {
        return Solicitud::where('state', 'pendiente')->get();
    }
}
