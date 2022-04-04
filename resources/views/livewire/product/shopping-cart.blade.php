@push('styles')
    <link href="{{ asset('css/custom/product-cart.css') }}" rel="stylesheet" />
@endpush

<div class="row">
    <div class="col-md-9">
        <div class="ibox">
            <div class="ibox-title">
                <span class="pull-right">(<strong>{{ $totalQuantity }}</strong>) items</span>
                <h5>Items in your cart</h5>
            </div>
            @forelse ($productInCarts as $product)
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table shoping-cart-table">
                            <tbody>
                                <tr>
                                    <td width="90">
                                        <div class="cart-product-imitation">
                                            <img class="d-block w-75" src="{{ asset('storage/'.$product->product->photo) }}">
                                        </div>
                                    </td>
                                    <td class="desc">
                                        <h3>
                                        <a href="#" class="text-navy">
                                            {{ $product->product->name }}
                                        </a>
                                        </h3>
                                        <p class="small">
                                            {{ $product->product->description }}
                                        </p>

                                        <div class="m-t-sm">
                                            <a href="#" class="text-muted"><i class="fa fa-trash"></i> Remove item</a>
                                        </div>
                                    </td>

                                    <td>
                                        RM{{ $product->product->price }}
                                        {{-- <s class="small text-muted"> RM {{ $product->product->price * $product->quantity }}</s> --}}
                                    </td>
                                    <td width="100">
                                        <input type="number" class="form-control" value="{{ $product->quantity }}">
                                    </td>
                                    <td>
                                        <h4>
                                            RM{{ sprintf("%.2f", $product->product->price * $product->quantity) }}
                                        </h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
            @endforelse
        </div>

    </div>
    <div class="col-md-3">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Cart Summary</h5>
            </div>
            <div class="ibox-content">
                <span>
                    Total
                </span>
                <h2 class="font-bold">
                    RM{{ sprintf("%.2f", $totalPrice) }}
                </h2>

                <hr>
                <span class="text-muted small">
                    *Applicable sales tax will be applied
                </span>
                <div class="m-t-sm">
                    <div class="btn-group">
                        <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart"></i> Checkout</a>
                        <a href="#" class="btn btn-sm"> Cancel</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="ibox">
            <div class="ibox-title">
                <h5>Support</h5>
            </div>
            <div class="ibox-content text-center">
                <h3><i class="fa fa-phone"></i> +43 100 783 001</h3>
                <span class="small">
                    Please contact with us if you have any questions. We are avalible 24h.
                </span>
            </div>
        </div>

        <div class="ibox">
            <div class="ibox-content">

                <p class="font-bold">
                Other products you may be interested
                </p>
                <hr>
                <div>
                    <a href="#" class="product-name"> Product 1</a>
                    <div class="small m-t-xs">
                        Many desktop publishing packages and web page editors now.
                    </div>
                    <div class="m-t text-righ">

                        <a href="#" class="btn btn-xs btn-outline btn-primary">Info <i class="fa fa-long-arrow-right"></i> </a>
                    </div>
                </div>
                <hr>
                <div>
                    <a href="#" class="product-name"> Product 2</a>
                    <div class="small m-t-xs">
                        Many desktop publishing packages and web page editors now.
                    </div>
                    <div class="m-t text-righ">

                        <a href="#" class="btn btn-xs btn-outline btn-primary">Info <i class="fa fa-long-arrow-right"></i> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
