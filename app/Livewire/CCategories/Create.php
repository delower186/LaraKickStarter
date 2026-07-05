<?php

namespace App\Livewire\CCategories;

use Livewire\Component;
use App\Models\CourseCategory;
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
        $this->authorize(Permission::format('create','ccategory'), CourseCategory::class);

        $this->validate([
            "title"=> "required|min:3",
            "status"=> "required",
        ]);
        DB::transaction(function () {
            $category = new CourseCategory();
            $category->user_id = Auth::user()->id;
            $category->title = $this->title;
            $category->status = $this->status;
            $category->save();
        });

        LivewireAlert::title('Success')
        ->text('CCategory created successfully!')
        ->success()
        ->toast()
        ->position('top-end')
        ->timer(3000) // Dismisses after 3 seconds
        ->show();


        return redirect()->route('ccategories.list');
    }

    public function render()
    {
        $this->authorize(Permission::format('create','ccategory'), CourseCategory::class);

        return view('livewire.ccategories.create');
    }

    public function mount()
    {
       $this->author = Auth::user()->name;
    }
}
