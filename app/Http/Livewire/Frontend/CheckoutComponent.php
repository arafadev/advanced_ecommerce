<?php

namespace App\Http\Livewire\Frontend;


use Livewire\Component;

use Cart;
class CheckoutComponent extends Component
{
  
    public $cart_subtotal;
    public $cart_tax;
    public $cart_total;
    public $cart_coupon;


    protected $listeners = [
        'updateCart' => 'mount'
    ];

    public function mount()
    {
        $this->cart_subtotal = Cart::instance('default')->subtotal();   
        $this->cart_tax = Cart::instance('default')->tax();
        $this->cart_total = Cart::instance('default')->total();   
    }
  
    public function applyDiscount()
    // {
    //     if (getNumbers()->get('subtotal') > 0) {
    //         $coupon = ProductCoupon::whereCode($this->coupon_code)->first();
    //         if(!$coupon) {
    //             $this->cart_coupon = '';
    //             $this->alert('error', 'Coupon is invalid!');
    //         } else {
    //             $couponValue = $coupon->discount($this->cart_subtotal);
    //             if ($couponValue > 0) {
    //                 session()->put('coupon', [
    //                     'code' => $coupon->code,
    //                     'value' => $coupon->value,
    //                     'discount' => $couponValue,
    //                 ]);
    //                 $this->coupon_code = session()->get('coupon')['code'];
    //                 $this->emit('updateCart');

    //                 $this->alert('success', 'coupon is applied successfully');
    //             } else {
    //                 $this->alert('error', 'product coupon is invalid');
    //             }

    //         }

    //     } else {
    //         $this->cart_coupon = '';
    //         $this->alert('error', 'No products available in your cart');
    //     }
    }

    public function render()
    {
        return view('livewire.frontend.checkout-component');
    }
}
