<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productTypes = ProductType::all(); // Obtener todos los tipos de producto
        return response()->json($productTypes);
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
            'type' => 'required|string|max:45',
        ]);

        // Crear el tipo de producto
        $productType = ProductType::create($validated);
        return response()->json(['message' => 'Tipo de producto creado correctamente', 'data' => $productType], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productType = ProductType::findOrFail($id); // Obtener el tipo de producto
        return response()->json($productType);
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
        $productType = ProductType::findOrFail($id);

        $validated = $request->validate([
            'type' => 'required|string|max:45',
        ]);

        $productType->update($validated);
        return response()->json(['message' => 'Tipo de producto actualizado correctamente', 'data' => $productType]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productType = ProductType::findOrFail($id);
        $productType->delete();
        return response()->json(['message' => 'Tipo de producto eliminado correctamente']);
    }
}
