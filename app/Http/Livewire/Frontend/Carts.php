<?php

namespace App\Http\Livewire\Frontend;
use Livewire\Component;
use Cart;


class Carts extends Component
{
    public $cartCount;
    public $wishlistCount;

    protected $listeners = [
        'updateCart' => 'update_cart',
        'removeFromCart' => 'remove_from_cart',
        'removeFromWishList' => 'remove_from_wish_list',
        'moveToCart' => 'move_to_cart',
    ];

    public function update_cart(){
        $this->cartCount = Cart::instance('default')->count();
        $this->wishlistCount = Cart::instance('wishlist')->count();
    }
    public function mount(){
        $this->cartCount = Cart::instance('default')->count();
        $this->wishlistCount = Cart::instance('wishlist')->count();

    }
    public function remove_from_cart($rowId)
    {
//   dd($rowId);
        Cart::instance('default')->remove($rowId);
        $this->emit('updateCart');
        $this->dispatchBrowserEvent('swal:alert', ['type' => 'success','message' => 'Item removed from wishlist','position' => 'top-end','timer' => 5000,'toast' => true]); 

        if (Cart::instance('default')->count() == 0){
            return redirect()->route('frontend.cart');
        }
    }

    public function remove_from_wish_list($rowId)
    {
        Cart::instance('wishlist')->remove($rowId);
        $this->emit('updateCart');
        $this->dispatchBrowserEvent('swal:alert', ['type' => 'success','message' => 'Item removed from wishlist','position' => 'top-end','timer' => 5000,'toast' => true]); 

        if (Cart::instance('wishlist')->count() == 0){
            return redirect()->route('frontend.wishlist');
        }
    }

    public function move_to_cart($rowId)
    {
        $item = Cart::instance('wishlist')->get($rowId);
        $duplicate = Cart::instance('default')->search(function ($cartItem, $rId) use ($rowId) {
            return $rId === $rowId;
        });

        if ($duplicate->isNotEmpty()) {
            Cart::instance('wishlist')->remove($rowId);
            $this->dispatchBrowserEvent('swal:alert', ['type'=> 'error','message' => 'product already exist!','position' => 'top-end','timer' => 5000,'toast' => true]); 

        } else {
            Cart::instance('default')->add($item->id, $item->name, 1, $item->price)->associate(Product::class);
            Cart::instance('wishlist')->remove($rowId);
            $this->dispatchBrowserEvent('swal:alert', ['type' => 'success','message' => 'product stored in your cart successfully','position' => 'top-end','timer' => 5000,'toast' => true]); 

        }

        $this->emit('updateCart');

        if (Cart::instance('wishlist')->count() == 0){
            return redirect()->route('frontend.wishlist');
        }

    }


    public function render()
    {
        return view('livewire.frontend.carts');
    }
}
