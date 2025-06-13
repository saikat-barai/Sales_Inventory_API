<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function categoryPage()
    {
        return view('pages.dashboard.category-page');
    }
    public function categoryList(Request $request)
    {
        $user_id = $request->header('user_id');
        $data = Category::where('user_id', $user_id)->get();
        if ($data->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'No Category Found...!!!',
                'data' => [],
            ], 200);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Category List...!!!',
                'data' => $data,
            ], 200);
        }
    }

    public function categoryCreate(Request $request)
    {
        $user_id = $request->header('user_id');
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ]);
        }
        $validatedData = $validator->validated();
        $data = Category::create([
            'name' => $validatedData['name'],
            'user_id' => $user_id,
            'created_at' => now(),
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Category Created Successfully...!!!',
            'data' => $data
        ], 200);

        // try {
        //     $user_id = $request->header('user_id');

        //     $validator = Validator::make($request->all(), [
        //         'name' => 'required|unique:categories,name|string|max:255',
        //     ]);

        //     if ($validator->fails()) {
        //         return response()->json([
        //             'status' => 'failed',
        //             'message' => 'Validation Error',
        //             'errors' => $validator->errors(),
        //         ], 422);
        //     }

        //     $validatedData = $validator->validated();

        //     $data = Category::create([
        //         'name' => $validatedData['name'],
        //         'user_id' => $user_id,
        //         'created_at' => now(),
        //     ]);

        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'Category Created Successfully...!!!',
        //         'data' => $data,
        //     ], 200);
        // } catch (Exception $e) {
           
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Something went wrong.',
        //         'error' => $e->getMessage(), 
        //     ], 500);
        // }
    }

    public function categoryDelete(Request $request)
    {
        $user_id = $request->header('user_id');
        $category_id = $request->input('id');
        $data = Category::where(['id' => $category_id, 'user_id' => $user_id])->first();
        if ($data !== null) {
            $data->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Category Deleted Successfully...!!!',
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Category Not Found...!!!',
            ], 200);
        }
    }

    public function categoryById(Request $request)
    {
        $user_id = $request->header('user_id');
        $category_id = $request->input('id');
        $data = Category::where('id', $category_id)->where('user_id', $user_id)->first();
        if ($data !== null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Category Found Successfully...!!!',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Category Not Found...!!!',
            ], 200);
        }
    }

    public function categoryUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors(),
            ]);
        }
        $validatedData = $validator->validated();
        $user_id = $request->header('user_id');
        $category_id = $request->input('id');
        $data = Category::where('id', $category_id)->where('user_id', $user_id)->first();
        if ($data !== null) {
            $data->update([
                'name' => $validatedData['name'],
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Category Updated Successfully...!!!',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Category Not Found...!!!',
            ], 200);
        }
    }
}
