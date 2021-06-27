<div>
    <x-table>
        <x-slot name="title">
            Customer List
        </x-slot>
        <x-slot name="action">
        </x-slot>
        <x-slot name="header">
            <tr>
                <th style="width:50px;">
                    <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                        <input type="checkbox" class="custom-control-input" id="checkAll" required="">
                        <label class="custom-control-label" for="checkAll"></label>
                    </div>
                </th>
                <th><strong>Customer ID</strong></th>
                <th><strong>Name</strong></th>
                <th><strong>Identity No</strong></th>
                <th><strong>Phone No</strong></th>
                <th><strong>Age</strong></th>
                <th><strong>Status</strong></th>
                <th><strong>Action</strong></th>
            </tr>
        </x-slot>
        <x-slot name="row">
            @foreach ($customers as $customer)
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                            <input type="checkbox" class="custom-control-input" id="customCheckBox2" required="">
                            <label class="custom-control-label" for="customCheckBox2"></label>
                        </div>
                    </td>
                    <td><strong>{{ $customer->user_no }}</strong></td>
                    <td><div class="d-flex align-items-center"><img src="images/avatar/1.jpg" class="rounded-lg mr-1" width="24" alt=""> <span class="w-space-no">{{ $customer->name }}</span></div></td>
                    <td>{{ $customer->profile->identity_no }}</td>
                    <td>{{ $customer->profile->phone_no }}</td>
                    <td>{{ $customer->profile->age }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if ($customer->deleted_at)
                                <i class="fa fa-circle text-secondary mr-1"></i> Inactive
                            @else
                                <i class="fa fa-circle text-success mr-1"></i> Active
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="d-flex">
                            <a href="#" class="btn btn-primary shadow btn-xs sharp mr-1" wire:click="confirmView({{ $customer->id }})"><i class="fas fa-eye"></i></a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot>
        <x-slot name="pagination">
            {{ $customers->links() }}
        </x-slot>
    </x-table>

    <x-jet-dialog-modal wire:model="confirmingView" maxWidth="lg">
        <x-slot name="title">
            Customer Information
        </x-slot>

        <x-slot name="content">
            <div class="form-group">
                <x-jet-label value="{{ __('Name') }}" />
                <x-jet-input type="text" wire:model.debounce.500ms="user.name" readonly />
            </div>
            <div class="form-group">
                <x-jet-label value="{{ __('Identity No') }}" />
                <x-jet-input type="text" wire:model.debounce.500ms="info.identity_no" readonly />
            </div>
            <div class="form-group">
                <x-jet-label value="{{ __('Email') }}" />
                <x-jet-input type="email" wire:model.debounce.500ms="user.email" readonly />
            </div>
            <div class="form-group">
                <x-jet-label value="{{ __('Phone No') }}" />
                <x-jet-input type="tel" wire:model.debounce.500ms="info.phone_no" readonly />
            </div>
            <div class="form-group">
                <x-jet-label value="{{ __('Age') }}" />
                <x-jet-input type="text" wire:model.debounce.500ms="info.age" readonly />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingView')" wire:loading.attr="disabled">
                Close
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
