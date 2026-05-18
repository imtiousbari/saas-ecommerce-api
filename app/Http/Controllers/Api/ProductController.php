<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
// use Illuminate\Http\Request;

class ProductController extends Controller
{
    // GET ALL PRODUCTS
    public function index()
    {
        $products = Product::all();

        return response()->json($products);
    }

    // CREATE PRODUCT
    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'color' => 'nullable|string',
            'sku' => 'required|string|unique:products,sku'
        ],
        [
            'name.required' => 'Product name is required',
            'price.required' => 'Product price is required',
            'price.numeric' => 'Product price must be a number',
            'stock.required' => 'Product stock is required',
            'stock.integer' => 'Product stock must be an integer',
            'color.string' => 'Product color must be a string',
            'sku.required' => 'Product SKU is required',
            'sku.string' => 'Product SKU must be a string',
            'sku.unique' => 'Product SKU must be unique'
        ]);

        // Create product
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'color' => $request->color,
            'sku' => $request->sku
        ]);

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ]);
    }

    // GET SINGLE PRODUCT
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json($product);
    }

    // UPDATE PRODUCT
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        $product->update($request->all());

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ]);
    }

    // DELETE PRODUCT
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }
}
