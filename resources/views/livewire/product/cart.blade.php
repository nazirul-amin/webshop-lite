<li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="shoppingCartDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-shopping-cart fa-fw"></i>
        <!-- Counter - Messages -->
        <span class="badge badge-danger badge-counter">{{ count($productInCarts) }}</span>
    </a>
    <!-- Dropdown - Messages -->
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="shoppingCartDropdown">
        <h6 class="dropdown-header">
            Shopping Cart
        </h6>
        @forelse ($productInCarts as $product)
            @if ($loop->iteration < 6)
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="dropdown-list-image mr-3">
                        <img src="{{ asset('storage/'.$product->product->photo) }}" alt="">
                    </div>
                    <div class="font-weight-bold">
                        <div class="text-truncate">{{ $product->product->name }}</div>
                        <div class="small text-gray-500">RM{{ sprintf("%.2f", $product->product->price * $product->quantity) }}</div>
                    </div>
                </a>
            @endif
        @empty
            <a class="dropdown-item d-flex align-items-center" href="#">
                <div class="dropdown-list-image mr-3">
                    <img src="{{ asset('icon/puzzled_80px.png') }}" alt="">
                </div>
                <div>
                    <div class="text-truncate">Oppss your cart is empty</div>
                </div>
            </a>
        @endforelse
        <a class="dropdown-item text-center small text-gray-500" href="{{ route('product.cart') }}">View My Shopping Cart</a>
    </div>
</li>
