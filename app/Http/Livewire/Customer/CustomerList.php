<?php

namespace App\Http\Livewire\Customer;

use App\Models\CustomerInformation;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'user.name' => 'required|min:6',
        'user.email' => 'required|email|unique:users,email',
        'info.phone_no' => 'required|digits_between:11,13',
        'info.age' => 'required|digits:2',
    ];

    public $confirmingView = 'false';

    public User $user;
    public CustomerInformation $info;

    public $searchTerm;

    public function confirmView($id)
    {
        $this->info = CustomerInformation::where('id', $id)->first();
        $this->user = User::where('id', $this->info->user_id)->first();
        $this->confirmingView = 'true';
    }

    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';
        $data['customers'] = CustomerInformation::with('user')->withTrashed()
            ->where('name', 'like', $searchTerm)
            ->orWhere('phone_no', 'like', $searchTerm)
            ->paginate(10);
        return view('livewire.customer.customer-list', $data);
    }
}
