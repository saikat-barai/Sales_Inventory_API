<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function invoiceCreate(Request $request)
    {
           DB::beginTransaction();
           try {
            $userId = $request->header('user_id');
            $total = $request->input('total');
            $discount = $request->input('discount');
            $vat = $request->input('vat');
            $payable = $request->input('payable');
            $customer_id = $request->input('customer_id');

            $invoice = Invoice::create([
                'total' => $total,
                'discount' => $discount,
                'vat' => $vat,
                'payable' => $payable,
                'user_id' => $userId,
                'customer_id' => $customer_id
            ]);

            $invoiceId = $invoice->id;
            $products = $request->input('products');

            foreach ($products as $product) {
                InvoiceProduct::create([
                   'invoice_id' => $invoiceId,
                   'user_id' => $userId,
                   'product_id' => $product['product_id'],
                   'qty' => $product['qty'],
                   'sale_price' => $product['sale_price']
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Invoice created successfully'
            ], 200);
           } catch (\Throwable $th) {
             DB::rollBack();
             return response()->json([
                'status' => 'failed',
                'message' => 'Invoice creation failed'
             ], 200);
           }
    }
}
