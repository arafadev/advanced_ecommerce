<?php

namespace App\Http\Controllers\Backend;

use App\Traits\UploadImgTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProductCategoryRequest;
use Illuminate\Support\Facades\File;

class ProductCategoriesController extends Controller
{
    use UploadImgTrait;
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_product_categories, show_product_categories')) {
            return redirect('admin/index');
        }

        $categories = ProductCategory::withCount('products')
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })->when(\request()->status != null, function ($query) {
                $query->whereStatus(\request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);
        return view('backend.product_categories.index', compact('categories'));
    }


    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_product_categories')) {
            return redirect('admin/index');
        }

        $main_categories = ProductCategory::whereNull('parent_id')->get(['id', 'name']);
        return view('backend.product_categories.create', ['main_categories' => $main_categories]);

    }


    public function store(ProductCategoryRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_product_categories')) {
            return redirect('admin/index');
        }

        $input = $request->only(['name', 'status', 'parent_id']);
        if ($request->hasFile('cover')) {
            $input['cover'] = $this->uploadImg($input['name'], $request->file('cover'), 'assets/product_categories');
        }
        ProductCategory::create($input);
        return redirect()->route('admin.product_categories.index')->with([
            'message' => 'Created Successfully',
            'alert_type' => 'success'
        ]);
    }

    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_product_categories')) {
            return redirect('admin/index');
        }

        return view('backend.product_categories.show');

    }

    public function edit(ProductCategory $productCategory)
    {
        if (!auth()->user()->ability('admin', 'update_product_categories')) {
            return redirect('admin/index');
        }
        $main_categories = ProductCategory::whereNull('parent_id')->get(['id', 'name']);
        return view('backend.product_categories.edit', compact('main_categories', 'productCategory'));

    }


    public function update(ProductCategoryRequest $request, ProductCategory $productCategory)
    {
        if (!auth()->user()->ability('admin', 'update_product_categories')) {
            return redirect('admin/index');
        }
        $input['name'] = $request->name;
        $input['slug'] = null;
        $input['status'] = $request->status;
        $input['parent_id'] = $request->parent_id;

        if ($image = $request->file('cover')) {
            if ($productCategory->cover != null && File::exists('assets/product_categories/' . $productCategory->cover)) {
                unlink('assets/product_categories/' . $productCategory->cover);
            }
            $input['cover'] = $this->uploadImg($input['name'], $request->file('cover'), 'assets/product_categories');
        }

        $productCategory->update($input);

        return redirect()->route('admin.product_categories.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ]);
    }

    public function destroy(ProductCategory $productCategory)
    {
        if (!auth()->user()->ability('admin', 'delete_product_categories')) {
            return redirect('admin/index');
        }

        if (File::exists('assets/product_categories/' . $productCategory->cover)) {
            unlink('assets/product_categories/' . $productCategory->cover);
        }
        $productCategory->delete();

        return redirect()->route('admin.product_categories.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }

    public function remove_image(Request $request)
    {
        if (!auth()->user()->ability('admin', 'delete_product_categories')) {
            return redirect('admin/index');
        }

        $category = ProductCategory::findOrFail($request->product_category_id);
        if (File::exists('assets/product_categories/' . $category->cover)) {
            unlink('assets/product_categories/' . $category->cover);
            $category->cover = null;
            $category->save();
        }

        return true;
    }
}
