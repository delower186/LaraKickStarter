<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Illuminate\Support\Facades\DB;


class Create extends Component
{
    public string $name;
    public $permissions;
    public $selected_permissions = [];

    public function mount()
    {
       $this->permissions = Permission::all();
    }

    public function save()
    {
        $this->validate([
            "name"=> "required|unique:roles|string|min:5",
            "selected_permissions"=>"required"
        ]);


        DB::transaction(function ()  {
            $role = new Role();
            $role->name = strtolower($this->name);
            $role->save();

            // $role->permissions()->sync($this->selected_permissions);
            foreach ($this->selected_permissions as $permission) {
                $role->givePermissionTo($permission);
            }
        });

        LivewireAlert::title('Success')
        ->text('Role created successfully!')
        ->success()
        ->toast()
        ->position('top-end')
        ->timer(3000) // Dismisses after 3 seconds
        ->show();

        return redirect()->route('roles.index');
    }

    public function render()
    {
        return view('livewire.roles.create');
    }
}
