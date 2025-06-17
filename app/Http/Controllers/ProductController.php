<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function productPage()
    {
        return view('pages.dashboard.product-page');
    }
    public function productCreate(Request $request)
    {
        try {
            $userId = $request->header('user_id');

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'unit' => 'string|max:255',
                'category_id' => 'required|integer',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $filePath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = $userId . '_' . time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');
            }

            $validatedData = $validator->validated();

            Product::create([
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'unit' => $validatedData['unit'],
                'img_url' => $filePath,
                'category_id' => $validatedData['category_id'],
                'user_id' => $userId,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Product Created Successfully.',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Server Error. Please try again later.',
            ], 500);
        }
    }

    public function productList(Request $request)
    {
        try {
            $userId = $request->header('user_id');

            $products = Product::where('user_id', $userId)->with('category')->get();

            if ($products->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No Product Found.',
                    'data' => [],
                ], 200);
            } else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Product List.',
                    'data' => $products,
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Server Error. Please try again later.',
            ], 500);
        }
    }

    public function productById(Request $request)
    {
        try {
            $userId = $request->header('user_id');
            $productId = $request->input('id');

            $product = Product::where('id', $productId)->where('user_id', $userId)->with('category')->first();

            if ($product !== null) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Product Found Successfully.',
                    'data' => $product,
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Product Not Found.',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Server Error. Please try again later.',
            ], 500);
        }
    }

    public function productDelete(Request $request)
    {
        try {
            $userId = $request->header('user_id');
            $productId = $request->input('id');

            $product = Product::where('id', $productId)->where('user_id', $userId)->first();

            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not found.',
                ], 404);
            }

            if ($product->img_url && Storage::disk('public')->exists($product->img_url)) {
                Storage::disk('public')->delete($product->img_url);
            }

            $product->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Product deleted successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Server error. Please try again later.',
            ], 500);
        }
    }

    public function productUpdate(Request $request)
    {
        try {
            $userId = $request->header('user_id');
            $productId = $request->input('id');

            $product = Product::where('id', $productId)->where('user_id', $userId)->first();

            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not found.',
                ], 404);
            }

            // $validator = Validator::make($request->all(), [
            //     'name' => 'required|string|max:255',
            //     'price' => 'required|numeric',
            //     'unit' => 'string|max:255',
            //     'category_id' => 'required|integer',
            //     'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:5000',
            // ]);

            // if ($validator->fails()) {
            //     return response()->json([
            //         'status' => 'failed',
            //         'errors' => $validator->errors(),
            //     ], 422);
            // }

            // $validatedData = $validator->validated();

            if ($request->hasFile('image')) {
                Storage::disk('public')->delete($product->img_url);
                $file = $request->file('image');
                $fileName = $userId . '_' . time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');


                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:255',
                    'price' => 'required|numeric',
                    'unit' => 'string|max:255',
                    'category_id' => 'required|integer',
                    'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:5000',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'failed',
                        'errors' => $validator->errors(),
                    ], 422);
                }

                $validatedData = $validator->validated();


                $product->update([
                    'name' => $validatedData['name'],
                    'price' => $validatedData['price'],
                    'unit' => $validatedData['unit'],
                    'category_id' => $validatedData['category_id'],
                    'img_url' => $filePath,
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Product updated successfully.',
                    'data' => $product,
                ], 200);
            } else {

                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:255',
                    'price' => 'required|numeric',
                    'unit' => 'string|max:255',
                    'category_id' => 'required|integer',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'failed',
                        'errors' => $validator->errors(),
                    ], 422);
                }

                $validatedData = $validator->validated();

                $product->update([
                    'name' => $validatedData['name'],
                    'price' => $validatedData['price'],
                    'unit' => $validatedData['unit'],
                    'category_id' => $validatedData['category_id'],
                    'img_url' => $product->img_url,
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Product updated successfully without image.',
                    'data' => $product,
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Server error. Please try again later.',
            ]);
        }
    }
}
