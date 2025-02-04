<?php

namespace App\Http\Controllers;

use App\Models\TerrestrialShipment;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Warehouse;
use Illuminate\Http\Request;
/**
 * @OA\Info(
 *     title="Logística API",
 *     version="1.0.0",
 *     description="API para la gestión logística terrestre y marítima"
 * )
 */
class TerrestrialShipmentController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/terrestrial-shipments",
     *     summary="Obtiene todos los envíos terrestres",
     *     tags={"Terrestrial Shipments"},
     *     @OA\Response(
     *         response=200,
     *         description="Envíos terrestres encontrados",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/TerrestrialShipment")
     *         )
     *     )
     * )
     */

    // Mostrar todos los envíos terrestres

    public function index()
    {
        $shipments = TerrestrialShipment::with('product', 'customer', 'warehouse')->get();
        return response()->json($shipments);
    }

    /**
     * @OA\Post(
     *     path="/api/terrestrial-shipments",
     *     summary="Crea un nuevo envío terrestre",
     *     tags={"Terrestrial Shipments"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TerrestrialShipment")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Envío terrestre creado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/TerrestrialShipment")
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
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|integer',
            'shipping_price' => 'required|numeric',
            'fleet_plate' => 'required|string',
            'tracking_number' => 'required|string|unique:logistica_terrestre,tracking_number',
        ]);

        // Crear el envío terrestre
        $shipment = TerrestrialShipment::create($validated);

        // Calcular el descuento si es necesario
        $shipment->calculateDiscount();

        return response()->json(['message' => 'Envío terrestre creado correctamente', 'data' => $shipment], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shipment = TerrestrialShipment::with('product', 'customer', 'warehouse')->findOrFail($id);
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
        $shipment = TerrestrialShipment::findOrFail($id);
        
        $validated = $request->validate([
            'quantity' => 'required|integer',
            'shipping_price' => 'required|numeric',
            'fleet_plate' => 'required|string',
        ]);

        $shipment->update($validated);

        // Calcular el descuento si es necesario
        $shipment->calculateDiscount();

        return response()->json(['message' => 'Envío terrestre actualizado correctamente', 'data' => $shipment]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shipment = TerrestrialShipment::findOrFail($id);
        $shipment->delete();

        return response()->json(['message' => 'Envío terrestre eliminado correctamente']);
    }
}
