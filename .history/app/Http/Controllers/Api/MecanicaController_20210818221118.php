<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mecanica;
use Illuminate\Http\Request;

class MecanicaController extends Controller
{
    public function create(Request $request)
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
    }
}
