<?php

namespace App\Http\Livewire\Staff;

use App\Models\PersonalInformation;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class StaffList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'user.name' => 'required|min:6',
        'user.email' => 'required|email|unique:users,email',
        'info.identity_no' => 'required|numeric',
        'info.phone_no' => 'required|digits_between:11,13',
        'info.age' => 'required|digits:2',
    ];

    protected $listeners = ['staffUpdated' => 'remount'];

    public $confirmingAddStaff = 'false';
    public $confirmingStaffActiveStatus = 'false';

    public User $user;
    public PersonalInformation $info;

    public $action;
    public $message;

    public $searchTerm;

    public function mount()
    {
        $this->user = new User;
        $this->info = new PersonalInformation;
    }

    public function remount()
    {
        $this->user = new User;
        $this->info = new PersonalInformation;
        sleep(1);
        $this->reset('message');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /* show modal */
        public function confirmAddStaff()
        {
            $this->action = 'add';
            $this->confirmingAddStaff = 'true';
        }

        public function confirmUpdateStaff($id)
        {
            $this->action = 'update';
            $this->user = User::where('id', $id)->withTrashed()->first();
            $this->info = PersonalInformation::where('id', $this->user->info_id)->withTrashed()->first();
            $this->confirmingAddStaff = 'true';
        }

        public function confirmActivateStaff($id)
        {
            $this->action = 'Activate';
            $this->closeMessage();
            $this->user = User::where('id', $id)->withTrashed()->first();
            $this->confirmingStaffActiveStatus = 'true';
        }

        public function confirmDeactivateStaff($id)
        {
            $this->action = 'Deactivate';
            $this->closeMessage();
            $this->user = User::where('id', $id)->first();
            $this->confirmingStaffActiveStatus = 'true';
        }
    /* show modal */

    public function addStaff()
    {
        $this->validate();

        DB::transaction(function() {
            $this->info->name = $this->user->name;
            $this->info->save();

            $currentUserCount = User::where('role_id', Role::where('name', 'Staff')->first()->id)->count();
            $userNo = 'STAF'.Carbon::now()->format('Y').Carbon::now()->format('m').sprintf('%05d', $currentUserCount + 1);

            $this->user->user_no = $userNo;
            $this->user->role_id = Role::where('name', 'Staff')->first()->id;
            $this->user->info_id = $this->info->id;
            $this->user->password = Hash::make('password');
            $this->user->save();
        });

        sleep(2);

        // $this->reset();
        $this->message = 'Added successfully';
        $this->emit('staffUpdated');
    }

    public function updateStaff()
    {
        $this->validate([
            'user.name' => 'required|min:6',
            'user.email' => 'required|email',
            'info.identity_no' => 'required|numeric',
            'info.phone_no' => 'required|digits_between:11,13',
            'info.age' => 'required|digits:2',
        ]);

        DB::transaction(function() {
            $this->info->save();
            $this->user->save();
        });

        sleep(2);

        $this->message = 'Updated successfully';
        $this->emit('staffUpdated');
    }

    public function deleteStaff($id)
    {
        $user = User::find($id);

        DB::transaction(function() use ($user) {
            $user->profile()->delete();
            $user->delete();
        });

        sleep(2);
        $this->message = 'Deactivated successfully';
    }

    public function restoreStaff($id)
    {
        $user = User::withTrashed()->find($id);

        DB::transaction(function() use ($user) {
            $user->profile()->restore();
            $user->restore();
        });

        sleep(2);
        $this->message = 'Activated successfully';
    }

    public function closeMessage()
    {
        $this->reset('message');
    }

    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';
        $data['staffs'] = User::with('profile')->withTrashed()
            ->where('role_id', Role::where('name', 'Staff')->first()->id)
            ->where('user_no', 'like', $searchTerm)
            ->orWhere('role_id', Role::where('name', 'Staff')->first()->id)
            ->where('name', 'like', $searchTerm)
            ->paginate(10);
        return view('livewire.staff.staff-list', $data);
    }
}
