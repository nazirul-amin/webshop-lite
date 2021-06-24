<div>
    <x-table>
        <x-slot name="title">
            Staff List
        </x-slot>
        <x-slot name="action">
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" wire:click.prevent="confirmAddStaff">
                <i class="fas fa-plus fa-sm text-white-50"></i> Add New Staff
            </a>
        </x-slot>
        <x-slot name="header">
            <tr>
                <th style="width:50px;">
                    <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                        <input type="checkbox" class="custom-control-input" id="checkAll" required="">
                        <label class="custom-control-label" for="checkAll"></label>
                    </div>
                </th>
                <th><strong>Staff No</strong></th>
                <th><strong>Name</strong></th>
                <th><strong>Identity No</strong></th>
                <th><strong>Phone No</strong></th>
                <th><strong>Age</strong></th>
                <th><strong>Status</strong></th>
                <th><strong>Action</strong></th>
            </tr>
        </x-slot>
        <x-slot name="row">
            @foreach ($staffs as $staff)
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                            <input type="checkbox" class="custom-control-input" id="customCheckBox2" required="">
                            <label class="custom-control-label" for="customCheckBox2"></label>
                        </div>
                    </td>
                    <td><strong>{{ $staff->user_no }}</strong></td>
                    <td><div class="d-flex align-items-center"><img src="images/avatar/1.jpg" class="rounded-lg mr-1" width="24" alt=""> <span class="w-space-no">{{ $staff->name }}</span></div></td>
                    <td>{{ $staff->profile->identity_no }}</td>
                    <td>{{ $staff->profile->phone_no }}</td>
                    <td>{{ $staff->profile->age }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if ($staff->deleted_at)
                                <i class="fa fa-circle text-secondary mr-1"></i> Inactive
                            @else
                                <i class="fa fa-circle text-success mr-1"></i> Active
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="d-flex">
                            <a href="#" class="btn btn-primary shadow btn-xs sharp mr-1" wire:click="confirmUpdateStaff({{ $staff->id }})"><i class="fas fa-edit"></i></a>
                            <a href="#" class="btn btn-danger shadow btn-xs sharp" wire:click="deleteStaff({{ $staff->id }})"><i class="fas fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot>
        <x-slot name="pagination">
            {{ $staffs->links() }}
        </x-slot>
    </x-table>

    <x-jet-dialog-modal wire:model="confirmingAddStaff" maxWidth="lg">
        <x-slot name="title">
            Staff Information
        </x-slot>

        <x-slot name="content">
            @if($message)
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif
            <form id="addStaffForm" {{ ($action == 'add') ? 'wire:submit.prevent=addStaff' : 'wire:submit.prevent=updateStaff' }}>
                @csrf
                <div class="form-group">
                    <x-jet-label value="{{ __('Name') }}" />
                    <x-jet-input type="text" wire:model.debounce.500ms="user.name" />
                    <x-jet-input-error for="user.name" style="display: block"></x-jet-input-error>
                </div>
                <div class="form-group">
                    <x-jet-label value="{{ __('Identity No') }}" />
                    <x-jet-input type="text" wire:model.debounce.500ms="info.identity_no" />
                    <x-jet-input-error for="info.identity_no" style="display: block"></x-jet-input-error>
                </div>
                <div class="form-group">
                    <x-jet-label value="{{ __('Email') }}" />
                    <x-jet-input type="email" wire:model.debounce.500ms="user.email" />
                    <x-jet-input-error for="user.email" style="display: block"></x-jet-input-error>
                </div>
                <div class="form-group">
                    <x-jet-label value="{{ __('Phone No') }}" />
                    <x-jet-input type="tel" wire:model.debounce.500ms="info.phone_no" />
                    <x-jet-input-error for="info.phone_no" style="display: block"></x-jet-input-error>
                </div>
                <div class="form-group">
                    <x-jet-label value="{{ __('Age') }}" />
                    <x-jet-input type="text" wire:model.debounce.500ms="info.age" />
                    <x-jet-input-error for="info.age" style="display: block"></x-jet-input-error>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingAddStaff')" wire:loading.attr="disabled">
                Cancel
            </x-jet-secondary-button>

            @if ($action == 'add')
                <x-jet-button class="ml-2" type="submit" form="addStaffForm">
                    <div class="spinner-border" role="status" wire:loading wire:target="addStaff"></div>
                    Add
                </x-jet-button>
            @endif
            @if ($action == 'update')
                <x-jet-button class="ml-2" type="submit" form="addStaffForm">
                    <div class="spinner-border" role="status" wire:loading wire:target="addStaff"></div>
                    Update
                </x-jet-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>
</div>
