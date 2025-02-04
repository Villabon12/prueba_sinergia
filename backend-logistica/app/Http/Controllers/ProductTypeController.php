<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use Illuminate\Http\Request;
/**
 * @OA\Tag(name="ProductTypes", description="Gestión de los tipos de producto")
 */
class ProductTypeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/product-types",
     *     summary="Obtiene todos los tipos de productos",
     *     tags={"ProductTypes"},
     *     @OA\Response(
     *         response=200,
     *         description="Listado de tipos de producto",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ProductType"))
     *     )
     * )
     */
    public function index()
    {
        $productTypes = ProductType::all(); // Obtener todos los tipos de producto
        return response()->json($productTypes);
    }

    /**
     * @OA\Post(
     *     path="/api/product-types",
     *     summary="Crea un nuevo tipo de producto",
     *     tags={"ProductTypes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProductType")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tipo de producto creado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/ProductType")
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

        // Crear el tipo de producto
        $productType = ProductType::create($validated);
        return response()->json(['message' => 'Tipo de producto creado correctamente', 'data' => $productType], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/product-types/{id}",
     *     summary="Obtiene un tipo de producto específico",
     *     tags={"ProductTypes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del tipo de producto",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tipo de producto encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/ProductType")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tipo de producto no encontrado"
     *     )
     * )
     */
    public function show($id)
    {
        $productType = ProductType::findOrFail($id); // Obtener el tipo de producto
        return response()->json($productType);
    }

    /**
     * @OA\Put(
     *     path="/api/product-types/{id}",
     *     summary="Actualiza un tipo de producto",
     *     tags={"ProductTypes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del tipo de producto",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProductType")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tipo de producto actualizado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/ProductType")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tipo de producto no encontrado"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $productType = ProductType::findOrFail($id);

        $validated = $request->validate([
            'type' => 'required|string|max:45',
        ]);

        $productType->update($validated);
        return response()->json(['message' => 'Tipo de producto actualizado correctamente', 'data' => $productType]);
    }

    /**
     * @OA\Delete(
     *     path="/api/product-types/{id}",
     *     summary="Elimina un tipo de producto",
     *     tags={"ProductTypes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del tipo de producto",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tipo de producto eliminado correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tipo de producto no encontrado"
     *     )
     * )
     */
    public function destroy($id)
    {
        $productType = ProductType::findOrFail($id);
        $productType->delete();
        return response()->json(['message' => 'Tipo de producto eliminado correctamente']);
    }
}
