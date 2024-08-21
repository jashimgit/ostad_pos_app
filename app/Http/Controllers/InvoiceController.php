<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{

    public function index()
    {
        return view('pages.dashboard.invoice-page');
    }


    public function getAllInvoice(Request $request)
    {
        $user_id = $request->header('id');

        return Invoice::where('user_id', $user_id)->with('customer')->get();
    }



    public function SalePage()
    {
        return view('pages.dashboard.sale-page');
    }

    public function invoiceCreate(Request $request)
    {
        // dd($request->all());


        DB::beginTransaction();

        try {

            $userid = $request->header('id');
            $total = $request->total;
            $vat = $request->vat;
            $discount = $request->discount;
            $payable = $request->payable;
            $customer_id = $request->customer_id;

            // save invoice data 
            $invoice = Invoice::create([
                'total' => $total,
                'vat'   => $vat,
                'discount'  => $discount,
                'payable'   => $payable,
                'customer_id'   => $customer_id,
                'user_id'   => $userid,
            ]);

            $invoiceId = $invoice->id;
            $products = $request->products;
            // insert product to invoice_products table

            foreach ($products as $product) {
                InvoiceProduct::create([
                    'invoice_id'    => $invoiceId,
                    'user_id'       => $userid,
                    'product_id'    => $product['product_id'],
                    'qty'           => $product['qty'],
                    'sale_price'    => $product['sale_price']
                ]);
            }
            DB::commit();
            return true;
        } catch (\Throwable $e) {

            DB::rollBack();

            return $e->getMessage();
        }
    }


    // delete 
    public function invoiceDelete(Request $request)
    {

        // DB::beginTransaction();

        try {
            $invoiceId = $request->inv_id;
            $userid = $request->header('id');

            InvoiceProduct::where('invoice_id', $invoiceId)->where('user_id', $userid)->delete();
            Invoice::where('id', $invoiceId)->delete();
            DB::commit();
            return 1;

        } catch (\Throwable $th) {

            DB::rollBack();
            
            return $th->getMessage();
        }
    }



    // invoice details
    public function invoiceDetails(Request $request)
    {
        // dd($request->all());
        
        try {
            $user_id = $request->header('id');
            $customerDetails = Customer::where('user_id', $user_id)->where('id', $request->input('cus_id'))->first();
            // dd($customerDetails);

            $invoiceTotal = Invoice::where('user_id', $user_id)->where('id', $request->input('cus_id'))->first();
            $invoiceProduct = InvoiceProduct::where('invoice_id', $request->inv_id)->where('user_id', $user_id)->with('product')->get();

            return array(
                'customer' => $customerDetails,
                'invoice'   => $invoiceTotal,
                'product'   => $invoiceProduct,
            );

        } catch (\Throwable $th) {

            return $th->getMessage();
        }
    }
}
