<?php

namespace App\Livewire\CCategories;

use Livewire\Component;
use App\Models\CourseCategory;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Illuminate\Support\Facades\DB;
use App\Tools\Permission;

class CCategories extends Component
{
    use WithPagination;
    protected $queryString = ['keyword'];
    public $keyword = '';
    public $searchQuery = '';

    public function render()
    {
        $this->authorize(Permission::format('view','ccategory'), CourseCategory::class);

        $ccategories = CourseCategory::orderBy("id","DESC")
                ->where("title","LIKE","%". $this->keyword ."%")
                ->paginate(10);

        return view('livewire.ccategories.index', compact('ccategories'));
    }
}
