<?php

namespace App\Http\Livewire\Customer;

use App\Models\PersonalInformation;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerList extends Component
{
    use WithPagination;

    public $confirmingView = 'false';

    public User $user;
    public PersonalInformation $info;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'user.name' => 'required|min:6',
        'user.email' => 'required|email|unique:users,email',
        'info.identity_no' => 'required|numeric',
        'info.phone_no' => 'required|digits_between:11,13',
        'info.age' => 'required|digits:2',
    ];

    public function confirmView($id)
    {
        $this->user = User::where('id', $id)->first();
        $this->info = PersonalInformation::where('id', $this->user->info_id)->first();
        $this->confirmingView = 'true';
    }

    public function render()
    {
        $data['customers'] = User::with('profile')->withTrashed()->where('role_id', Role::where('name', 'Customer')->first()->id)->paginate(10);
        return view('livewire.customer.customer-list', $data);
    }
}
