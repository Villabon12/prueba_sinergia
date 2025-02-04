<?php

namespace App\Http\Controllers;

use App\Models\MaritimeShipment;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Port;
use Illuminate\Http\Request;
/**
 * @OA\Info(
 *     title="Logística API",
 *     version="1.0.0",
 *     description="API para la gestión logística terrestre y marítima"
 * )
 */
class MaritimeShipmentController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/maritime-shipments",
     *     summary="Obtiene todos los envíos marítimos",
     *     tags={"Maritime Shipments"},
     *     @OA\Response(
     *         response=200,
     *         description="Envíos marítimos encontrados",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/MaritimeShipment")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $shipments = MaritimeShipment::with('product', 'customer', 'port')->get();
        return response()->json($shipments);
    }
    /**
     * @OA\Post(
     *     path="/api/maritime-shipments",
     *     summary="Crea un nuevo envío marítimo",
     *     tags={"Maritime Shipments"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/MaritimeShipment")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Envío marítimo creado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/MaritimeShipment")
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
            'product_id' => 'required|exists:products,id',
            'customer_id' => 'required|exists:customers,id',
            'port_id' => 'required|exists:ports,id',
            'quantity' => 'required|integer',
            'shipping_price' => 'required|numeric',
            'fleet_number' => 'required|string',
            'tracking_number' => 'required|string|unique:logistica_maritima,tracking_number',
        ]);

        // Crear el envío marítimo
        $shipment = MaritimeShipment::create($validated);

        // Calcular el descuento si es necesario
        $shipment->calculateDiscount();

        return response()->json(['message' => 'Envío marítimo creado correctamente', 'data' => $shipment], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shipment = MaritimeShipment::with('product', 'customer', 'port')->findOrFail($id);
        return response()->json($shipment);
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
        $shipment = MaritimeShipment::findOrFail($id);
        
        $validated = $request->validate([
            'quantity' => 'required|integer',
            'shipping_price' => 'required|numeric',
            'fleet_number' => 'required|string',
        ]);

        $shipment->update($validated);

        // Calcular el descuento si es necesario
        $shipment->calculateDiscount();

        return response()->json(['message' => 'Envío marítimo actualizado correctamente', 'data' => $shipment]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shipment = MaritimeShipment::findOrFail($id);
        $shipment->delete();

        return response()->json(['message' => 'Envío marítimo eliminado correctamente']);
    }
}
