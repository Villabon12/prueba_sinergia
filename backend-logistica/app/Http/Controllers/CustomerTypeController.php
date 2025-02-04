<?php

namespace App\Http\Controllers;

use App\Models\CustomerType;
use Illuminate\Http\Request;

class CustomerTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customerTypes = CustomerType::all(); // Obtener todos los tipos de cliente
        return response()->json($customerTypes);
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
            'type' => 'required|string|max:15',
        ]);

        // Crear el tipo de cliente
        $customerType = CustomerType::create($validated);
        return response()->json(['message' => 'Tipo de cliente creado correctamente', 'data' => $customerType], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customerType = CustomerType::findOrFail($id); // Obtener el tipo de cliente
        return response()->json($customerType);
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
        $customerType = CustomerType::findOrFail($id);

        $validated = $request->validate([
            'type' => 'required|string|max:15',
        ]);

        $customerType->update($validated);
        return response()->json(['message' => 'Tipo de cliente actualizado correctamente', 'data' => $customerType]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customerType = CustomerType::findOrFail($id);
        $customerType->delete();
        return response()->json(['message' => 'Tipo de cliente eliminado correctamente']);
    }
}
