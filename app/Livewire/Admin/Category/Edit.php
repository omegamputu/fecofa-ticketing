<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Component;

class Edit extends Component
{
    public Category $category;
    public string $name = '', $description = '';

    public function mount(Category $category)
    {
        $this->category = $category;
        $this->name = $category->name;
        $this->description = $category->description ?? '';
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|nullable',
        ]);

        $this->category->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        session()->flash('status', 'Category updated successfully.');

        return redirect()->route('admin.categories.index');
    }

    public function render()
    {
        return view('livewire.admin.category.edit')->title('Edit Category');
    }
}
