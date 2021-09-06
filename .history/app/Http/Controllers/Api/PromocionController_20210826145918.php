<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PromocionController extends Controller
{
    public function save(Request $request, $id) {
        Log::info($id)
    }
}
