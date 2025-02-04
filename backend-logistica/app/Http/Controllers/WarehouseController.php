<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\WarehouseType;
use Illuminate\Http\Request;
/**
 * @OA\Info(
 *     title="Logística API",
 *     version="1.0.0",
 *     description="API para la gestión logística terrestre y marítima"
 * )
 */
class WarehouseController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/warehouses",
     *     summary="Obtiene todos los almacenes",
     *     tags={"Warehouses"},
     *     @OA\Response(
     *         response=200,
     *         description="Almacenes encontrados",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Warehouse")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $warehouses = Warehouse::with('warehouseType')->get(); // Obtener todas las bodegas con su tipo
        return response()->json($warehouses);
    }

    /**
     * @OA\Post(
     *     path="/api/warehouses",
     *     summary="Crea un nuevo almacén",
     *     tags={"Warehouses"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Warehouse")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Almacén creado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Warehouse")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en la validación de datos"
     *     )
     * )
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
