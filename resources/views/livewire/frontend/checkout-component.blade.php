<div class="row">
    <div class="col-lg-8">
        Content
    </div>
    <!-- ORDER SUMMARY-->
    <div class="col-lg-4">
        <div class="card border-0 rounded-0 p-lg-4 bg-light">
            <div class="card-body">
                <h5 class="text-uppercase mb-4">Your order</h5>
                <ul class="list-unstyled mb-0">
                    <li class="d-flex align-items-center justify-content-between"><strong
                            class="small font-weight-bold">Subtotal</strong><span
                            class="text-muted small">${{ $cart_subtotal }}</span></li>
                    <li class="d-flex align-items-center justify-content-between">
                        <strong class="text-uppercase small font-weight-bold">Total</strong>
                        <span>${{ $cart_total }}</span>
                    </li>
                    <li class="border-bottom my-2"></li>
                    <li class="d-flex align-items-center justify-content-between"><strong
                            class="small font-weight-bold">Tax</strong><span
                            class="text-muted small">${{ $cart_tax }}</span></li>
                    <li class="border-bottom my-2"></li>
                    <li class="d-flex align-items-center justify-content-between">
                        <form wire:submit.prevent="applyDiscount()">

                            <input type="text" wire:model="coupon_code" class="form-control"
                                placeholder="Enter your coupon">
                            {{-- <button type="button" wire:click.prevent="removeCoupon()"
                                class="btn btn-danger btn-sm btn-block">
                                <i class="fas fa-gift mr-2"></i> Remove coupon
                            </button> --}}
                            <button type="submit" class="btn btn-dark btn-sm btn-block">
                                <i class="fas fa-gift mr-2"></i> Apply coupon
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
