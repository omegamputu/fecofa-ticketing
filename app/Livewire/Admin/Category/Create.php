<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Component;

class Create extends Component
{
    public string $name = '', $description = '';

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|nullable',
        ]);

        Category::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        session()->flash('status', 'Category created successfully.');

        // Réinitialiser les champs du formulaire
        $this->reset(['name', 'description']);

        return redirect()->route('admin.categories.index');
    }

    public function render()
    {
        return view('livewire.admin.category.create')->title('Create Category');
    }
}
