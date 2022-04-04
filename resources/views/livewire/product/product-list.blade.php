@push('styles')
    <link href="{{ asset('css/custom/product-details.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/custom/product-lists.css') }}" rel="stylesheet" />
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
                                <x-jet-input type="number" step="any" wire:model.debounce.500ms="product.price" />
                                <x-jet-input-error for="product.price" style="display: block"></x-jet-input-error>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <x-jet-label value="{{ __('Category') }}" />
                                <select class="form-control" wire:model.debounce.500ms="product.category_id" wire:change="onChangeCategory">
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
                                    @forelse ($subCategorySelection as $subCategory)
                                        <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                    @empty
                                    @endforelse
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
                <x-jet-secondary-button wire:click="$toggle('confirmingProductActiveStatus')" wire:loading.attr="disabled">
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
                                <div class="text-right">
                                    <button class="btn btn-primary" type="submit">Filter</button>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
                <div class="col-md-9">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="d-sm-flex align-items-end justify-content-end">
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
                                    <a id="addToCartBtn" href="#" class="addtocart" wire:click="confirmAddToCart({{ $product->id }})">
                                        <i class="fa fa-shopping-cart"></i>
                                    </a>
                                </x-slot>
                                <x-slot name="name">{{ $product->name }}</x-slot>
                                <x-slot name="price">RM{{ $product->price }}</x-slot>
                            </x-product-card>
                        @empty
                            <div class="col-lg-12">No data available</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <x-jet-dialog-modal wire:model="confirmingAddToCart" maxWidth="lg">
            <x-slot name="title">
            </x-slot>
            <x-slot name="content">
                @if($message)
                    @livewire('component.alert-message', ['message' => $message, 'level'=>"success"])
                @endif
                <div class="product-content product-wrap clearfix product-deatil">
                    <div class="row">
                        <div class="col-md-5 col-sm-12 col-xs-12 mr-2">
                            <div class="product-image">
                                <div id="productImageControl" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img class="d-block w-100" src="{{ asset('storage/'.$productPhoto) }}" alt="First slide">
                                        </div>
                                        <div class="carousel-item">
                                            <img class="d-block w-100" src="https://via.placeholder.com/250x220/87CEFA/000000" alt="Second slide">
                                        </div>
                                        <div class="carousel-item">
                                            <img class="d-block w-100" src="https://via.placeholder.com/250x220/B0C4DE/000000" alt="Third slide">
                                        </div>
                                    </div>
                                    <a class="carousel-control-prev" href="#productImageControl" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#productImageControl" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-md-offset-1 col-sm-12 col-xs-12 ml-2">
                            <h2 class="name">
                                {{ $product->name }}
                                <br>
                                <i class="fa fa-star fa-2x text-primary"></i>
                                <i class="fa fa-star fa-2x text-primary"></i>
                                <i class="fa fa-star fa-2x text-primary"></i>
                                <i class="fa fa-star fa-2x text-primary"></i>
                                <i class="fa fa-star fa-2x text-muted"></i>
                                <span class="fa fa-2x"><h5>(109) Votes</h5></span>
                                <a href="javascript:void(0);">109 customer reviews</a>
                            </h2>
                            <hr />
                            <h3 class="price-container">
                                <div class="row">
                                    <div class="col-lg-8">
                                        RM {{ $product->price }}
                                        <small>*includes tax</small>
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="number" class="form-control" min="1" wire:model.debounce.500ms="productQuantity" >
                                    </div>
                                </div>
                            </h3>
                            <div class="certified">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);">Delivery time<span>7 Working Days</span></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">Certified<span>Quality Assured</span></a>
                                    </li>
                                </ul>
                            </div>
                            <hr />
                            <div class="description description-tabs">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#more-information" data-toggle="tab">Product Description</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#specifications" data-toggle="tab">Specifications</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#reviews" data-toggle="tab">Reviews</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="more-information">
                                        <br />
                                        <strong></strong>
                                        <br>
                                        <p>{{ $product->description }}</p>
                                    </div>
                                    <div class="tab-pane fade" id="specifications">
                                        <br />
                                        <dl class="">
                                            <dt>Gravina</dt>
                                            <dd>Etiam porta sem malesuada magna mollis euismod.</dd>
                                            <dd>Donec id elit non mi porta gravida at eget metus.</dd>
                                            <dd>Eget lacinia odio sem nec elit.</dd>
                                            <br />

                                            <dt>Test lists</dt>
                                            <dd>A description list is perfect for defining terms.</dd>
                                            <br />

                                            <dt>Altra porta</dt>
                                            <dd>Vestibulum id ligula porta felis euismod semper</dd>
                                        </dl>
                                    </div>
                                    <div class="tab-pane fade" id="reviews">
                                        <br />
                                        <form method="post" class="well padding-bottom-10" onsubmit="return false;">
                                            <textarea rows="2" class="form-control" placeholder="Write a review"></textarea>
                                            <div class="margin-top-10">
                                                <button type="submit" class="btn btn-sm btn-primary pull-right">
                                                    Submit Review
                                                </button>
                                                <a href="javascript:void(0);" class="btn btn-link profile-link-btn" rel="tooltip" data-placement="bottom" title="" data-original-title="Add Location"><i class="fa fa-location-arrow"></i></a>
                                                <a href="javascript:void(0);" class="btn btn-link profile-link-btn" rel="tooltip" data-placement="bottom" title="" data-original-title="Add Voice"><i class="fa fa-microphone"></i></a>
                                                <a href="javascript:void(0);" class="btn btn-link profile-link-btn" rel="tooltip" data-placement="bottom" title="" data-original-title="Add Photo"><i class="fa fa-camera"></i></a>
                                                <a href="javascript:void(0);" class="btn btn-link profile-link-btn" rel="tooltip" data-placement="bottom" title="" data-original-title="Add File"><i class="fa fa-file"></i></a>
                                            </div>
                                        </form>

                                        <div class="chat-body no-padding profile-message">
                                            <ul>
                                                <li class="message">
                                                    <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="online" />
                                                    <span class="message-text">
                                                        <a href="javascript:void(0);" class="username">
                                                            Alisha Molly
                                                            <span class="badge">Purchase Verified</span>
                                                            <span class="pull-right">
                                                                <i class="fa fa-star fa-2x text-primary"></i>
                                                                <i class="fa fa-star fa-2x text-primary"></i>
                                                                <i class="fa fa-star fa-2x text-primary"></i>
                                                                <i class="fa fa-star fa-2x text-primary"></i>
                                                                <i class="fa fa-star fa-2x text-muted"></i>
                                                            </span>
                                                        </a>
                                                        Can't divide were divide fish forth fish to. Was can't form the, living life grass darkness very image let unto fowl isn't in blessed fill life yielding above all moved
                                                    </span>
                                                    <ul class="list-inline font-xs">
                                                        <li>
                                                            <a href="javascript:void(0);" class="text-info"><i class="fa fa-thumbs-up"></i> This was helpful (22)</a>
                                                        </li>
                                                        <li class="pull-right">
                                                            <small class="text-muted pull-right ultra-light"> Posted 1 year ago </small>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="message">
                                                    <img src="https://bootdey.com/img/Content/avatar/avatar2.png" class="online" />
                                                    <span class="message-text">
                                                        <a href="javascript:void(0);" class="username">
                                                            Aragon Zarko
                                                            <span class="badge">Purchase Verified</span>
                                                            <span class="pull-right">
                                                                <i class="fa fa-star fa-2x text-primary"></i>
                                                                <i class="fa fa-star fa-2x text-primary"></i>
                                                                <i class="fa fa-star fa-2x text-primary"></i>
                                                                <i class="fa fa-star fa-2x text-primary"></i>
                                                                <i class="fa fa-star fa-2x text-primary"></i>
                                                            </span>
                                                        </a>
                                                        Excellent product, love it!
                                                    </span>
                                                    <ul class="list-inline font-xs">
                                                        <li>
                                                            <a href="javascript:void(0);" class="text-info"><i class="fa fa-thumbs-up"></i> This was helpful (22)</a>
                                                        </li>
                                                        <li class="pull-right">
                                                            <small class="text-muted pull-right ultra-light"> Posted 1 year ago </small>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <a href="javascript:void(0);" class="btn btn-primary" wire:click.prevent="addToCart">ADD TO CART</a>
                                </div>
                                <div class="col-sm-12 col-md-8 col-lg-8">
                                    <div class="btn-group pull-right">
                                        <button class="btn text-xs"><i class="fa fa-star"></i> Add to wishlist</button>
                                        <button class="btn text-xs"><i class="fa fa-envelope"></i> Contact Seller</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-slot>
            <x-slot name="footer">
            </x-slot>
        </x-jet-dialog-modal>
    @endif
</div>
@push('scripts')
    <script>
        $("#uploadImgBtn").on('click',function () {
            $("#productPhoto").click();
        });
    </script>
@endpush
