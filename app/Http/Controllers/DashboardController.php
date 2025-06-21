<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function dashboard(){
        return view('pages.dashboard.dashboard-page');
    }
    public function dashboardSummary(Request $request){
        $userId = $request->header('user_id');
        $products = Product::where('user_id', $userId)->count();
        $categories = Category::where('user_id', $userId)->count();
        $customers = Customer::where('user_id', $userId)->count();
        $invoice = Invoice::where('user_id', $userId)->count();
        
        $invoiceSummary = Invoice::where('user_id', $userId)->selectRaw('SUM(total) as total, SUM(vat) as vat, SUM(payable) as payable')->first();
        return response()->json([
           'status' => 'success',
           'data' => [
               'product' => $products,
               'category' => $categories,
               'customer' => $customers,
               'invoice' => $invoice,
               'total' => $invoiceSummary->total ?? 0,
               'vat' => $invoiceSummary->vat ?? 0,
               'payable' => $invoiceSummary->payable ?? 0
           ] 
        ], 200);

    }
}
