<div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="applied-tab" data-toggle="tab" href="#applied" role="tab" aria-controls="applied" aria-selected="true">Applied</a>
        </li>

        @if (Auth::user()->role_id == 2)
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">History</a>
            </li>
        @endif
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="applied" role="tabpanel" aria-labelledby="applied-tab">
            <x-table>
                <x-slot name="title">
                </x-slot>
                <x-slot name="action">
                    @if (Auth::user()->role_id == 2)
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mt-4" wire:click.prevent="confirmAddLeave">
                            <i class="fas fa-plus fa-sm text-white-50"></i> Apply Leave
                        </a>
                    @endif
                </x-slot>
                <x-slot name="header">
                    <tr style="d-flex">
                        <th class="col-1">
                            <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                                <input type="checkbox" class="custom-control-input" id="checkAll" required="">
                                <label class="custom-control-label" for="checkAll"></label>
                            </div>
                        </th>
                        <th class="col-2"><strong>From - To</strong></th>
                        <th class="col-1"><strong>Type</strong></th>
                        <th class="col-4"><strong>Reasons</strong></th>
                        <th class="col-1"><strong>Action</strong></th>
                    </tr>
                </x-slot>
                <x-slot name="row">
                    @forelse ($leavesApplied as $row)
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                                    <input type="checkbox" class="custom-control-input" id="customCheckBox2" required="">
                                    <label class="custom-control-label" for="customCheckBox2"></label>
                                </div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($row->from)->format('d M Y') }} - {{ \Carbon\Carbon::parse($row->to)->format('d M Y') }}</td>
                            <td>{{ $row->type }}</td>
                            <td>{{ $row->reasons }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="#" class="btn btn-primary shadow btn-xs sharp mr-1" data-toggle="tooltip" data-placement="top" title="Edit" wire:click="confirmUpdateLeave({{ $row->id }})"><i class="fas fa-edit"></i></a>
                                    @if (Auth::user()->role_id == 1)
                                        <a href="#" class="btn btn-success shadow btn-xs sharp mr-1" data-toggle="tooltip" data-placement="top" title="Approve" wire:click="confirmApproveLeave({{ $row->id }})"><i class="fas fa-check-circle"></i></a>
                                        <a href="#" class="btn btn-danger shadow btn-xs sharp mr-1" data-toggle="tooltip" data-placement="top" title="Reject" wire:click="confirmRejectLeave({{ $row->id }})"><i class="fas fa-times-circle"></i></a>
                                    @endif
                                    @if ($row->staff_id == auth()->user()->id)
                                        <a href="#" class="btn btn-danger shadow btn-xs sharp" data-toggle="tooltip" data-placement="top" title="Cancel" wire:click="confirmCancelLeave({{ $row->id }})"><i class="fas fa-trash"></i></a>
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
                    {{ $leavesApplied->links() }}
                </x-slot>
            </x-table>
        </div>
        @if (Auth::user()->role_id == 2)
            <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                <x-table>
                    <x-slot name="title">
                    </x-slot>
                    <x-slot name="action">
                    </x-slot>
                    <x-slot name="header">
                        <tr style="d-flex">
                            <th class="col-1">
                                <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                                    <input type="checkbox" class="custom-control-input" id="checkAll" required="">
                                    <label class="custom-control-label" for="checkAll"></label>
                                </div>
                            </th>
                            <th class="col-2"><strong>From - To</strong></th>
                            <th class="col-1"><strong>Type</strong></th>
                            <th class="col-3"><strong>Status</strong></th>
                            <th class="col-3"><strong>Reasons</strong></th>
                        </tr>
                    </x-slot>
                    <x-slot name="row">
                        @forelse ($leaves as $row)
                            <tr>
                                <td>
                                    <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                                        <input type="checkbox" class="custom-control-input" id="customCheckBox2" required="">
                                        <label class="custom-control-label" for="customCheckBox2"></label>
                                    </div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($row->from)->format('d M Y') }} - {{ \Carbon\Carbon::parse($row->to)->format('d M Y') }}</td>
                                <td>{{ $row->type }}</td>
                                <td>
                                    @if ($row->status == 'Applied')
                                        <span class="badge badge-pill badge-secondary mr-1">Applied</span>
                                    @endif
                                    @if ($row->status == 'Approved')
                                        <span class="badge badge-pill badge-success mr-1">Approved</span>
                                    @endif
                                    @if ($row->status == 'Rejected')
                                        <span class="badge badge-pill badge-warning mr-1">Rejected</span>
                                    @endif
                                    @if ($row->status == 'Cancelled')
                                        <span class="badge badge-pill badge-danger mr-1">Cancelled</span>
                                    @endif
                                    @if ($row->approver_id)
                                        at {{ $row->action_at }} by <span class="text-blue">{{ $row->approver->name }}
                                    @endif
                                    @if (!$row->approver_id)
                                        at {{ $row->applied_at }} by <span class="text-blue">{{ $row->staff->name }}
                                    @endif
                                </td>
                                <td>{{ $row->reasons }}</td>
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
            </div>
        @endif
    </div>

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
            @if ($action == 'Approve' || $action == 'Reject')
                {{ __('Staff ID : '.$leave->staff->staff_no) }} <br>
                {{ __('Name : '.$leave->staff->name) }} <br>
            @endif
            {{ __('From - To : '.$leave->from.' to '.$leave->to) }} <br>
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
