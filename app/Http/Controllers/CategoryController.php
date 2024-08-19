<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {


        return view('pages.dashboard.category-page');
    }

    public function showAllCategory()
    {
        $categories = Category::all();

        return response()->json([
            'status' => 'success',
            'categories' => $categories
        ], 200);
    }



    public function storeCategoryAction(Request $request)
    {
        try {

            $userid = $request->header('id');

            Category::create([
                'name' => $request->name,
                'user_id' => $userid
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Category created successfully',
            ], 201);
        } catch (\Throwable $e) {

            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // delete category action

    public function deleteCategoryAction(Request $request)
    {
        try {

            $category_id = $request->id;
            $userid = $request->header('id');

            Category::where('id', $category_id)->where('user_id', $userid)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'category delete successfull'
            ], 200);

        } catch (\Throwable $e) {

            return response()->json([
                'status' => 'success',
                'message' => $e->getMessage(),
            ], 500);
            
        }
    }
}
