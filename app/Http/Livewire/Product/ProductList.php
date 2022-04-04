<?php

namespace App\Http\Livewire\Product;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\SubProductCategory;
use Illuminate\Support\Facades\Auth;
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
        'product.category_id' => 'required',
        'product.sub_category_id' => 'present',
    ];

    protected $listeners = [
        'productAdded' => 'remount',
        'addedToCart' => 'render',
    ];

    public $confirmingAddProduct = 'false';
    public $confirmingProductActiveStatus = 'false';

    public Product $product;

    public $productPhoto;
    public $productQuantity = 1;

    public $action;
    public $message;

    public $searchTerm;

    public $category = null;
    public $subCategory = null;
    public $categoryActive = null;
    public $hasSubCategoryActive = false;
    public $subCategoryActive = null;

    public $subCategorySelection = [];

    public $confirmingAddToCart = 'false';

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

    public function filterCategory($id){
        $this->hasSubCategoryActive = SubProductCategory::where('category_id', $id)->exists();
        $this->category = $id;
        $this->categoryActive = $id;
        $this->subCategory = null;
        $this->subCategoryActive = null;
        $this->resetPage();
    }

    public function filterSubCategory($subId){
        $this->subCategory = $subId;
        $this->subCategoryActive = $subId;
        $this->resetPage();
    }

    public function resetFilterCategory(){
        $this->hasSubCategoryActive = false;
        $this->category = null;
        $this->categoryActive = null;
        $this->subCategory = null;
        $this->subCategoryActive = null;
    }

    public function confirmAddToCart($id){
        $this->product = Product::where('id', $id)->withTrashed()->first();
        $this->productPhoto = $this->product->photo;
        $this->confirmingAddToCart = 'true';
    }

    public function addToCart(){
        $cart = new Cart;
        $cart->customer_id = Auth::id();
        $cart->product_id = $this->product->id;
        $cart->quantity = $this->productQuantity;
        $cart->save();
        $this->confirmingAddToCart = 'false';
        $this->message = 'Added successfully';
        $this->emit('addedToCart');
        $this->emitTo('cart', 'addedToCart');
    }

    public function onChangeCategory(){
        $this->subCategorySelection = SubProductCategory::where('category_id', $this->product->category_id)->get();
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
        $this->emit('productAdded');
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
        $data['categories'] = ProductCategory::get();
        $data['subCategories'] = SubProductCategory::get();
        $data['products'] = Product::when($this->category, function ($query) {
            return $query->where('category_id', $this->category);
        })->when($this->subCategory, function ($query) {
            return $query->where('category_id', $this->category)->where('sub_category_id', $this->subCategory);
        })->withTrashed()->paginate(12);

        return view('livewire.product.product-list', $data);
    }
}
