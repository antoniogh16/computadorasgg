<?php

namespace App\Http\Controllers;

use App\Models\Equipos;
use App\Models\Marcas;
use DB;
use Illuminate\Http\Request;

class EquiposController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipos = Equipos::select('equipos.*','marcas.marca as mark')->join('marcas','marcas.id','=','equipos.marcas_id')->paginate(10);
        return response()->json($equipos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = ['ram' => 'required|string|min:1|max:100',
                'procesador' => 'required|string|min:1|max:100',
                'graficos' => 'required|string|min:1|max:100',
                'monitor' => 'required|string|min:1|max:100',
                'hd' => 'required|string|min:1|max:100',
                'descripcion' => 'required|string|min:1|max:100',
                'marcas_id' => 'required|numeric',
                'image_path' => 'nullable|image|max:2048'];
        $validator = \Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ],400);
        }
        // Manejar la subida de la imagen
        if ($request->hasFile('image_path')) {
            $file = $request->file('image_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Verificar si la carpeta public/images existe
            if (!file_exists(public_path('images'))) {
                mkdir(public_path('images'), 0755, true);
            }

            $file->move(public_path('images'), $filename);
            $equipos->image_path = 'images/' . $filename; // Guardar la ruta de la imagen en la base de datos
        }

        $equipos = new Equipos($request->input());
        $equipos->save();
        return response()->json([
            'status' => true,
            'message' => 'equipo created successfully'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $equipos = Equipos::find($id);
        if (!$equipos) {
            return response()->json(['status' => false, 'message' => 'Equipo no encontrado'], 404);
        }
        return response()->json(['status' => true, 'data' => $equipos]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipos $equipos)
    {
        $rules = ['ram' => 'required|string|min:1|max:100',
                'procesador' => 'required|string|min:1|max:100',
                'graficos' => 'required|string|min:1|max:100',
                'monitor' => 'required|string|min:1|max:100',
                'hd' => 'required|string|min:1|max:100',
                'descripcion' => 'required|string|min:1|max:100',
                'marcas_id' => 'required|numeric',
                'image_path' => 'nullable|image|max:2048'];
        $validator = \Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ],400);
        }
        // Manejar la actualización de la imagen si existe
    if ($request->hasFile('image_path')) {
        // Eliminar la imagen anterior si existe
        if ($equipos->image_path && file_exists(public_path($equipos->image_path))) {
            unlink(public_path($equipos->image_path));
        }

        // Subir la nueva imagen
        $file = $request->file('image_path');
        $filename = time() . '_' . $file->getClientOriginalName();
        
        if (!file_exists(public_path('images'))) {
            mkdir(public_path('images'), 0755, true);
        }

        $file->move(public_path('images'), $filename);
        $equipos->image_path = 'images/' . $filename; // Actualizar la ruta de la imagen
    }

        $equipos->save();
        return response()->json([
            'status' => true,
            'message' => 'equipo updated successfully'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipos $equipos)
    {
        // Eliminar la imagen si existe
        if ($equipos->image_path && file_exists(public_path($equipos->image_path))) {
            unlink(public_path($equipos->image_path));
        }

        $equipos->delete();
        return response()->json([
            'status' => true,
            'message' => 'equipo deleted successfully'
        ],200);
    }

    public function EquiposbyMarcas(){
        $equipos = Equipos::select(DB::raw('count(equipos.id) as count, marcas.marca'))->rightJoin('marcas','marcas.id','=','equipos.marcas_id')->groupBy('marcas.marca')->get();
        return response()->json($equipos);
    }

    public function all(){
        
        $equipos = Equipos::select('equipos.*','marcas.marca as mark')->join('marcas','marcas.id','=','equipos.marcas_id')->get();
        return response()->json($equipos);
    }
}
