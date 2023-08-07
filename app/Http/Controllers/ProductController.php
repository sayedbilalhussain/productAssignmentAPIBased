<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ProductCollection(Product::paginate(50));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts|max:100',
            'description' => 'required|max:100',
            'price' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 400]);
        }

        Product::create($request->all());

        return response()->json(
            ['message' => "success created"],
            200
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'title' => [
                'required',
                'max:100',
                Rule::unique('products')->ignore($product->id),
            ],
            'description' => 'required|max:100',
            'price' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 400]);
        }

        $product->update($request->all());

        return response()->json(
            ['message' => "success updated"],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(
            ['message' => "success updated"],
            200
        );
    }
}
