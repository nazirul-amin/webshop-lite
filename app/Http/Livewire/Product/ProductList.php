<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'product.name' => 'required|min:6',
        'product.price' => 'required',
        'product.description' => 'required',
        'product.photo' => 'required',
    ];

    protected $listeners = ['staffUpdated' => 'remount'];

    public $confirmingAddProduct = 'false';

    public Product $product;

    public $action;
    public $message;

    public $searchTerm;

    public function confirmAddProduct()
    {
        $this->action = 'add';
        $this->confirmingAddProduct = 'true';
    }

    public function confirmUpdateProduct($id)
    {
        $this->action = 'update';
        $this->product = Product::where('id', $id)->withTrashed()->first();
        $this->confirmingAddProduct = 'true';
    }

    public function mount()
    {
        $this->product = new Product;
    }

    public function remount()
    {
        $this->product = new Product;
        sleep(1);
        $this->reset('message');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';
        $data['products'] = Product::where('name', 'like', $searchTerm)
            ->orWhere('price', 'like', $searchTerm)
            ->orWhere('description', 'like', $searchTerm)
            ->paginate(16);
        return view('livewire.product.product-list', $data);
    }
}
