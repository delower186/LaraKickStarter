<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Tools\Permission;

class Edit extends Component
{
    public $role;
    public $roles;
    public $status;
    public $id;

    public function mount($id)
    {
        $user = User::findOrFail($id);
        $this->roles = Role::all();
        $this->role = $user->role;
        $this->status = $user->status;
        $this->id = $id;
    }

    public function update()
    {
        $this->authorize(Permission::format('edit','user'), User::class);

        $this->validate([
            "role"=> "required",
            "status"=> "required",
        ]);

        $user = User::findOrFail($this->id);

        if($user->role === $this->role && $user->status === $this->status){

            LivewireAlert::title('Nothing to Update!')
            ->text('Please change anything to update!')
            ->withConfirmButton('OK')
            ->error()
            ->show();

        }else{
            DB::transaction(function () use ($user) {
                $user->status = $this->status;
                $user->save();

                $user->syncRoles([$this->role]);
            });

            LivewireAlert::title('Success')
            ->text('User updated successfully!')
            ->success()
            ->toast()
            ->position('top-end')
            ->timer(3000) // Dismisses after 3 seconds
            ->show();

            return redirect()->route('users.index');
        }
    }

    public function render()
    {
        $this->authorize(Permission::format('edit','user'), User::class);
        return view('livewire.users.edit');
    }
}
