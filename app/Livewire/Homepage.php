<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Home Page - Livewire Ecommerce')] 
class Homepage extends Component
{
    public function render()
    {
        $brands = Brand::where('is_active', true)->get();
        $categories = Category::where('is_active', true)->get();

        return view('livewire.homepage', [
            'brands' => $brands,
            'categories' => $categories
        ]);
    }
}
