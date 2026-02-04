<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = array([
            [
                'name' => 'iphone 14 pro max',
                'desc' => 'this is a apple product',
                'price' => '10000',
                'qty' => '10',
                'image' => null
            ],
            [
                'name' => 'iphone 15 pro max',
                'desc' => 'this is a apple product',
                'price' => '10000',
                'qty' => '10',
                'image' => null
            ],
            [
                'name' => 'iphone 16 pro max',
                'desc' => 'this is a apple product',
                'price' => '10000',
                'qty' => '10',
                'image' => null
            ],[
                'name' => 'iphone 17 pro max',
                'desc' => 'this is a apple product',
                'price' => '10000',
                'qty' => '10',
                'image' => null
            ]
        ]);
        return response([
            'status' => 'success',
            'message'=>"select successfully",
            'data' => $products
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
