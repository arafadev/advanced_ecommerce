<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Product;
use Livewire\Component;
use Cart; 

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
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'warning', 'message' => 'This is maximum quantity you can add!', 'position' => 'top-end', 'timer' => 5000, 'toast' => true]);
        }

    }

    public function addToCart(){

        $duplicates = Cart::instance('default')->search(function ($cartItem, $rowId){
            return $cartItem->id === $this->productModal->id;
        });

        if($duplicates->isNotEmpty()){
         // show error message
        $this->dispatchBrowserEvent('swal:alert', ['type'=> 'error','message' => 'product already exist!','position' => 'top-end','timer' => 5000,'toast' => true]); 
        }else{
            
        Cart::instance('default')->add($this->productModal->id,$this->productModal->name,$this->productModal->quantity,$this->productModal->price,)->associate(Product::class); 
        // back to quantity 1 in input
        $this->quantity = 1;
        // show success message
        $this->dispatchBrowserEvent('swal:alert', ['type' => 'success','message' => 'product stored in your cart successfully','position' => 'top-end','timer' => 5000,'toast' => true]); 
        }

    }


    public function addToWishList()
    {
        $duplicates = Cart::instance('wishlist')->search(function ($cartItem, $rowId) {
            return $cartItem->id === $this->productModal->id;
        });

        if ($duplicates->isNotEmpty()) {
         // show error message
         $this->dispatchBrowserEvent('swal:alert', ['type' => 'error','message' => 'product already exist!','position' => 'top-end','timer' => 5000,'toast' => true]); 
        } else {
            Cart::instance('wishlist')->add($this->productModal->id, $this->productModal->name, 1, $this->productModal->price)->associate(Product::class);
            // $this->emit('updateCart');
          // show success message
          $this->dispatchBrowserEvent('swal:alert', ['type'=> 'success','message' => 'product stored in your wishlist successfully','position' => 'top-end','timer' => 5000,'toast' => true,]); 
        }
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
