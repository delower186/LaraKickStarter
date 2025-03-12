<?php

namespace App\Livewire\Permissions;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Illuminate\Support\Facades\DB;
use App\Tools\Helpers;
use App\Tools\Permission as Perm;

class Edit extends Component
{
    public $name;
    public $id;

    public function mount($id)
    {
        $permission = Permission::findOrFail($id);
        $this->name = $permission->name;
        $this->id = $id;
    }

    public function update()
    {
        $this->authorize(Perm::format('update','permission'), Permission::class);

        $this->validate([
            "name"=> "required|min:5",
        ]);

        $permission = Permission::findOrFail($this->id);

        if($permission->name === $this->name){

            LivewireAlert::title('Nothing to Update!')
            ->text('Please change anything to update!')
            ->withConfirmButton('OK')
            ->error()
            ->show();

        }else{

            DB::transaction(function () use ($permission) {
                $permission->name = Helpers::format($this->name);
                $permission->save();
            });

            LivewireAlert::title('Success')
            ->text('Permission updated successfully!')
            ->success()
            ->toast()
            ->position('top-end')
            ->timer(3000) // Dismisses after 3 seconds
            ->show();

            return redirect()->route('permissions.index');
        }

    }

    public function render()
    {
        $this->authorize(Perm::format('update','permission'), Permission::class);

        return view('livewire.permissions.edit');
    }
}
