<?php

namespace App\Livewire\Permissions;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use App\Tools\Permission as Perm;

class Permissions extends Component
{
    use WithPagination;
    protected $queryString = ['keyword'];
    public $keyword = '';
    public $searchQuery = '';

    public function render()
    {
        $this->authorize(Perm::format('view','permission'), Permission::class);

        $permissions = Permission::orderBy("id","DESC")
        ->where("name","LIKE","%". $this->keyword ."%")
        ->paginate(10);

        return view('livewire.permissions.index', compact('permissions'));
    }

    // Ask for delete confirmation
    public function confirm($id)
    {
        $this->authorize(Perm::format('delete','permission'), Permission::class);

        LivewireAlert::title('Delete Permission')
        ->text('Are you sure you want to delete this Permission?')
        ->asConfirm()
        ->onConfirm('delete', ['id' => $id])
        ->show();
    }

    public function delete($data)
    {
        $this->authorize(Perm::format('delete','permission'), Permission::class);

        if($data['value'] === false){
            return false;
        }

        DB::transaction(function () use ($data) {
            $permission = Permission::findOrFail($data['id']);
            $permission->delete();
        });

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
        $this->authorize(Perm::format('view','permission'), Permission::class);

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
        $this->authorize(Perm::format('view','permission'), Permission::class);

        return redirect()->route("permissions.index");
    }
}
