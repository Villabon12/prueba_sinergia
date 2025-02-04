<?php

namespace App\Http\Controllers;

use App\Models\WarehouseType;
use Illuminate\Http\Request;

class WarehouseTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouseTypes = WarehouseType::all(); // Obtener todos los tipos de bodega
        return response()->json($warehouseTypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:45',
        ]);

        // Crear el tipo de bodega
        $warehouseType = WarehouseType::create($validated);
        return response()->json(['message' => 'Tipo de bodega creado correctamente', 'data' => $warehouseType], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $warehouseType = WarehouseType::findOrFail($id); // Obtener el tipo de bodega
        return response()->json($warehouseType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $warehouseType = WarehouseType::findOrFail($id);

        $validated = $request->validate([
            'type' => 'required|string|max:45',
        ]);

        $warehouseType->update($validated);
        return response()->json(['message' => 'Tipo de bodega actualizado correctamente', 'data' => $warehouseType]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $warehouseType = WarehouseType::findOrFail($id);
        $warehouseType->delete();
        return response()->json(['message' => 'Tipo de bodega eliminado correctamente']);
    }
}
