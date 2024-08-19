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


    public function editCustomerAction(Request $request)
    {
        return Customer::where('id', $request->id)->first();
    }


    public function updateCustomerAction(Request $request)
    {
        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'mobile'=>$request->mobile,
            ];
    
    
            Customer::where('id', $request->id)->update($data);

            return true;

        } catch (\Throwable $e) {
            
            return response()->json([
                'status'=> 'fail',
                'message' => $e->getMessage()
            ],500);
        }
    }

}
