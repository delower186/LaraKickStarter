<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Categories\CategoryStoreRequest;
use App\Http\Requests\Categories\CategoryUpdateRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Tools\Response;
use App\Tools\Permission;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize(Permission::format("view", 'category'), Category::class);
        return Response::success('Categories found.', ['categories'=> Category::paginate(10)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $this->authorize(Permission::format("create", 'category'), Category::class);
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
        $this->authorize(Permission::format("view", 'category'), Category::class);
        return Response::success('Category found.', ['category'=> $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $this->authorize(Permission::format("update", 'category'), Category::class);
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
        $this->authorize(Permission::format("delete", 'category'), Category::class);
        DB::transaction(function () use ($category) {
            $category->delete();
        });
        return Response::success('Category Deleted Successfully.');
    }
}
