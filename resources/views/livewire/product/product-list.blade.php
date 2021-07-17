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
            @foreach ($products as $product)
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                            <input type="checkbox" class="custom-control-input" id="customCheckBox2" required="">
                            <label class="custom-control-label" for="customCheckBox2"></label>
                        </div>
                    </td>
                    <td><strong>{{ $product->id }}</strong></td>
                    <td><div class="d-flex align-items-center"><img src="{{ $product->photo }}" class="rounded-lg mr-1" width="70" alt=""> <span class="w-space-no">{{ $product->name }}</span></div></td>
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
                            <a href="#" class="btn btn-primary shadow btn-xs sharp mr-1" data-toggle="tooltip" data-placement="top" title="Edit" wire:click="confirmUpdateStaff({{ $product->id }})"><i class="fas fa-edit"></i></a>
                            @if ($product->deleted_at)
                                <a href="#" class="btn btn-success shadow btn-xs sharp" data-toggle="tooltip" data-placement="top" title="Activate" wire:click="confirmActivateStaff({{ $product->id }})"><i class="fas fa-toggle-on"></i></a>
                            @else
                                <a href="#" class="btn btn-danger shadow btn-xs sharp" data-toggle="tooltip" data-placement="top" title="Deactivate" wire:click="confirmDeactivateStaff({{ $product->id }})"><i class="fas fa-trash"></i></a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
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
                            <img src="{{ asset('img/placeholder-image.png') }}" width="94">
                        </div>
                        <x-jet-input type="file" wire:model.debounce.500ms="product.photo" />
                        <x-jet-input-error for="product.photo" style="display: block"></x-jet-input-error>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <x-jet-label value="{{ __('Name') }}" />
                            <x-jet-input type="text" wire:model.debounce.500ms="product.name" />
                            <x-jet-input-error for="product.name" style="display: block"></x-jet-input-error>
                        </div>
                        <div class="form-group">
                            <x-jet-label value="{{ __('Price') }}" />
                            <x-jet-input type="number" step="2" wire:model.debounce.500ms="product.price" />
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
                    <div class="spinner-border" role="status" wire:loading wire:target="addProduct"></div>
                    Update
                </x-jet-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>
</div>

