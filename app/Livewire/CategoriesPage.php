<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Attributes\Title;
use Livewire\Component;

class CategoriesPage extends Component
{
    #[Title('Categories - Livewire Ecommerce')]
    public function render()
    {
        $categories = Category::where('is_active', true)->get();
        return view('livewire.categories-page', [
            'categories' => $categories
        ]);
    }
}
