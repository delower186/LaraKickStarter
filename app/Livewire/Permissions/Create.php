<?php

namespace App\Livewire\Permissions;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Illuminate\Support\Facades\DB;
use App\Tools\Helpers;
use App\Tools\Permission as Perm;

class Create extends Component
{
    public string $name;

    public function render()
    {
        $this->authorize(Perm::format('create','permission'), Permission::class);

        return view('livewire.permissions.create');
    }

    public function save()
    {
        $this->authorize(Perm::format('create','permission'), Permission::class);

        $this->validate([
            "name"=> "required|min:5",
        ]);

        DB::transaction(function () {
            $Permission = new Permission();
            $Permission->name = Helpers::format($this->name);
            $Permission->save();
        });

        LivewireAlert::title('Success')
        ->text('Permission created successfully!')
        ->success()
        ->toast()
        ->position('top-end')
        ->timer(3000) // Dismisses after 3 seconds
        ->show();


        return redirect()->route('permissions.index');
    }
}
