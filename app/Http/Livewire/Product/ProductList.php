<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'product.name' => 'required|min:6',
        'product.price' => 'required',
        'product.description' => 'required',
        'productPhoto' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:2048',
    ];

    protected $listeners = [
        'productAdded' => 'remount',
    ];

    public $confirmingAddProduct = 'false';
    public $confirmingProductActiveStatus = 'false';

    public Product $product;

    public $productPhoto;

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

    public function confirmActivateProduct($id)
    {
        $this->action = 'Activate';
        $this->closeMessage();
        $this->product = Product::where('id', $id)->withTrashed()->first();
        $this->confirmingProductActiveStatus = 'true';
    }

    public function confirmDeactivateProduct($id)
    {
        $this->action = 'Deactivate';
        $this->closeMessage();
        // $this->product = Product::where('id', $id)->first();
        $this->confirmingProductActiveStatus = 'true';
    }

    public function mount()
    {
        $this->product = new Product;
    }

    public function remount()
    {
        $this->product = new Product;
        $this->reset('productPhoto');
        sleep(1);
        $this->reset('message');
    }

    public function addProduct()
    {
        $this->validate();

        DB::transaction(function() {
            $photoUrl = $this->productPhoto->storeAs('product_images', $this->product->name.'.png', 'public');
            $this->product->photo = $photoUrl;

            $this->product->save();
        });

        sleep(2);

        $this->message = 'Added successfully';
        $this->emit('productAdded');
    }

    public function updateProduct()
    {
        $this->validate([
            'product.name' => 'required|min:6',
            'product.price' => 'required',
            'product.description' => 'required',
        ]);

        DB::transaction(function() {
            if($this->productPhoto){
                $photoUrl = $this->productPhoto->storeAs('product_images', $this->product->name.'.png', 'public');
                $this->product->photo = $photoUrl;
            }
            $this->product->save();
        });

        sleep(2);

        $this->message = 'Updated successfully';
        sleep(1);
        $this->closeMessage();
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);

        $product->delete();

        sleep(2);
        $this->message = 'Deactivated successfully';
    }

    public function restoreProduct($id)
    {
        $product = Product::withTrashed()->find($id);

        $product->restore();

        sleep(2);
        $this->message = 'Activated successfully';
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
        $data['products'] = Product::where('name', 'like', $searchTerm)
            ->orWhere('price', 'like', $searchTerm)
            ->orWhere('description', 'like', $searchTerm)
            ->withTrashed()
            ->paginate(16);
        return view('livewire.product.product-list', $data);
    }
}
