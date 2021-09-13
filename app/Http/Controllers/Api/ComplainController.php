<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Complain;
use Illuminate\Http\Request;

class ComplainController extends Controller
{

    public function pending($id)
    {
        $queja =Complain::where('state', 'pendiente')
            ->where('mech_id',$id)
            //->with('user')
            ->get();
        return $queja;
    }
    public function approved($id)
    {
        $queja =Complain::where('state', 'aprobado')
            ->where('mech_id',$id)
            //->with('user')
            ->get();
        return $queja;
    }

    public function rejected($id)
    {
        $queja =Complain::where('state', 'rechazado')
            ->where('mech_id',$id)
            //->with('user')
            ->get();
        return $queja;
    }

    public function reject(Request $request, $id)
    {
        // Validar rol administrador
        if (auth()->user()->role !== 'user') {
            return response()->json([
                'success' => false,
                'message' => 'No tiene permisos para ejecutar esta acción'
            ], 403);
        }

        // Buscar promocion y validar si existe
        $queja = Complain::find($id);
        if (!$queja) {
            return response()->json([
                'success' => false,
                'message' => 'La Queja no existe'
            ], 404);
        }
        Complain::find($id)->update(['state' => 'rechazado']);
        return response()->json([
            'success' => true,
            'Promocion' => Complain::find($id)
        ]);
    }
    public function approve(Request $request, $id)
    {
        // Validar rol administrador
        if (auth()->user()->role !== 'user') {
            return response()->json([
                'success' => false,
                'message' => 'No tiene permisos para ejecutar esta acción'
            ], 403);
        }

        // Buscar promocion y validar si existe
        $queja = Complain::find($id);
        if (!$queja) {
            return response()->json([
                'success' => false,
                'message' => 'La Queja no existe'
            ], 404);
        }
        Complain::find($id)->update(['state' => 'aprobado']);
        return response()->json([
            'success' => true,
            'Promocion' => Complain::find($id)
        ]);
    }
    public function answer(Request $request, $id)
    {
        // Validar rol administrador
        if (auth()->user()->role !== 'user') {
            return response()->json([
                'success' => false,
                'message' => 'No tiene permisos para ejecutar esta acción'
            ], 403);
        }

        // Buscar promocion y validar si existe
        $queja = Complain::find($id);
        if (!$queja) {
            return response()->json([
                'success' => false,
                'message' => 'La Queja no existe'
            ], 404);
        }

        Complain::find($id)->update($request->all());
        error_log($request,null);
        return response()->json([
            'success' => true,
            'Promocion' => Complain::find($id)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Complain  $complain
     * @return \Illuminate\Http\Response
     */
    public function show(Complain $complain)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Complain  $complain
     * @return \Illuminate\Http\Response
     */
    public function edit(Complain $complain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Complain  $complain
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Complain $complain)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Complain  $complain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Complain $complain)
    {
        //
    }
}
