<?php

namespace App\Livewire\CCategories;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\CourseCategory;
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
        $category = CourseCategory::findOrFail($id);
        $this->title = $category->title;
        $this->author = $category->user->name;
        $this->status = $category->status;
        $this->id = $id;
    }

    public function update()
    {
        $this->authorize(Permission::format('edit','ccategory'), CourseCategory::class);

        $this->validate([
            "title"=> "required|min:5",
            "status"=> "required|string",
        ]);

        $ccategory = CourseCategory::findOrFail($this->id);

        if($ccategory->title === $this->title && $ccategory->status === $this->status){

            LivewireAlert::title('Nothing to Update!')
            ->text('Please change anything to update!')
            ->withConfirmButton('OK')
            ->error()
            ->show();

        }else{
            DB::transaction(function () use ($ccategory){
                $ccategory->user_id = Auth::user()->id;
                $ccategory->title = $this->title;
                $ccategory->status = $this->status;
                $ccategory->save();
            });


            LivewireAlert::title('Success')
            ->text('Category updated successfully!')
            ->success()
            ->toast()
            ->position('top-end')
            ->timer(3000) // Dismisses after 3 seconds
            ->show();

            return redirect()->route('ccategories.list');
        }

    }

    public function render()
    {
        $this->authorize(Permission::format('edit','ccategory'), CourseCategory::class);
        return view('livewire.ccategories.edit');
    }
}
