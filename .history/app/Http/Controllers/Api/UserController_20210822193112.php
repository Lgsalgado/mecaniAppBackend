<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function updateUserProfile(Request $request)
    {
        if ($request->password) {
            User::find(auth()->user()->id)
                ->update([
                    'name' => $request->name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                ]);
        } else {
            User::find(auth()->user()->id)
                ->update([
                    'name' => $request->name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'User successfully updated'
        ]);
    }
}
