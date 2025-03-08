<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Create extends Component
{
    public string $title;
    public string $author;
    public string $status = "1";

    public function save()
    {
        $this->validate([
            "title"=> "required|min:5",
            "status"=> "required",
        ]);

        $category = new Category();
        $category->user_id = Auth::user()->id;
        $category->title = $this->title;
        $category->status = $this->status;
        $category->save();


        LivewireAlert::title('Success')
        ->text('Category created successfully!')
        ->success()
        ->toast()
        ->position('top-end')
        ->timer(3000) // Dismisses after 3 seconds
        ->show();


        return redirect()->route('categories.index');
    }

    public function render()
    {
        return view('livewire.categories.create');
    }

    public function mount()
    {
       $this->author = Auth::user()->name;
    }
}
