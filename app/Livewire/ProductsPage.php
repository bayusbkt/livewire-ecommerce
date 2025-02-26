<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Products - Livewire Ecommerce')]
class ProductsPage extends Component
{
    use WithPagination;
    use LivewireAlert;

    #[Url]
    public $selected_categories = [];

    #[Url]
    public $selected_brands = [];

    #[Url]
    public $featured;

    #[Url]
    public $on_sale;

    #[Url]
    public $range = 25000000;

    #[Url]
    public $sort = 'latest';

    public function addToCart($product_id)
    {
        $total_count = CartManagement::addItemToCart($product_id);

        $this->dispatch('update_cart_count', total_count: $total_count)->to(Navbar::class);

        $this->alert('success', 'Product added to the cart!', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true
        ]);
    }

    public function render()
    {
        $query = Product::where('is_active', true);

        if (!empty($this->selected_categories)) {
            $query->whereIn('category_id', $this->selected_categories);
        }

        if (!empty($this->selected_brands)) {
            $query->whereIn('brand_id', $this->selected_brands);
        }

        if ($this->featured) {
            $query->where('is_featured', true);
        }

        if ($this->on_sale) {
            $query->where('on_sale', true);
        }

        if ($this->range) {
            $query->where('price', '<=', $this->range);
        }

        if ($this->sort === 'latest') {
            $query->latest();
        } elseif ($this->sort === 'price') {
            $query->orderBy('price');
        }

        $products = $query->paginate(9);

        return view('livewire.products-page', [
            'products' => $products,
            'brands' => Brand::where('is_active', true)->get(['id', 'name', 'slug']),
            'categories' => Category::where('is_active', true)->get(['id', 'name', 'slug']),
        ]);
    }
}
