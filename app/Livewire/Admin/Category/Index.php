<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $categories = Category::select('id', 'name', 'description')->get();

        return view('livewire.admin.category.index', compact('categories'))->title('Liste catégories');
    }

    public function delete(int $id)
    {
        abort_unless(auth()->user()->can('categories.manage'), 403);

        Category::findOrFail($id)->delete();
        
        session()->flash('status', 'Catégorie supprimée avec succès.');
    }
}
