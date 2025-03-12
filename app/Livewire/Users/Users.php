<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use App\Tools\Permission;

class Users extends Component
{
    use WithPagination;
    protected $queryString = ['keyword'];
    public $keyword = '';
    public $searchQuery = '';

    public function render()
    {
        $this->authorize(Permission::format('view','user'), User::class);

        $users = User::orderBy("id","DESC")
        ->where("name","LIKE","%". $this->keyword ."%")
        ->paginate(10);

        return view('livewire.users.index', compact('users'));
    }


    // Ask for delete confirmation
    public function confirm($id)
    {
        $this->authorize(Permission::format('delete','user'), User::class);
        LivewireAlert::title('Delete User')
        ->text('Are you sure you want to delete this user?')
        ->asConfirm()
        ->onConfirm('delete', ['id' => $id])
        ->show();
    }

    public function delete($data)
    {
        $this->authorize(Permission::format('delete','user'), User::class);

        if($data['value'] === false){
            return false;
        }

        $user = User::findOrFail($data['id']);
        $user->delete();

        LivewireAlert::title('Success')
        ->text('User deleted successfully.')
        ->success()
        ->toast()
        ->position('top-end')
        ->timer(3000) // Dismisses after 3 seconds
        ->show();

        return redirect()->route("users.index");
    }

    public function search()
    {
        $this->authorize(Permission::format('view','user'), User::class);

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
        $this->authorize(Permission::format('view','user'), User::class);

        return redirect()->route("users.index");
    }
}
