<?php

namespace App\Http\Livewire\Staff;

use App\Models\Attendance as ModelsAttendance;
use App\Models\StaffInformation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Attendance extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $password;

    protected $rules = [
        'password' => 'required',
    ];

    protected $listeners = [
        'AttendanceAdded' => 'remount',
    ];

    public $confirmingAddAttendance = 'false';
    public $confirmingAttendanceActiveStatus = 'false';

    public ModelsAttendance $attendance;

    public $message;

    public $attendanceRecorded = 'false';

    public $searchTerm;

    public function mount()
    {
        $this->attendance = new ModelsAttendance;
    }

    public function remount()
    {
        $this->attendance = new ModelsAttendance;
        $this->password = '';
        sleep(1);
        $this->reset('message');
    }

    /* open up modal */
        public function confirmAddAttendance()
        {
            $this->remount();
            $this->confirmingAddAttendance = 'true';

            $staffId = StaffInformation::where('user_id', Auth::id())->first()->id;
            $attendanceToday = ModelsAttendance::whereDate('created_at', today())->where('staff_id', $staffId)->first();

            if($attendanceToday){
                $this->message = 'Attendance already recorded today';
                $this->attendanceRecorded = 'true';
            }
        }
    /* open up modal */

    public function addAttendance()
    {
        $this->validate();

        if (Hash::check($this->password, Auth::user()->password)) {
            $this->attendance->staff_id = StaffInformation::where('user_id', Auth::id())->first()->id;
            $this->attendance->created_at = Carbon::now();
            $this->attendance->updated_at = Carbon::now();

            $this->attendance->save();

            sleep(2);

            $this->message = 'Record added successfully';
            $this->emit('AttendanceAdded');
        }else {
            $this->message = 'Wrong password';
            $this->emit('AttendanceAdded');
        }

    }

    public function render()
    {
        if(Auth::user()->role_id == 1) {
            $data['attendances'] = ModelsAttendance::with('staff')->whereDate('created_at', Carbon::now())->orderBy('created_at', 'desc')->paginate(10);
            $data['monthlyAttendances'] = ModelsAttendance::with('staff')->whereBetween('created_at', [Carbon::now()->startOfMonth()->toDateString(), Carbon::now()->endOfMonth()->toDateString()])
                ->orderBy('created_at', 'desc')->paginate(10);
        }

        if(Auth::user()->role_id == 2) {
            $data['monthlyAttendances'] = ModelsAttendance::with('staff')->whereHas('staff', function($query){
                $query->where('user_id', Auth::user()->id);
            })->whereBetween('created_at', [Carbon::now()->startOfMonth()->toDateString(), Carbon::now()->endOfMonth()->toDateString()])->orderBy('created_at', 'desc')->paginate(10);
        }
        return view('livewire.staff.attendance', $data);
    }
}
