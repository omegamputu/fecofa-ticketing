<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Component;

class Index extends Component
{
    public $categories;

    public function mount()
    {
        abort_unless(auth()->user()->can('categories.manage'), 403);
        $this->categories = Category::select('id', 'name', 'description')->get();

    }

    public function render()
    {
        return view('livewire.admin.category.index')->title('Liste catégories');
    }
}
