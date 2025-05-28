<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function saleReport(Request $request){
        $userId = $request->header('user_id');
        $fromDate = date('Y-m-d', strtotime($request->input('fromDate')));
        $toDate = date('Y-m-d', strtotime($request->input('toDate')));
        $total = Invoice::where('user_id', $userId)->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $toDate)->sum('total');
        $vat = Invoice::where('user_id', $userId)->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $toDate)->sum('total');
        $payable = Invoice::where('user_id', $userId)->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $toDate)->sum('payable');
        $discount = Invoice::where('user_id', $userId)->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $toDate)->sum('discount');

        $list = Invoice::where('user_id', $userId)->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $toDate)->with('customer')->with('products')->get();

        $data = [
            'total' => $total,
            'vat' => $vat,
            'payable' => $payable,
            'discount' => $discount,
            'list' => $list
        ];
        $pdf = Pdf::loadView('report.salse_report', $data);
        return $pdf->download('salse_report.pdf');
    }
}
