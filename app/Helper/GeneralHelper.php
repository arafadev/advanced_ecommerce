<?php

use Illuminate\Support\Facades\Cache;
// use Cart;
function getParentShowOf($param)
{
    $route = str_replace('admin.', '', $param);
    $permission = Cache::get('admin_side_menu')->where('as', $route)->first();
    return $permission ? $permission->parent_show : $route;

}

function getParentOf($param)
{
    $route = str_replace('admin.', '', $param);
    $permission = Cache::get('admin_side_menu')->where('as', $route)->first();
    return $permission ? $permission->parent : $route;
}


function getParentIdOf($param)
{
    $route = str_replace('admin.', '', $param);
    $permission = Cache::get('admin_side_menu')->where('as', $route)->first();
    return $permission ? $permission->id : null;
}

function getNumbers()
{
    $subtotal = Cart::instance('default')->subtotal();
    $discount = session()->has('coupon') ? session()->get('coupon')['discount'] : 0.00; // as 200
    $discount_code = session()->has('coupon') ? session()->get('coupon')['code'] : null;

    $subtotal_after_discount = $subtotal - $discount;// 1000$ - 200$ = 800$     

    $tax = config('cart.tax') / 100;
    $taxText = config('cart.tax') . '%';

    $productTaxes = round($subtotal_after_discount * $tax, 2); // 120$
    $newSubTotal = $subtotal_after_discount + $productTaxes; // 920$ that's newSubTotal

    $shipping = session()->has('shipping') ? session()->get('shipping')['cost'] : 0.00;
    $shipping_code = session()->has('shipping') ? session()->get('shipping')['code'] : null;
 
    $total = ($newSubTotal + $shipping) > 0 ? round($newSubTotal + $shipping, 2) : 0.00;

    return collect([
        'subtotal' => $subtotal,
        'tax' => $productTaxes,
        'taxText' => $taxText,
        'productTaxes' => (float)$productTaxes,
        'newSubTotal' => (float)$newSubTotal,
        'discount' => (float)$discount,
        'discount_code' => $discount_code,
        'shipping' => (float)$shipping,
        'shipping_code' => $shipping_code,
        'total' => (float)$total,
    ]);
}
