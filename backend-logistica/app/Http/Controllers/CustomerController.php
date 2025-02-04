<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::with('customerType')->get(); // Obtener todos los clientes con su tipo
        return response()->json($customers);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::with('customerType')->findOrFail($id); // Obtener el cliente con su tipo
        return response()->json($customer);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return response()->json(['message' => 'Cliente eliminado correctamente']);
    }
}
