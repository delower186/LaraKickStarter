<?php

namespace App\Livewire\Permissions;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Illuminate\Support\Facades\DB;

class Create extends Component
{
    public string $name;

    public function render()
    {
        return view('livewire.permissions.create');
    }

    public function save()
    {
        $this->validate([
            "name"=> "required|min:5",
        ]);

        DB::transaction(function () {
            $Permission = new Permission();
            $Permission->name = $this->name;
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
