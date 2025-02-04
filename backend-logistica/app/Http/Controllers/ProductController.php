<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('productType')->get(); // Obtener todos los productos con su tipo
        return response()->json($products);
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
            'name' => 'required|string|max:45',
            'description' => 'nullable|string',
            'product_type_id' => 'required|exists:product_types,id',
        ]);

        // Crear el producto
        $product = Product::create($validated);
        return response()->json(['message' => 'Producto creado correctamente', 'data' => $product], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('productType')->findOrFail($id); // Obtener el producto con su tipo
        return response()->json($product);
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
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:45',
            'description' => 'nullable|string',
            'product_type_id' => 'required|exists:product_types,id',
        ]);

        $product->update($validated);
        return response()->json(['message' => 'Producto actualizado correctamente', 'data' => $product]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Producto eliminado correctamente']);
    }
}
