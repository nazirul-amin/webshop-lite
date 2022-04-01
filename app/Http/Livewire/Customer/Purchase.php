<?php

namespace App\Http\Livewire\Customer;

use App\Models\Purchase as ModelsPurchase;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Purchase extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $password;

    protected $rules = [
        'password' => 'required',
    ];

    protected $listeners = [
        'PurchaseAdded' => 'remount',
    ];

    public $confirmingAddPurchase = 'false';
    public $confirmingPurchaseActiveStatus = 'false';

    public ModelsPurchase $purchase;

    public $message;

    public $searchTerm;

    public function render()
    {
        if(Auth::user()->role_id == 1) {
            $data['purchases'] = ModelsPurchase::with('products')->orderBy('created_at', 'desc')->paginate(10);
            $data['monthlyPurchases'] = ModelsPurchase::with('products')
                ->whereBetween('created_at', [Carbon::now()->startOfMonth()->toDateString(), Carbon::now()->endOfMonth()->toDateString()])
                ->orderBy('created_at', 'desc')->paginate(10);
        }

        if(Auth::user()->role_id == 3) {
            $data['purchases'] = ModelsPurchase::with('products')->where('customer_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
            $data['monthlyPurchases'] = ModelsPurchase::with('products')
                ->where('customer_id', Auth::user()->id)->whereBetween('created_at', [Carbon::now()->startOfMonth()->toDateString(), Carbon::now()->endOfMonth()->toDateString()])
                ->orderBy('created_at', 'desc')->paginate(10);
        }

        return view('livewire.customer.purchase', $data);
    }
}
