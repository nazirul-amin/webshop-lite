<div>
    <x-table>
        <x-slot name="title">
            Leave List
        </x-slot>
        <x-slot name="action">
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" wire:click.prevent="confirmAddLeave">
                <i class="fas fa-plus fa-sm text-white-50"></i> Apply Leave
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
                <th class="col-2"><strong>Applied Date</strong></th>
                <th class="col-2"><strong>Approval Date</strong></th>
                <th class="col-1"><strong>Type</strong></th>
                <th class="col-1"><strong>Status</strong></th>
                <th class="col-4"><strong>Reasons</strong></th>
                <th class="col-1"><strong>Action</strong></th>
            </tr>
        </x-slot>
        <x-slot name="row">
            @forelse ($leaves as $leave)
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                            <input type="checkbox" class="custom-control-input" id="customCheckBox2" required="">
                            <label class="custom-control-label" for="customCheckBox2"></label>
                        </div>
                    </td>
                    <td>{{ $leave->applied_at }}</td>
                    <td>{{ $leave->approved_at ?? '0000-00-00' }} by <span class="text-blue">{{ $leave->user->name ?? 'N/A' }}</span></td>
                    <td>{{ $leave->type }}</td>
                    @if ($leave->status == 'Applied')
                        <td><span class="badge badge-pill badge-secondary mr-1">Applied</span></td>
                    @endif
                    @if ($leave->status == 'Approved')
                        <td><span class="badge badge-pill badge-success mr-1">Approved</span></td>
                    @endif
                    @if ($leave->status == 'Rejected')
                        <td><span class="badge badge-pill badge-danger mr-1">Rejected</span></td>
                    @endif
                    <td>{{ $leave->reasons }}</td>
                    <td>
                        <div class="d-flex">
                            <a href="#" class="btn btn-primary shadow btn-xs sharp mr-1" data-toggle="tooltip" data-placement="top" title="Edit" wire:click="confirmUpdateLeave({{ $leave->id }})"><i class="fas fa-edit"></i></a>
                            <a href="#" class="btn btn-success shadow btn-xs sharp mr-1" data-toggle="tooltip" data-placement="top" title="Approve" wire:click="confirmApproveLeave({{ $leave->id }})"><i class="fas fa-check-circle"></i></a>
                            <a href="#" class="btn btn-danger shadow btn-xs sharp mr-1" data-toggle="tooltip" data-placement="top" title="Reject" wire:click="confirmRejectLeave({{ $leave->id }})"><i class="fas fa-times-circle"></i></a>
                            @if ($leave->staff_id == auth()->user()->id)
                                <a href="#" class="btn btn-danger shadow btn-xs sharp" data-toggle="tooltip" data-placement="top" title="Cancel" wire:click="confirmCancelLeave({{ $leave->id }})"><i class="fas fa-trash"></i></a>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No data available</td>
                </tr>
            @endforelse
        </x-slot>
        <x-slot name="pagination">
            {{ $leaves->links() }}
        </x-slot>
    </x-table>

    <x-jet-dialog-modal wire:model="confirmingAddLeave" maxWidth="lg">
        <x-slot name="title">
            Leave Application
        </x-slot>

        <x-slot name="content">
            @if($message)
                @livewire('component.alert-message', ['message' => $message, 'level'=>"success"])
            @endif
            <form id="leaveForm" {{ ($action == 'add') ? 'wire:submit.prevent=addLeave' : 'wire:submit.prevent=updateLeave' }}>
                @csrf
                <div class="form-group">
                    <x-jet-label value="{{ __('Leave Type') }}" />
                    <x-jet-input type="text" wire:model.debounce.500ms="leave.type" />
                    <x-jet-input-error for="leave.type" style="display: block"></x-jet-input-error>
                </div>
                <div class="form-group">
                    <x-jet-label value="{{ __('From') }}" />
                    <x-jet-input type="date" wire:model.debounce.500ms="leave.from" />
                    {{-- <x-date-picker wire:model="leave.from" id="date"/> --}}
                    <x-jet-input-error for="leave.from" style="display: block"></x-jet-input-error>
                </div>
                <div class="form-group">
                    <x-jet-label value="{{ __('To') }}" />
                    <x-jet-input type="date" wire:model.debounce.500ms="leave.to" />
                    <x-jet-input-error for="leave.to" style="display: block"></x-jet-input-error>
                </div>
                <div class="form-group">
                    <x-jet-label value="{{ __('Reasons') }}" />
                    <textarea class="form-control" cols="30" rows="5" wire:model.debounce.500ms="leave.reasons"></textarea>
                    <x-jet-input-error for="leave.reasons" style="display: block"></x-jet-input-error>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingAddLeave')" wire:loading.attr="disabled">
                Cancel
            </x-jet-secondary-button>

            @if ($action == 'add')
                <x-jet-button class="ml-2" type="submit" form="leaveForm">
                    <div class="spinner-border" role="status" wire:loading wire:target="addLeave"></div>
                    Add
                </x-jet-button>
            @endif
            @if ($action == 'update')
                <x-jet-button class="ml-2" type="submit" form="leaveForm">
                    <div class="spinner-border" role="status" wire:loading wire:target="updateLeave"></div>
                    Update
                </x-jet-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="confirmingLeaveActiveStatus">
        <x-slot name="title">
            {{ __($action.' Leave') }}
        </x-slot>

        <x-slot name="content">
            @if($message)
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif
            {{ __('Are you sure you want to '.strtolower($action).' this Leave ?') }} <br>
            {{ __('Leave ID : '.$leave->id) }} <br>
            {{ __('type : '.$leave->type) }} <br>
            {{ __('reasons : '.$leave->reasons) }} <br>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingLeaveActiveStatus')"
                                    wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            @if ($action == 'Cancel')
                <x-jet-danger-button wire:click="cancelLeave({{ $leave->id }})" wire:loading.attr="disabled">
                    <div class="spinner-border" role="status" wire:loading wire:target="cancelLeave"></div>
                    {{ $action }}
                </x-jet-danger-button>
            @endif
            @if ($action == 'Reject')
                <x-jet-danger-button wire:click="rejectLeave({{ $leave->id }})" wire:loading.attr="disabled">
                    <div class="spinner-border" role="status" wire:loading wire:target="rejectLeave"></div>
                    {{ $action }}
                </x-jet-danger-button>
            @endif
            @if ($action == 'Approve')
                <x-jet-button wire:click="approveLeave({{ $leave->id }})" wire:loading.attr="disabled" style="background-color: #1cc88a; border-color: #1cc88a">
                    <div class="spinner-border" role="status" wire:loading wire:target="approveLeave"></div>
                    {{ $action }}
                </x-jet-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>
</div>
