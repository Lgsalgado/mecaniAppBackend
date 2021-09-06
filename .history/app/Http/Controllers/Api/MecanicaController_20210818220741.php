<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MecanicaController extends Controller
{
    public function create(Request $request)
    {
        $fileResult = $request->file('image')->store('apiDocs');
    }
}
