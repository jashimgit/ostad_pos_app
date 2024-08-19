<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    
    
    public function index()
    {
        return view('pages.dashboard.customer-page');
    }


    public function showAllCustomers()
    {
        $customers = Customer::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Customer list successfully fetched',
            'customers' => $customers,
        ],200);
    }
}
