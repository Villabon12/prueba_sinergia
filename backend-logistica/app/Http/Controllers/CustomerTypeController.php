<?php

namespace App\Http\Controllers;

use App\Models\CustomerType;
use Illuminate\Http\Request;
/**
 * @OA\Info(title="API de Logística", version="1.0")
 * 
 * Controlador para manejar los tipos de clientes.
 * 
 * @OA\Tag(name="CustomerTypes", description="Gestión de los tipos de cliente")
 */
class CustomerTypeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/customer-types",
     *     summary="Obtiene todos los tipos de clientes",
     *     tags={"CustomerTypes"},
     *     @OA\Response(
     *         response=200,
     *         description="Listado de tipos de cliente",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/CustomerType"))
     *     )
     * )
     */
    public function index()
    {
        $customerTypes = CustomerType::all(); // Obtener todos los tipos de cliente
        return response()->json($customerTypes);
    }

    /**
     * @OA\Post(
     *     path="/api/customer-types",
     *     summary="Crea un nuevo tipo de cliente",
     *     tags={"CustomerTypes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CustomerType")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tipo de cliente creado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/CustomerType")
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
            'type' => 'required|string|max:15',
        ]);

        // Crear el tipo de cliente
        $customerType = CustomerType::create($validated);
        return response()->json(['message' => 'Tipo de cliente creado correctamente', 'data' => $customerType], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/customer-types/{id}",
     *     summary="Obtiene un tipo de cliente específico",
     *     tags={"CustomerTypes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del tipo de cliente",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tipo de cliente encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/CustomerType")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tipo de cliente no encontrado"
     *     )
     * )
     */
    public function show($id)
    {
        $customerType = CustomerType::findOrFail($id); // Obtener el tipo de cliente
        return response()->json($customerType);
    }

    /**
     * @OA\Put(
     *     path="/api/customer-types/{id}",
     *     summary="Actualiza un tipo de cliente",
     *     tags={"CustomerTypes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del tipo de cliente",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CustomerType")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tipo de cliente actualizado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/CustomerType")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tipo de cliente no encontrado"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $customerType = CustomerType::findOrFail($id);

        $validated = $request->validate([
            'type' => 'required|string|max:15',
        ]);

        $customerType->update($validated);
        return response()->json(['message' => 'Tipo de cliente actualizado correctamente', 'data' => $customerType]);
    }

    /**
     * @OA\Delete(
     *     path="/api/customer-types/{id}",
     *     summary="Elimina un tipo de cliente",
     *     tags={"CustomerTypes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del tipo de cliente",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tipo de cliente eliminado correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tipo de cliente no encontrado"
     *     )
     * )
     */
    public function destroy($id)
    {
        $customerType = CustomerType::findOrFail($id);
        $customerType->delete();
        return response()->json(['message' => 'Tipo de cliente eliminado correctamente']);
    }
}
