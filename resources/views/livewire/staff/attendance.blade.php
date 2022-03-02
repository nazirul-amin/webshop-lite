<div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        @if (Auth::user()->role_id == 1)
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="applied-tab" data-toggle="tab" href="#applied" role="tab" aria-controls="applied" aria-selected="true">Today</a>
            </li>
        @endif

        <li class="nav-item" role="presentation">
            <a class="nav-link {{ (Auth::user()->role_id == 2) ? 'active' : '' }}" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">Monthly</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        @if (Auth::user()->role_id == 1)
            <div class="tab-pane fade show active" id="applied" role="tabpanel" aria-labelledby="applied-tab">
                <x-table>
                    <x-slot name="title">
                    </x-slot>
                    <x-slot name="action">
                        @if (Auth::user()->role_id == 2)
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mt-4" wire:click.prevent="confirmAddAttendance">
                                <i class="fas fa-plus fa-sm text-white-50"></i> Add Record
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
                            <th class="col-2"><strong>Staff ID</strong></th>
                            <th class="col-3"><strong>Name</strong></th>
                            <th class="col-1"><strong>Date</strong></th>
                            <th class="col-1"><strong>Time</strong></th>
                        </tr>
                    </x-slot>
                    <x-slot name="row">
                        @forelse ($attendances as $row)
                            <tr>
                                <td>
                                    <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                                        <input type="checkbox" class="custom-control-input" id="customCheckBox2" required="">
                                        <label class="custom-control-label" for="customCheckBox2"></label>
                                    </div>
                                </td>
                                <td>{{ $row->staff->staff_no }}</td>
                                <td>{{ $row->staff->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->created_at)->format('H:i:s a') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No data available</td>
                            </tr>
                        @endforelse
                    </x-slot>
                    <x-slot name="pagination">
                        {{ $attendances->links() }}
                    </x-slot>
                </x-table>
            </div>
        @endif
        <div class="tab-pane fade {{ (Auth::user()->role_id == 2) ? 'show active' : '' }}" id="history" role="tabpanel" aria-labelledby="history-tab">
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
                        <th class="col-2"><strong>Staff ID</strong></th>
                        <th class="col-3"><strong>Name</strong></th>
                        <th class="col-1"><strong>Date</strong></th>
                        <th class="col-1"><strong>Time</strong></th>
                    </tr>
                </x-slot>
                <x-slot name="row">
                    @forelse ($monthlyAttendances as $row)
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                                    <input type="checkbox" class="custom-control-input" id="customCheckBox2" required="">
                                    <label class="custom-control-label" for="customCheckBox2"></label>
                                </div>
                            </td>
                            <td>{{ $row->staff->staff_no }}</td>
                            <td>{{ $row->staff->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->created_at)->format('H:i:s a') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No data available</td>
                        </tr>
                    @endforelse
                </x-slot>
                <x-slot name="pagination">
                    {{ $monthlyAttendances->links() }}
                </x-slot>
            </x-table>
        </div>
    </div>

    <x-jet-dialog-modal id="confirmAttendanceModal" wire:model="confirmingAddAttendance" maxWidth="lg">
        <x-slot name="title">
            Confirm Attendance
        </x-slot>

        <x-slot name="content">
            @if($message)
                @livewire('component.alert-message', ['message' => $message, 'level'=>"success"])
            @endif
            <form id="attendanceForm" wire:submit.prevent=addAttendance }}>
                @csrf
                <div class="form-group">
                    <x-jet-label value="{{ __('Password') }}" />
                    <x-jet-input type="text" wire:model.debounce.500ms="password" />
                    <x-jet-input-error for="password" style="display: block"></x-jet-input-error>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingAddAttendance')" wire:loading.attr="disabled">
                Cancel
            </x-jet-secondary-button>

            @if ($attendanceRecorded == 'true')
                <x-jet-button class="ml-2" type="submit" form="attendanceForm" disabled>
                    <div class="spinner-border" role="status" wire:loading wire:target="addAttendance"></div>
                    Add
                </x-jet-button>
            @endif
            @if ($attendanceRecorded == 'false')
                <x-jet-button class="ml-2" type="submit" form="attendanceForm">
                    <div class="spinner-border" role="status" wire:loading wire:target="addAttendance"></div>
                    Add
                </x-jet-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>

    {{-- <x-jet-dialog-modal wire:model="confirmingLeaveActiveStatus">
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
    </x-jet-dialog-modal> --}}
</div>
