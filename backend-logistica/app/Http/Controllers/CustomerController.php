<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
/**
 * @OA\Info(
 *     title="Logística API",
 *     version="1.0.0",
 *     description="API para la gestión logística terrestre y marítima"
 * )
 */
class CustomerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/customers",
     *     summary="Obtiene todos los clientes",
     *     tags={"Customers"},
     *     @OA\Response(
     *         response=200,
     *         description="Clientes encontrados",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Customer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor"
     *     )
     * )
     */
    public function index()
    {
        $customers = Customer::with('customerType')->get(); // Obtener todos los clientes con su tipo
        return response()->json($customers);
    }
   /**
     * @OA\Post(
     *     path="/api/customers",
     *     summary="Crea un nuevo cliente",
     *     tags={"Customers"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cliente creado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
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
            'full_name' => 'required|string|max:55',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:100',
            'email' => 'required|email|unique:customers,email',
            'customer_type_id' => 'required|exists:customer_types,id',
        ]);

        // Crear el cliente
        $customer = Customer::create($validated);
        return response()->json(['message' => 'Cliente creado correctamente', 'data' => $customer], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/customers/{id}",
     *     summary="Obtiene un cliente específico",
     *     tags={"Customers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del cliente",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente no encontrado"
     *     )
     * )
     */
    public function show($id)
    {
        $customer = Customer::with('customerType')->findOrFail($id); // Obtener el cliente con su tipo
        return response()->json($customer);
    }

     /**
     * @OA\Put(
     *     path="/api/customers/{id}",
     *     summary="Actualiza un cliente",
     *     tags={"Customers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del cliente",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente actualizado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente no encontrado"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $validated = $request->validate([
            'full_name' => 'required|string|max:55',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:100',
            'email' => 'required|email|unique:customers,email,' . $id,
            'customer_type_id' => 'required|exists:customer_types,id',
        ]);

        $customer->update($validated);
        return response()->json(['message' => 'Cliente actualizado correctamente', 'data' => $customer]);
    }

    /**
     * @OA\Delete(
     *     path="/api/customers/{id}",
     *     summary="Elimina un cliente",
     *     tags={"Customers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del cliente",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente eliminado correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente no encontrado"
     *     )
     * )
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return response()->json(['message' => 'Cliente eliminado correctamente']);
    }
}
