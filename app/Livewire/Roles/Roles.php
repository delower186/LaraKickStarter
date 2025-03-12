<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use App\Tools\Permission;

class Roles extends Component
{
    use WithPagination;
    protected $queryString = ['keyword'];
    public $keyword = '';
    public $searchQuery = '';

    public function render()
    {
        $this->authorize(Permission::format('view','role'), Role::class);

        $roles = Role::orderBy("id","DESC")
        ->where("name","LIKE","%". $this->keyword ."%")
        ->paginate(10);

        return view('livewire.roles.index', compact('roles'));
    }

    // Ask for delete confirmation
    public function confirm($id)
    {
        $this->authorize(Permission::format('delete','role'), Role::class);
        LivewireAlert::title('Delete Role')
        ->text('Are you sure you want to delete this role?')
        ->asConfirm()
        ->onConfirm('delete', ['id' => $id])
        ->show();
    }

    public function delete($data)
    {
        $this->authorize(Permission::format('delete','role'), Role::class);

        if($data['value'] === false){
            return false;
        }

        $role = Role::findOrFail($data['id']);
        $role->delete();

        LivewireAlert::title('Success')
        ->text('Role deleted successfully.')
        ->success()
        ->toast()
        ->position('top-end')
        ->timer(3000) // Dismisses after 3 seconds
        ->show();

        return redirect()->route("roles.index");
    }

    public function search()
    {
        $this->authorize(Permission::format('view','role'), Role::class);
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
        $this->authorize(Permission::format('view','role'), Role::class);
        return redirect()->route("roles.index");
    }
}
