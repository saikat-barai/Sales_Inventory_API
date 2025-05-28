<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboardSummary(Request $request){
        $userId = $request->header('user_id');
        $products = Product::where('user_id', $userId)->count();
        $categories = Category::where('user_id', $userId)->count();
        $customers = Customer::where('user_id', $userId)->count();
        $invoice = Invoice::where('user_id', $userId)->count();
        $total = Invoice::where('user_id', $userId)->sum('payable');
        $vat = Invoice::where('user_id', $userId)->sum('vat');
        $payable = Invoice::where('user_id', $userId)->sum('payable');
        return response()->json([
           'status' => 'success',
           'data' => [
               'products' => $products,
               'categories' => $categories,
               'customers' => $customers,
               'invoice' => $invoice,
               'total' => $total,
               'vat' => $vat,
               'payable' => $payable
           ] 
        ], 200);

    }
}
