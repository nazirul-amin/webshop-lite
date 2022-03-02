<?php

namespace App\Http\Livewire\Staff;

use App\Models\Leave as ModelsLeave;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class Leave extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'leave.type' => 'required',
        'leave.reasons' => 'required',
        'leave.from' => 'required',
        'leave.to' => 'required',
    ];

    protected $listeners = [
        'LeaveAdded' => 'remount',
    ];

    public $confirmingAddLeave = 'false';
    public $confirmingLeaveActiveStatus = 'false';

    public ModelsLeave $leave;

    public $action;
    public $message;

    public $searchTerm;

    public function mount()
    {
        $this->leave = new ModelsLeave;
    }

    public function remount()
    {
        $this->leave = new ModelsLeave;
        sleep(1);
        $this->reset('message');
    }

    /* open up modal */
        public function confirmAddLeave()
        {
            $this->remount();
            $this->action = 'add';
            $this->confirmingAddLeave = 'true';
        }

        public function confirmUpdateLeave($id)
        {
            $this->action = 'update';
            $this->leave = ModelsLeave::where('id', $id)->first();
            $this->confirmingAddLeave = 'true';
        }

        public function confirmApproveLeave($id)
        {
            $this->action = 'Approve';
            $this->closeMessage();
            $this->leave = ModelsLeave::with('staff:user_id,name,staff_no')->where('id', $id)->first();
            $this->confirmingLeaveActiveStatus = 'true';
        }

        public function confirmRejectLeave($id)
        {
            $this->action = 'Reject';
            $this->closeMessage();
            $this->leave = ModelsLeave::with('staff:user_id,name,staff_no')->where('id', $id)->first();
            $this->confirmingLeaveActiveStatus = 'true';
        }

        public function confirmCancelLeave($id)
        {
            $this->action = 'Cancel';
            $this->closeMessage();
            $this->leave = ModelsLeave::where('id', $id)->first();
            $this->confirmingLeaveActiveStatus = 'true';
        }
    /* open up modal */

    public function addLeave()
    {
        $this->validate();

        $this->leave->applied_at = Carbon::now();
        $this->leave->staff_id = Auth::id();
        $this->leave->status = 'Applied';

        $this->leave->save();

        sleep(2);

        $this->message = 'Applied successfully';
        $this->emit('LeaveAdded');
    }

    public function updateLeave()
    {
        $this->validate();

        $this->leave->save();

        sleep(2);

        $this->message = 'Updated successfully';
        sleep(2);
        $this->closeMessage();
    }

    public function cancelLeave($id)
    {
        Gate::authorize('cancel-leave', $this->leave);

        $this->leave = ModelsLeave::where('id', $id)->first();
        $this->leave->action_at = Carbon::now();
        $this->leave->approver_id = Auth::id();
        $this->leave->status = 'Cancelled';

        $this->leave->save();

        sleep(2);
        $this->message = 'Cancelled successfully';
    }

    public function rejectLeave($id)
    {
        Gate::authorize('approve-leave', Auth::user());

        $this->leave = ModelsLeave::where('id', $id)->first();
        $this->leave->action_at = Carbon::now();
        $this->leave->approver_id = Auth::id();
        $this->leave->status = 'Rejected';

        $this->leave->save();

        sleep(2);
        $this->message = 'Rejected successfully';
    }

    public function approveLeave($id)
    {
        Gate::authorize('approve-leave', Auth::user());

        $this->leave = ModelsLeave::where('id', $id)->first();
        $this->leave->action_at = Carbon::now();
        $this->leave->approver_id = Auth::id();
        $this->leave->status = 'Approved';

        $this->leave->save();

        sleep(2);
        $this->message = 'Approved successfully';
    }

    public function closeMessage()
    {
        $this->reset('message');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';
        if(Auth::user()->role_id != 1) {
            $data['leavesApplied'] = ModelsLeave::with('approver:user_id,name', 'staff:user_id,name')
                ->where('staff_id', Auth::id())
                ->where('status', 'Applied')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            $data['leaves'] = ModelsLeave::with('approver:user_id,name', 'staff:user_id,name')->where('staff_id', Auth::id())->where('status', 'Applied')
                ->where('applied_at', 'like', $searchTerm)
                ->orWhere('staff_id', Auth::id())
                ->where('action_at', 'like', $searchTerm)
                ->orWhere('staff_id', Auth::id())
                ->where('type', 'like', $searchTerm)
                ->orWhere('staff_id', Auth::id())
                ->where('reasons', 'like', $searchTerm)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        if(Auth::user()->role_id == 1) {
            $data['leavesApplied'] = ModelsLeave::with('approver:user_id,name', 'staff:user_id,name')
                ->where('applied_at', 'like', $searchTerm)
                ->where('status', 'Applied')
                ->orWhere('action_at', 'like', $searchTerm)
                ->where('status', 'Applied')
                ->orWhere('type', 'like', $searchTerm)
                ->where('status', 'Applied')
                ->orWhere('reasons', 'like', $searchTerm)
                ->where('status', 'Applied')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        return view('livewire.staff.leave', $data);
    }
}
