<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Illuminate\Support\Facades\DB;
use App\Tools\Permission;

class Edit extends Component
{

    public $title;
    public $author;
    public $status;
    public $id;

    public function mount($id)
    {
        $category = Category::findOrFail($id);
        $this->title = $category->title;
        $this->author = $category->user->name;
        $this->status = $category->status;
        $this->id = $id;
    }

    public function update()
    {
        $this->authorize(Permission::format('update','category'), Category::class);

        $this->validate([
            "title"=> "required|min:5",
            "status"=> "required|string",
        ]);

        $category = Category::findOrFail($this->id);

        if($category->title === $this->title && $category->status === $this->status){

            LivewireAlert::title('Nothing to Update!')
            ->text('Please change anything to update!')
            ->withConfirmButton('OK')
            ->error()
            ->show();

        }else{
            DB::transaction(function () use ($category){
                $category->user_id = Auth::user()->id;
                $category->title = $this->title;
                $category->status = $this->status;
                $category->save();
            });


            LivewireAlert::title('Success')
            ->text('Category updated successfully!')
            ->success()
            ->toast()
            ->position('top-end')
            ->timer(3000) // Dismisses after 3 seconds
            ->show();

            return redirect()->route('categories.index');
        }

    }

    public function render()
    {
        $this->authorize(Permission::format('update','category'), Category::class);
        return view('livewire.categories.edit');
    }
}
