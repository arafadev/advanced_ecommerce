<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ProductCategory;

class ShopProductsComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $paginationLimit = 12;
    public $slug;
    public $sortingBy = 'default';
    public function render()
    {
        switch ($this->sortingBy) {
            case 'popularity':
                $sort_field = 'id';
                $sort_type = 'asc';
                break;
            case 'low-high':
                $sort_field = 'price';
                $sort_type = 'asc';
                break;
            case 'high-low':
                $sort_field = 'price';
                $sort_type = 'desc';
                break;
            default:
                $sort_field = 'id';
                $sort_type = 'asc';
        }

        $products = Product::with('firstMedia');
        if ($this->slug == '') {
            $products = $products->ActiveCategory();
        } else {
            $product_category = ProductCategory::whereSlug($this->slug)->whereStatus(true)->first();

            if (is_null($product_category->parent_id)) {
                $categoriesIds = ProductCategory::whereParentId($product_category->id)
                    ->whereStatus(true)->pluck('id')->toArray();

                $products = $products->whereHas('category', function ($query) use ($categoriesIds) {
                    $query->whereIn('id', $categoriesIds);
                });

            } else {

                $products = $products->with('category')->whereHas('category', function ($query) {
                    $query->where([
                        'slug' => $this->slug,
                        'status' => true
                    ]);
                });

            }
        }

        $products = $products->Active()
            ->HasQuantity()
            ->orderBy($sort_field, $sort_type)
            ->paginate($this->paginationLimit);

        return view('livewire.frontend.shop-products-component', [
            'products' => $products
        ]);
    }
}
