<?php

namespace App\Http\Controllers;

use App\Models\MaritimeShipment;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Port;
use Illuminate\Http\Request;

class MaritimeShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shipments = MaritimeShipment::with('product', 'customer', 'port')->get();
        return response()->json($shipments);
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
