<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Categories\CategoryStoreRequest;
use App\Http\Requests\Categories\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools\Response;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Response::success('Categories found.', ['categories'=> Category::paginate(10)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $category = new Category();

        DB::transaction(function () use ($request, & $category) {
            $category->user_id = $request->user()->id;
            $category->title = $request->title;
            $category->status = $request->status;
            $category->save();
        });

        return Response::success('Category created successfully.', ['category' => $category]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return Response::success('Category found.', ['category'=> $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        if($request->title == $category->title && $request->status == $category->status)
        {
            return Response::success('Nothing to update.');
        }

        DB::transaction(function () use ($category, $request) {
            $category->title = $request->title;
            $category->status = $request->status;
            $category->save();
        });

        return Response::success('Category updated successfully.', ['user'=> $category]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        DB::transaction(function () use ($category) {
            $category->delete();
        });
        return Response::success('Category Deleted Successfully.');
    }
}
