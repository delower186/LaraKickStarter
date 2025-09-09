<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Illuminate\Support\Facades\DB;
use App\Tools\Helpers;
use App\Tools\Permission as Perm;

class Edit extends Component
{
    public $name;
    public $id;
    public $permissions;
    public $selected_permissions;

    public function mount($id)
    {
        $role = Role::findOrFail($id);
        $this->selected_permissions = $role->permissions()->pluck("name")->toArray();
        $this->permissions = Permission::all();
        $this->name = $role->name;
        $this->id = $id;
    }

    public function update()
    {
        $this->authorize(Perm::format('edit','role'), Role::class);
        $role = Role::findOrFail($this->id);

        $this->validate([
            "name"=> "required|string|min:5|unique:roles,name,".$this->id,
            "selected_permissions"=>"required"
        ]);


        if($role->name === $this->name && $this->selected_permissions === $role->permissions()->pluck("name")->toArray()) {

            LivewireAlert::title('Nothing to Update!')
            ->text('Please change anything to update!')
            ->withConfirmButton('OK')
            ->error()
            ->show();

        }else{

            DB::transaction(function () use ($role) {
                $role->name = Helpers::format($this->name,'-');
                $role->save();

                $role->syncPermissions($this->selected_permissions);
            });

            LivewireAlert::title('Success')
            ->text('Role updated successfully!')
            ->success()
            ->toast()
            ->position('top-end')
            ->timer(3000) // Dismisses after 3 seconds
            ->show();

            return redirect()->route('roles.index');
        }

    }

    public function render()
    {
        $this->authorize(Perm::format('edit','role'), Role::class);
        return view('livewire.roles.edit');
    }
}
