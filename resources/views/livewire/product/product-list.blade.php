@push('styles')
    <link href="{{ asset('css/custom/product-card.css') }}" rel="stylesheet" />
    {{-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" /> --}}

    <style type="text/css">
        .navs {
            padding-left: 0;
            margin-bottom: 0;
            list-style: none;
        }
        .navs>li>a {
            position: relative;
            display: block;
            padding: 10px 15px;
        }

        /*panel*/
        .panel {
            margin-bottom: 20px;
            border: none;
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 1px 1px rgb(0 0 0 / 5%);
        }

        .panel-heading {
            border-color:#eff2f7 ;
            font-size: 16px;
            font-weight: 300;
            padding: 10px 15px;
            border-bottom: 1px solid transparent;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
        }
        .panel-body {
            padding: 15px;
        }

        .panel-title {
            color: #2A3542;
            font-size: 14px;
            font-weight: 400;
            margin-bottom: 0;
            margin-top: 0;
            font-family: 'Open Sans', sans-serif;
        }


        /*product list*/

        .prod-cat li a{
            border-bottom: 1px dashed #d9d9d9;
            text-decoration: none;
        }

        .prod-cat li a {
            color: #3b3b3b;
            border-bottom: 1px dashed #d9d9d9;
        }

        .prod-cat li ul {
            margin-left: 30px;
        }

        .prod-cat li ul li a{
            border-bottom:none;
        }
        .prod-cat li ul li a:hover,.prod-cat li ul li a:focus, .prod-cat li ul li.active a , .prod-cat li a:hover,.prod-cat li a:focus, .prod-cat li a.active{
            background: none;
            color: #ff7261;
        }

        .pro-lab{
            margin-right: 20px;
            font-weight: normal;
        }

        .pro-sort {
            padding-right: 20px;
            float: left;
        }

        .pro-page-list {
            margin: 5px 0 0 0;
        }

        .product-list img{
            width: 100%;
            border-radius: 4px 4px 0 0;
            -webkit-border-radius: 4px 4px 0 0;
        }

        .product-list .pro-img-box {
            position: relative;
        }
        .adtocart {
            background: #4e73df;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            -webkit-border-radius: 50%;
            color: #fff;
            display: inline-block;
            text-align: center;
            border: 3px solid #fff;
            left: 45%;
            bottom: -25px;
            position: absolute;
        }

        .adtocart i{
            color: #fff;
            font-size: 25px;
            line-height: 42px;
        }

        .pro-title {
            color: #5A5A5A;
            display: inline-block;
            margin-top: 20px;
            font-size: 16px;
        }

        .product-list .price {
            color:#4e73df ;
            font-size: 15px;
        }

        .pro-img-details {
            margin-left: -15px;
        }

        .pro-img-details img {
            width: 100%;
        }

        .pro-d-title {
            font-size: 16px;
            margin-top: 0;
        }

        .product_meta {
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
            padding: 10px 0;
            margin: 15px 0;
        }

        .product_meta span {
            display: block;
            margin-bottom: 10px;
        }
        .product_meta a, .pro-price{
            color:#4e73df ;
        }

        .pro-price, .amount-old {
            font-size: 18px;
            padding: 0 10px;
        }

        .amount-old {
            text-decoration: line-through;
        }

        .quantity {
            width: 120px;
        }

        .pro-img-list {
            margin: 10px 0 0 -15px;
            width: 100%;
            display: inline-block;
        }

        .pro-img-list a {
            float: left;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .pro-d-head {
            font-size: 18px;
            font-weight: 300;
        }
    </style>
@endpush
<div>
    @if (Auth::user()->role_id == 1)
        <x-table>
            <x-slot name="title">
                Product List
            </x-slot>
            <x-slot name="action">
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" wire:click.prevent="confirmAddProduct">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Add New Product
                </a>
            </x-slot>
            <x-slot name="header">
                <tr style="d-flex">
                    <th class="col-1">
                        <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                            <input type="checkbox" class="custom-control-input" id="checkAll" required="">
                            <label class="custom-control-label" for="checkAll"></label>
                        </div>
                    </th>
                    <th class="col-1"><strong>Product ID</strong></th>
                    <th class="col-3"><strong>Name</strong></th>
                    <th class="col-1"><strong>Price</strong></th>
                    <th class="col-4"><strong>Description</strong></th>
                    <th class="col-1"><strong>Status</strong></th>
                    <th class="col-1"><strong>Action</strong></th>
                </tr>
            </x-slot>
            <x-slot name="row">
                @forelse ($products as $product)
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                                <input type="checkbox" class="custom-control-input" id="customCheckBox2" required="">
                                <label class="custom-control-label" for="customCheckBox2"></label>
                            </div>
                        </td>
                        <td><strong>{{ $product->id }}</strong></td>
                        <td><div class="d-flex align-items-center"><img src="{{ asset('storage/'.$product->photo)}}" class="rounded-lg mr-1" width="100" alt=""> <span class="w-space-no align-self-start">{{ $product->name }}</span></div></td>
                        <td>RM{{ $product->price }}</td>
                        <td>{{ $product->description }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if ($product->deleted_at)
                                    <i class="fa fa-circle text-secondary mr-1"></i> Inactive
                                @else
                                    <i class="fa fa-circle text-success mr-1"></i> Active
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="d-flex">
                                <a href="#" class="btn btn-primary shadow btn-xs sharp mr-1" data-toggle="tooltip" data-placement="top" title="Edit" wire:click="confirmUpdateProduct({{ $product->id }})"><i class="fas fa-edit"></i></a>
                                @if ($product->deleted_at)
                                    <a href="#" class="btn btn-success shadow btn-xs sharp" data-toggle="tooltip" data-placement="top" title="Activate" wire:click="confirmActivateProduct({{ $product->id }})"><i class="fas fa-toggle-on"></i></a>
                                @else
                                    <a href="#" class="btn btn-danger shadow btn-xs sharp" data-toggle="tooltip" data-placement="top" title="Deactivate" wire:click="confirmDeactivateProduct({{ $product->id }})"><i class="fas fa-trash"></i></a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>No data available</td>
                    </tr>
                @endforelse
            </x-slot>
            <x-slot name="pagination">
                {{ $products->links() }}
            </x-slot>
        </x-table>

        <x-jet-dialog-modal wire:model="confirmingAddProduct" maxWidth="lg">
            <x-slot name="title">
                Product Information
            </x-slot>

            <x-slot name="content">
                @if($message)
                    @livewire('component.alert-message', ['message' => $message, 'level'=>"success"])
                @endif
                <form id="addProductForm" {{ ($action == 'add') ? 'wire:submit.prevent=addProduct' : 'wire:submit.prevent=updateProduct' }}>
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <x-jet-label value="{{ __('Photo') }}" class="mb-0" />
                            <div class="d-flex justify-content-center">
                                @if ($productPhoto)
                                    <a href="#" id="uploadImgBtn"><img src="{{ asset('storage/'.$productPhoto) }}" width="94"></a>
                                @else
                                    <a href="#" id="uploadImgBtn"><img src="{{ asset('img/placeholder-image.png') }}" width="94"></a>
                                @endif
                            </div>
                            <x-jet-input id="productPhoto" type="file" wire:model.debounce.500ms="productPhoto" hidden/>
                            <x-jet-input-error for="productPhoto" style="display: block"></x-jet-input-error>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <x-jet-label value="{{ __('Name') }}" />
                                <x-jet-input type="text" wire:model.debounce.500ms="product.name" />
                                <x-jet-input-error for="product.name" style="display: block"></x-jet-input-error>
                            </div>
                            <div class="form-group">
                                <x-jet-label value="{{ __('Price') }}" />
                                <x-jet-input type="number" step="1" wire:model.debounce.500ms="product.price" />
                                <x-jet-input-error for="product.price" style="display: block"></x-jet-input-error>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <x-jet-label value="{{ __('Category') }}" />
                                <select class="form-control" wire:model.debounce.500ms="product.category_id">
                                    <option value="">Please Choose</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-jet-input-error for="product.category_id" style="display: block"></x-jet-input-error>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <x-jet-label value="{{ __('Sub category') }}" />
                                <select class="form-control" wire:model.debounce.500ms="product.sub_category_id">
                                    <option value="">Please Choose</option>
                                    @foreach ($subCategories as $subCategory)
                                        <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                    @endforeach
                                </select>
                                <x-jet-input-error for="product.sub_category_id" style="display: block"></x-jet-input-error>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <x-jet-label value="{{ __('Description') }}" />
                        <textarea class="form-control" cols="30" rows="10" wire:model.debounce.500ms="product.description"></textarea>
                        <x-jet-input-error for="product.description" style="display: block"></x-jet-input-error>
                    </div>
                </form>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingAddProduct')" wire:loading.attr="disabled">
                    Cancel
                </x-jet-secondary-button>

                @if ($action == 'add')
                    <x-jet-button class="ml-2" type="submit" form="addProductForm">
                        <div class="spinner-border" role="status" wire:loading wire:target="addProduct"></div>
                        Add
                    </x-jet-button>
                @endif
                @if ($action == 'update')
                    <x-jet-button class="ml-2" type="submit" form="addProductForm">
                        <div class="spinner-border" role="status" wire:loading wire:target="updateProduct"></div>
                        Update
                    </x-jet-button>
                @endif
            </x-slot>
        </x-jet-dialog-modal>

        <x-jet-dialog-modal wire:model="confirmingProductActiveStatus">
            <x-slot name="title">
                {{ __($action.' Product') }}
            </x-slot>

            <x-slot name="content">
                @if($message)
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                @endif
                {{ __('Are you sure you want to '.strtolower($action).' this product ?') }} <br>
                {{ __('Product ID : '.$product->id) }} <br>
                {{ __('Name : '.$product->name) }} <br>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingProductActiveStatus')"
                                        wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                @if ($action == 'Deactivate')
                    <x-jet-danger-button wire:click="deleteProduct({{ $product->id }})" wire:loading.attr="disabled">
                        <div class="spinner-border" role="status" wire:loading wire:target="deleteProduct"></div>
                        {{ $action }}
                    </x-jet-danger-button>
                @endif
                @if ($action == 'Activate')
                    <x-jet-button wire:click="restoreProduct({{ $product->id }})" wire:loading.attr="disabled" style="background-color: #1cc88a; border-color: #1cc88a">
                        <div class="spinner-border" role="status" wire:loading wire:target="restoreProduct"></div>
                        {{ $action }}
                    </x-jet-button>
                @endif
            </x-slot>
        </x-jet-dialog-modal>
    @elseif (Auth::user()->role_id == 3)
        <div style="padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;">
            <div class="row">
                <div class="col-md-3">
                    <section class="panel">
                        <div class="panel-body">
                            <input type="text" placeholder="Keyword Search" class="form-control" />
                        </div>
                    </section>
                    <x-product-category-list>
                        <x-slot name="list">
                            <ul class="navs prod-cat">
                                @forelse ($categories as $category)
                                    <li>
                                        <a href="#" class="{{ ($categoryActive == $category->id) ? 'active' : '' }}" wire:click.prevent="filterCategory({{ $category->id }})"><i class="fa fa-angle-right"></i> {{ $category->name }}</a>
                                        <ul class="navs" style="{{ ($hasSubCategoryActive) ? '' : 'display: none;' }}">
                                            @foreach ($subCategories as $subCategory)
                                                @if ($subCategory->category->id == $category->id)
                                                    <li class="{{ ($subCategoryActive == $subCategory->id) ? 'active' : '' }}"><a href="#" wire:click.prevent="filterSubCategory({{ $category->id }}, {{ $subCategory->id }})">- {{ $subCategory->name }}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @empty
                                    <li>No data available</li>
                                @endforelse
                            </ul>
                        </x-slot>
                    </x-product-category-list>
                    <section class="panel">
                        <header class="panel-heading">
                            Filter
                        </header>
                        <div class="panel-body">
                            <form role="form product-form">
                                <div class="form-group">
                                    <label>Brand</label>
                                    <select class="form-control hasCustomSelect" style="-webkit-appearance: menulist-button; width: 231px; position: absolute; opacity: 0; height: 34px; font-size: 12px;">
                                        <option>Wallmart</option>
                                        <option>Catseye</option>
                                        <option>Moonsoon</option>
                                        <option>Textmart</option>
                                    </select>
                                    <span class="customSelect form-control" style="display: inline-block;"><span class="customSelectInner" style="width: 209px; display: inline-block;">Wallmart</span></span>
                                </div>
                                <div class="form-group">
                                    <label>Color</label>
                                    <select class="form-control hasCustomSelect" style="-webkit-appearance: menulist-button; width: 231px; position: absolute; opacity: 0; height: 34px; font-size: 12px;">
                                        <option>White</option>
                                        <option>Black</option>
                                        <option>Red</option>
                                        <option>Green</option>
                                    </select>
                                    <span class="customSelect form-control" style="display: inline-block;"><span class="customSelectInner" style="width: 209px; display: inline-block;">White</span></span>
                                </div>
                                <div class="form-group">
                                    <label>Type</label>
                                    <select class="form-control hasCustomSelect" style="-webkit-appearance: menulist-button; width: 231px; position: absolute; opacity: 0; height: 34px; font-size: 12px;">
                                        <option>Small</option>
                                        <option>Medium</option>
                                        <option>Large</option>
                                        <option>Extra Large</option>
                                    </select>
                                    <span class="customSelect form-control" style="display: inline-block;"><span class="customSelectInner" style="width: 209px; display: inline-block;">Small</span></span>
                                </div>
                                <button class="btn btn-primary" type="submit">Filter</button>
                            </form>
                        </div>
                    </section>
                </div>
                <div class="col-md-9">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="pull-right">
                                <div style="margin: 5px 0 0 0;">
                                    @if ($products->lastPage() == 1)
                                        <ul class="pagination">
                                            <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
                                                <span class="page-link" aria-hidden="true">‹</span>
                                            </li>
                                            <li class="page-item active" wire:key="paginator-page-1-page-1" aria-current="page"><span class="page-link">1</span></li>
                                            <li class="page-item">
                                                <button type="button" dusk="nextPage" class="page-link" wire:click="nextPage('page')" wire:loading.attr="disabled" rel="next" aria-label="Next »">›</button>
                                            </li>
                                        </ul>
                                    @else
                                        {{ $products->links() }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="row product-list">
                        @forelse ($products as $product)
                            <x-product-card>
                                <x-slot name="imgSource">{{ asset('storage/'.$product->photo) }}</x-slot>
                                <x-slot name="addCartButton">
                                    <a href="#" class="adtocart">
                                        <i class="fa fa-shopping-cart"></i>
                                    </a>
                                </x-slot>
                                <x-slot name="name">{{ $product->name }}</x-slot>
                                <x-slot name="price">RM{{ $product->price }}</x-slot>
                            </x-product-card>
                        @empty
                            <span>No data available</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@push('scripts')
    <script>
        $("#uploadImgBtn").on('click',function () {
            $("#productPhoto").click();
        });
    </script>
@endpush
