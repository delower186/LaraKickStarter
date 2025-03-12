<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Illuminate\Support\Facades\DB;
use App\Tools\Permission;

class Categories extends Component
{
    use WithPagination;
    protected $queryString = ['keyword'];
    public $keyword = '';
    public $searchQuery = '';

    public function render()
    {
        $this->authorize(Permission::format('view','category'), Category::class);

        $categories = Category::orderBy("id","DESC")
                ->where("title","LIKE","%". $this->keyword ."%")
                ->paginate(10);

        return view('livewire.categories.index', compact('categories'));
    }

    // Ask for delete confirmation
    public function confirm($id)
    {
        $this->authorize(Permission::format('delete','category'), Category::class);

        LivewireAlert::title('Delete Category')
        ->text('Are you sure you want to delete this Category?')
        ->asConfirm()
        ->onConfirm('delete', ['id' => $id])
        ->show();
    }

    public function delete($data)
    {
        $this->authorize(Permission::format('delete','category'), Category::class);

        if($data['value'] === false){
            return false;
        }
        DB::transaction(function () use ($data) {
            $category = Category::findOrFail($data['id']);
            $category->delete();
        });

        LivewireAlert::title('Success')
        ->text('Category deleted successfully.')
        ->success()
        ->toast()
        ->position('top-end')
        ->timer(3000) // Dismisses after 3 seconds
        ->show();

        return redirect()->route("categories.index");
    }

    public function search()
    {
        $this->authorize(Permission::format('view','category'), Category::class);

        if($this->searchQuery != "") {
            $this->keyword = trim($this->searchQuery);

            LivewireAlert::title('Success')
            ->text('Search Successfull!')
            ->success()
            ->toast()
            ->position('top-end')
            ->timer(3000) // Dismisses after 3 seconds
            ->show();

        }else{

            LivewireAlert::title('Search Field is Empty!')
            ->text('"To Search Enter Search Term in the Search Box!')
            ->withConfirmButton('OK')
            ->error()
            ->show();

        }
    }

    public function refresh()
    {
        $this->authorize(Permission::format('view','category'), Category::class);

        return redirect()->route("categories.index");
    }
}
