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
        ], 200);
    }


    // '++++++++++++++++++++++

    public function storeCustomerAction(Request $request)
    {
        try {
            
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->mobile = $request->mobile;
            $customer->user_id = $request->header('id');
            $customer->save();


            return response()->json([
                'status' => 'success',
                'message' => 'Customer created successfully'
            ], 201);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ], 500);
        }
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
                'mobile' => $request->mobile,
            ];


            Customer::where('id', $request->id)->where('user_id', $request->header('id'))->update($data);

            return true;
        } catch (\Throwable $e) {

            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function deleteCustomerAction(Request $request)
    {
        try {

            $customerId = $request->id;
            $userid = $request->header('id');

            Customer::where('id', $customerId)->where('user_id', $userid)->delete();

            return true;
        } catch (\Throwable $e) {

            return response()->json([
                'status' => 'success',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
