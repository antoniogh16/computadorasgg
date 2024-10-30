<?php

namespace App\Http\Controllers;

use App\Models\Marcas;
use Illuminate\Http\Request;

class MarcasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marcas = Marcas::all();
        return response()->json($marcas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = ['marca' => 'required|string|min:1|max:100'];
        $validator = \Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ],400);
        }
        $marcas = new Marcas($request->input());
        $marcas->save();
        return response()->json([
            'status' => true,
            'message' => 'marca created successfully'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $marcas = Marcas::find($id);
        if (!$marcas) {
            return response()->json(['status' => false, 'message' => 'Equipo no encontrado'], 404);
        }
        return response()->json(['status' => true, 'data' => $marcas]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Marcas $marcas)
{
    $rules = ['marca' => 'required|string|min:1|max:100'];
    $validator = \Validator::make($request->input(), $rules);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()->all()
        ], 400);
    }

    $marcas->fill($request->input());
    $marcas->save();

    return response()->json([
        'status' => true,
        'message' => 'Marca updated successfully'
    ], 200);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Marcas $marcas)
{
    if (!$marcas) {
        return response()->json([
            'status' => false,
            'message' => 'Marca not found'
        ], 404);
    }

    $marcas->delete();

    return response()->json([
        'status' => true,
        'message' => 'Marca deleted successfully'
    ], 200);
}


}
