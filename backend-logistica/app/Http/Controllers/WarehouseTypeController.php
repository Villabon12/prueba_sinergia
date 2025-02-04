<?php

namespace App\Http\Controllers;

use App\Models\WarehouseType;
use Illuminate\Http\Request;
/**
 * @OA\Tag(name="WarehouseTypes", description="Gestión de los tipos de almacenes")
 */
class WarehouseTypeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/warehouse-types",
     *     summary="Obtiene todos los tipos de almacenes",
     *     tags={"WarehouseTypes"},
     *     @OA\Response(
     *         response=200,
     *         description="Listado de tipos de almacén",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/WarehouseType"))
     *     )
     * )
     */
    public function index()
    {
        $warehouseTypes = WarehouseType::all(); // Obtener todos los tipos de bodega
        return response()->json($warehouseTypes);
    }

    /**
     * @OA\Post(
     *     path="/api/warehouse-types",
     *     summary="Crea un nuevo tipo de almacén",
     *     tags={"WarehouseTypes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/WarehouseType")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tipo de almacén creado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/WarehouseType")
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
            'type' => 'required|string|max:45',
        ]);

        // Crear el tipo de bodega
        $warehouseType = WarehouseType::create($validated);
        return response()->json(['message' => 'Tipo de bodega creado correctamente', 'data' => $warehouseType], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/warehouse-types/{id}",
     *     summary="Obtiene un tipo de almacén específico",
     *     tags={"WarehouseTypes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del tipo de almacén",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tipo de almacén encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/WarehouseType")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tipo de almacén no encontrado"
     *     )
     * )
     */
    public function show($id)
    {
        $warehouseType = WarehouseType::findOrFail($id); // Obtener el tipo de bodega
        return response()->json($warehouseType);
    }
    /**
     * @OA\Put(
     *     path="/api/warehouse-types/{id}",
     *     summary="Actualiza un tipo de almacén",
     *     tags={"WarehouseTypes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del tipo de almacén",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/WarehouseType")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tipo de almacén actualizado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/WarehouseType")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tipo de almacén no encontrado"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/warehouse-types/{id}",
     *     summary="Elimina un tipo de almacén",
     *     tags={"WarehouseTypes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del tipo de almacén",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tipo de almacén eliminado correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tipo de almacén no encontrado"
     *     )
     * )
     */
    public function destroy($id)
    {
        $warehouseType = WarehouseType::findOrFail($id);
        $warehouseType->delete();
        return response()->json(['message' => 'Tipo de bodega eliminado correctamente']);
    }
}
