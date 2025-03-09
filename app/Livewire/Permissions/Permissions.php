<?php

namespace App\Livewire\Permissions;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Permissions extends Component
{
    use WithPagination;
    protected $queryString = ['keyword'];
    public $keyword = '';
    public $searchQuery = '';

    public function render()
    {
        $permissions = Permission::orderBy("id","DESC")
        ->where("name","LIKE","%". $this->keyword ."%")
        ->paginate(10);

        return view('livewire.permissions.index', compact('permissions'));
    }

    // Ask for delete confirmation
    public function confirm($id)
    {
        LivewireAlert::title('Delete Category')
        ->text('Are you sure you want to delete this Category?')
        ->asConfirm()
        ->onConfirm('delete', ['id' => $id])
        ->show();
    }

    public function delete($data)
    {
        if($data['value'] === false){
            return false;
        }

        $permission = Permission::findOrFail($data['id']);
        $permission->delete();

        LivewireAlert::title('Success')
        ->text('Permission deleted successfully.')
        ->success()
        ->toast()
        ->position('top-end')
        ->timer(3000) // Dismisses after 3 seconds
        ->show();

        return redirect()->route("permissions.index");
    }

    public function search()
    {
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
        return redirect()->route("permissions.index");
    }
}
