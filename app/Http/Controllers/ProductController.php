<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{


    public function index()
    {
        return view('pages.dashboard.product-page');
    }

    public function showAllProducts(Request $request)
    {
        return Product::where('user_id', $request->header('id'))->get();
    }

    public function storeProduct(Request $request)
    {
        try {
            // process image upload
            $user_id = $request->header('id');
            $img_path = '';

            $img = $request->file('img');
            $t = time();
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


    // edit

    public function editProduct(Request $request)
    {
        $userid = $request->header('id');
        return Product::where('id', $request->id)
            ->where('user_id', $userid)->first();
    }


    // update

    public function updateProduct(Request $request)
    {
        $user_id = $request->header('id');
        $productId = $request->id;

        if ($request->hasFile('img')) {
            // upload new file

            $img_path = '';

            $img = $request->file('img');
            $t = time();
            $file_name = $img->getClientOriginalName();

            $img_name = "{$user_id}-{$t}-{$file_name}";

            $img_path = "uploads/{$img_name}";

            // upload file

            $img->move(public_path('uploads'), $img_name);

            // delete old file
            $filePath = $request->file_path;
            File::delete($filePath);

            // update product

            return Product::where('id', $productId)->where('user_id', $user_id)->update([
                'name' => $request->name,
                'price' => $request->price,
                'unit' => $request->unit,
                'img_url' => $img_path,
                'category_id' => $request->category_id,
            ]);
        } else {
            return Product::where('id', $productId)->where('user_id', $user_id)->update([
                'name' => $request->name,
                'price' => $request->price,
                'unit' => $request->unit,
                'category_id' => $request->category_id,
            ]);
        }
    }


    // delete

    public function deleteProduct(Request $request) 
    {
        $user_id = $request->header('id');
        $productId = $request->id;
        $filePath = $request->file_path;
        File::delete($filePath);
        return Product::where('id', $productId)->where('user_id', $user_id)->delete();

    }
}
