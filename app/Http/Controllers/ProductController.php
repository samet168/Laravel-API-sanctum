<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::all();
        if($products==null){
            return response([
                'status' => false,
                'message'=>"not found",

            ],204);
        }
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
        $Validator = Validator::make($request->all(), [
            'name' => [ 'required', 'string', 'max:255'],
            'desc' => 'required',
            'price' => 'required|numeric',
            'qty' => 'required|integer',
        ]);


        if($Validator->fails()){
            return response([
                'status' => 'error',
                'message'=>"validation error",
                'data' => $Validator->errors()
            ],422);
        }
        else{

        $product = new Product();
        $product->name = $request->name;
        $product->desc = $request->desc;
        $product->price = $request->price;
        $product->qty = $request->qty;
        // $product->image = $request->image;

        if($request->hasFile('image')) {
            $file = $request->file('image');
            //random name img
            $fileName = rand(0,999999999) . '.' . $file->getClientOriginalExtension();
            //move to folder
            $file -> move(public_path('images'),$fileName);
            //save to database
            $product->image = "http://127.0.0.1:8000/images/" . $fileName;

        }
        $product->save();

       
            return response([
                'status' => 'success',
                'message'=>"product created successfully",
                'data' => $product
            ],201);
        }


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
public function GetById(string $id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json([
            'status' => false,
            'message' => "Product not found with ID: $id"
        ], 404);
    }

    return response([
        'status' => true,
        'message' => "Product deleted successfully",
        'data' => $product
    ], 200);
}

public function update(string $id, Request $request)
{
    // 1️⃣ Validate request
    $Validator = Validator::make($request->all(), [
            'name' => [ 'required', 'string', 'max:255'],
            'desc' => 'required',
            'price' => 'required|numeric',
            'qty' => 'required|integer',
        ]);
    if($Validator->fails()){
            return response([
                'status' => 'error',
                'message'=>"validation error",
                'data' => $Validator->errors()
            ],422);
    }

    // 2️⃣ Find product
    $product = Product::find($id);
    if ($product==null) {
        return response()->json([
            'status' => 'error',
            'message' => "Product not found with ID: $id"
        ], 404);
    }
            // $product = new Product();
        $product->name = $request->name;
        $product->desc = $request->desc;
        $product->price = $request->price;
        $product->qty = $request->qty;

        //ពិនិត្យថា request មាន file upload ឈ្មោះ image មកឬអត់
        
        if($request->hasFile('image')) {
                    //ករណីproductមានimg
            if(!$product->image){
                    //http://127.0.0.1:8000/api/product/6 
                    $image = $product->image;//យក Img នៅលើ database

                    //basename = get name img
                    $imageName = basename($image);

                    //យក Img នៅលើ folder images
                    $imagePath = public_path("images/$imageName");
                    if(File::exists($imagePath)){
                        File::delete($imagePath);
                        //delete and unlink =ស្មើរនិងការលុប
                    };
            }
            //ករណីមិនមានimg
            
            $file = $request->file('image');
            //random name img
            $fileName = rand(0,999999999) . '.' . $file->getClientOriginalExtension();
            //move to folder
            $file -> move(public_path('images'),$fileName);
            //save to database
            $product->image = "http://127.0.0.1:8000/images/" . $fileName;

            $product->save();
        
        }
        



    // 4️⃣ Return response
    return response()->json([
        'status' => 'success',
        'message'=> 'Product updated successfully',
        'data' => $product
    ], 200);
}


    /**
     * Remove the specified resource from storage.
     */
    //destroy =delete
    public function destroy(string $id)
    {
        //
        $product = Product::find($id);
        if($product == null){
            return response([
                'status' =>false,
                'message'=>"product not found",
            ],404);
        }
        //delete img
        $image = $product->image;

        $imageName = basename($image);//basename = get name img

        $imagePath = public_path("images/$imageName");//public_path = បង្កើត path ពេញ ទៅកាន់ file នៅក្នុង public/image/។

        if(File::exists($imagePath)){
            File::delete($imagePath);
        };

        $product->delete();//delete product on db

        return response([
            'status' => true,
            'message'=>"product deleted successfully",
        ],200);
    }
}
