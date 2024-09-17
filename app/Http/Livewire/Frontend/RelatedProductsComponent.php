<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Product;
use Livewire\Component;
use Cart;

class RelatedProductsComponent extends Component
{
    public $relatedProducts;

    public function mount($relatedProducts)
    {
        $this->relatedProducts = $relatedProducts;
    }

    public function addToCart($id)
    {
        $product = Product::whereId($id)->Active()->HasQuantity()->ActiveCategory()->firstOrFail();
        $duplicates = Cart::instance('default')->search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->id === $product->id;
        });
        if ($duplicates->isNotEmpty()) {
            $this->dispatchBrowserEvent('swal:alert', ['type'=> 'error','message' => 'product already exist!','position' => 'top-end','timer' => 5000,'toast' => true]); 

        } else {
            Cart::instance('default')->add($product->id, $product->name, 1, $product->price)->associate(Product::class);
            // $this->emit('updateCart');
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'success','message' => 'product stored in your cart successfully','position' => 'top-end','timer' => 5000,'toast' => true]); 

        }
    }

    public function addToWishList($id)
    {
        $product = Product::whereId($id)->Active()->HasQuantity()->ActiveCategory()->firstOrFail();
        $duplicates = Cart::instance('wishlist')->search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->id === $product->id;
        });
        if ($duplicates->isNotEmpty()) {
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error','message' => 'product already exist!','position' => 'top-end','timer' => 5000,'toast' => true]); 

        } else {
            Cart::instance('wishlist')->add($product->id, $product->name, 1, $product->price)->associate(Product::class);
            // $this->emit('updateCart');
            $this->dispatchBrowserEvent('swal:alert', ['type'=> 'success','message' => 'product stored in your wishlist successfully','position' => 'top-end','timer' => 5000,'toast' => true,]); 

        }
    }


    public function render()
    {
        return view('livewire.frontend.related-products-component');
    }
}
