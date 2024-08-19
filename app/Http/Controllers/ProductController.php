<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    public function index()
    {
        return view('pages.dashboard.product-page');
    }

    public function showAllProducts()
    {
        return Product::all();
    }

    public function storeProduct(Request $request)
    {
        try {
            // process image upload
            $user_id = $request->header('id');
            $img_path = '';

            $img = $request->file('img');
            $t=time();
            $file_name = $img->getClientOriginalName();
            
            $img_name = "{$user_id}-{$t}-{$file_name}";

            $img_path = "uploads/{$img_name}";

            // upload file

            $img->move(public_path('uploads'), $img_name);


            $product = new Product();
            $product->user_id = $user_id;
            $product->category_id =  $request->category_id;
            $product->name =  $request->name;
            $product->price =  $request->price;
            $product->unit =  $request->unit;
            $product->img_url =  $img_path;
            $product->save();
            

            return response()->json([
                'status' => 'success',
                'message' => 'Product added succssfully',
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
