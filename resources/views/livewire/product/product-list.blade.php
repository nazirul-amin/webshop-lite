@push('styles')
    <link href="{{ asset('css/custom/product-card.css') }}" rel="stylesheet" />
@endpush
<div>
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
                                <a href="" id="uploadImgBtn"><img src="{{ asset('storage/'.$productPhoto) }}" width="94"></a>
                            @else
                                <a href="" id="uploadImgBtn"><img src="{{ asset('img/placeholder-image.png') }}" width="94"></a>
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

    <!-- Delete Staff Confirmation Modal -->
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
</div>
@push('scripts')
    <script>
        $("#uploadImgBtn").on('click',function () {
            $("#productPhoto").click();
        });
    </script>
@endpush
