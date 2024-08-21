<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    function ReportPage()
    {
        return view('pages.dashboard.report-page');
    }

    function salesReport(Request $request)
    {

        $user_id = $request->header('id');
        $fromDate = date('Y-m-d', strtotime($request->fromDate));
        $toDate = date('Y-m-d', strtotime($request->toDate));


        $total = Invoice::where('user_id', $user_id)->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $toDate)->sum('total');
        $vat = Invoice::where('user_id', $user_id)->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $toDate)->sum('vat');
        $payable = Invoice::where('user_id', $user_id)->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $toDate)->sum('payable');
        $discount = Invoice::where('user_id', $user_id)->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $toDate)->sum('discount');


        $list = Invoice::where('user_id', $user_id)
            ->whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate)->with('customer')->get();


        $data = [
            'payable'     => $payable,
            'discount'     => $discount,
            'total'     => $total,
            'vat'     => $vat,
            'list'     => $list,
            'FromDate'  => $request->fromDate,
            'ToDate'    => $request->toDate,
        ];


        // generate pdf

        $pdf = PDF::loadView('report.SalesReport', $data);


        return $pdf->download('invoice.pdf');
    }
}
