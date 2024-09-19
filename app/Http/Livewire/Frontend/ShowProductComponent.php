<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Product;
use Livewire\Component;
use Cart; 

class ShowProductComponent extends Component
{
    public $product;
    public $quantity = 1;

    public function mount($product) // mount function as a construct in php 
    { 
        $this->product = $product;
    }

    public function decreaseQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function increaseQuantity()
    {
        if ($this->product->quantity > $this->quantity) {
            $this->quantity++;
        } else {
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'warning', 'message' => 'This is maximum quantity you can add!', 'position' => 'top-end', 'timer' => 5000, 'toast' => true]);

        }
    }

    public function addToCart()
    {
        $duplicates = Cart::instance('default')->search(function ($cartItem, $rowId) {
            return $cartItem->id === $this->product->id;
        });
        if ($duplicates->isNotEmpty()) {
            $this->dispatchBrowserEvent('swal:alert', ['type'=> 'error','message' => 'product already exist!','position' => 'top-end','timer' => 5000,'toast' => true]); 

        } else {
            Cart::instance('default')->add($this->product->id, $this->product->name, 1, $this->product->price)->associate(Product::class);
            $this->emit('updateCart');
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'success','message' => 'product stored in your cart successfully','position' => 'top-end','timer' => 5000,'toast' => true]); 

        }
    }

    public function addToWishList()
    {
        $duplicates = Cart::instance('wishlist')->search(function ($cartItem, $rowId) {
            return $cartItem->id === $this->product->id;
        });
        if ($duplicates->isNotEmpty()) {
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'error','message' => 'product already exist!','position' => 'top-end','timer' => 5000,'toast' => true]); 
        } else {
            Cart::instance('wishlist')->add($this->product->id, $this->product->name, 1, $this->product->price)->associate(Product::class);
            $this->emit('updateCart');
            $this->dispatchBrowserEvent('swal:alert', ['type'=> 'success','message' => 'product stored in your wishlist successfully','position' => 'top-end','timer' => 5000,'toast' => true,]); 

        }
    }

    public function render()
    {
        return view('livewire.frontend.show-product-component');
    }
}
