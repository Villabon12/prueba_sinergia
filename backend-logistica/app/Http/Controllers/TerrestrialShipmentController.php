<?php

namespace App\Http\Controllers;

use App\Models\TerrestrialShipment;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Warehouse;
use Illuminate\Http\Request;
class TerrestrialShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // Mostrar todos los envíos terrestres

    public function index()
    {
        $shipments = TerrestrialShipment::with('product', 'customer', 'warehouse')->get();
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
