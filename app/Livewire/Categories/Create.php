<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Illuminate\Support\Facades\DB;
use App\Tools\Permission;

class Create extends Component
{
    public string $title;
    public string $author;
    public string $status = "1";

    public function save()
    {
        $this->authorize(Permission::format('create','category'), Category::class);

        $this->validate([
            "title"=> "required|min:5",
            "status"=> "required",
        ]);
        DB::transaction(function () {
            $category = new Category();
            $category->user_id = Auth::user()->id;
            $category->title = $this->title;
            $category->status = $this->status;
            $category->save();
        });

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
        $this->authorize(Permission::format('create','category'), Category::class);

        return view('livewire.categories.create');
    }

    public function mount()
    {
       $this->author = Auth::user()->name;
    }
}
