<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Product;
use Livewire\Component;

class ProductModalShared extends Component
{
    public $productModalCount = false;
    public $productModal = []; // the current product 
    public $quantity = 1;
    protected $listeners = ['showProductModalAction'];

    public function decreaseQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;

        }
    }

    public function increaseQuantity()
    {
        if ($this->productModal->quantity > $this->quantity) {
            $this->quantity++;
        } else {
            $this->dispatchBrowserEvent('swal:alert', [
                'type'    => 'warning',
                'message' => 'This is maximum quantity you can add!',
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
            ]);        }

    }

    public function showProductModalAction($slug)
    {
        $this->productModalCount = true;
        $this->productModal = Product::withAvg('reviews', 'rating')->whereSlug($slug)->Active()->HasQuantity()->ActiveCategory()->firstOrFail();

        // dd($this->productModal);
    }
    public function render()
    {
        return view('livewire.frontend.product-modal-shared');
    }
}
