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

    public function showAllCategory(){
        $categories = Category::all();

        return response()->json([
            'status' => 'success',
            'categories' => $categories
        ],200);


        
    }

    public function create() {}
    public function store() {}
    public function edit() {}
    public function update() {}
    public function delete() {}
}
