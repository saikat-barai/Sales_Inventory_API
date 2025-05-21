<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function customerList(Request $request)
    {
        $user_id = $request->header('user_id');
        $data = Customer::where('user_id', $user_id)->get();
        if ($data->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'No Customer Found...!!!',
                'data' => [],
            ], 200);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Customer List...!!!',
                'data' => $data,
            ], 200);
        }
    }

    public function customerCreate(Request $request)
    {
        try {
            $user_id = $request->header('user_id');

            $validator = Validator::make($request->all(), [
                'name'   => 'required|string|max:255',
                'email'  => 'required|email|unique:customers,email|max:255',
                'mobile' => 'nullable|numeric|digits:11',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => 'failed',
                    'message' => 'Validation Error',
                    'errors'  => $validator->errors(),
                ], 422);
            }

            $validatedData = $validator->validated();

            $data = Customer::create([
                'name'       => $validatedData['name'],
                'email'      => $validatedData['email'],
                'mobile'     => $validatedData['mobile'] ?? null,
                'user_id'    => $user_id,
                'created_at' => now(),
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Customer Created Successfully...!!!',
                'data'    => $data,
            ], 201);
        } catch (\Exception $e) {
            // Log error for debugging
            Log::error('Customer Creation Error', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong on the server.',
            ], 500);
        }
    }

    public function customerDelete(Request $request)
    {
        $userId = $request->header('user_id');
        $customerId = $request->input('id');

        $customer = Customer::where('id', $customerId)->where('user_id', $userId)->first();

        if ($customer) {
            $customer->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Customer deleted successfully.',
            ], 200);
        }

        return response()->json([
            'status' => 'failed',
            'message' => 'Customer not found.',
        ], 404); // Use 404 instead of 200 for "not found"
    }

    public function customerById(Request $request)
    {
        $userID = $request->header('user_id');
        $customerID = $request->input('id');
        $data = Customer::where('id', $customerID)->where('user_id', $userID)->first();
        if ($data !== null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Customer Found Successfully.',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Customer Not Found.',
            ], 200);
        }
    }

    public function customerUpdate(Request $request)
    {
        try {
            $userId = $request->header('user_id');
            $customerId = $request->input('id');

            // Validate input data
            $validator = Validator::make($request->all(), [
                'name'   => 'required|string|max:255',
                'email'  => "required|email|max:255|unique:customers,email,{$customerId},id",
                'mobile' => 'nullable|numeric|digits:11',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => 'failed',
                    'message' => 'Validation error',
                    'errors'  => $validator->errors(),
                ], 422);
            }

            // Find customer with matching id and user_id
            $customer = Customer::where('id', $customerId)->where('user_id', $userId)->first();

            if (!$customer) {
                return response()->json([
                    'status'  => 'failed',
                    'message' => 'Customer not found',
                ], 404);
            }

            // Update customer with validated data
            $customer->update([
                'name'       => $validator->validated()['name'],
                'email'      => $validator->validated()['email'],
                'mobile'     => $validator->validated()['mobile'] ?? null,
                'updated_at' => now(),
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Customer updated successfully',
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Customer Update Error', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'user_id' => $userId ?? null,
                'customer_id' => $customerId ?? null,
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong on the server.',
            ], 500);
        }
    }
}
