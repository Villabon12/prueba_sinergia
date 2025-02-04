<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\WarehouseType;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouses = Warehouse::with('warehouseType')->get(); // Obtener todas las bodegas con su tipo
        return response()->json($warehouses);
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
            'name' => 'required|string|max:45',
            'location' => 'required|string|max:100',
            'storage_capacity' => 'required|integer',
            'warehouse_type_id' => 'required|exists:warehouse_types,id',
        ]);

        // Crear la bodega
        $warehouse = Warehouse::create($validated);
        return response()->json(['message' => 'Bodega creada correctamente', 'data' => $warehouse], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $warehouse = Warehouse::with('warehouseType')->findOrFail($id); // Obtener la bodega con su tipo
        return response()->json($warehouse);
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
        $warehouse = Warehouse::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:45',
            'location' => 'required|string|max:100',
            'storage_capacity' => 'required|integer',
            'warehouse_type_id' => 'required|exists:warehouse_types,id',
        ]);

        $warehouse->update($validated);
        return response()->json(['message' => 'Bodega actualizada correctamente', 'data' => $warehouse]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->delete();
        return response()->json(['message' => 'Bodega eliminada correctamente']);
    }
}
