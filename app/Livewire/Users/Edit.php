<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Edit extends Component
{
    public $role;
    public $status;
    public $id;

    public function mount($id)
    {
        $user = User::findOrFail($id);
        $this->role = $user->role;
        $this->status = $user->status;
        $this->id = $id;
    }

    public function update()
    {
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
            $user->role = $this->role;
            $user->status = $this->status;
            $user->save();


            LivewireAlert::title('Success')
            ->text('User updated successfully!')
            ->success()
            ->toast()
            ->position('top-end')
            ->timer(3000) // Dismisses after 3 seconds
            ->show();

            return redirect()->back();
        }
    }

    public function render()
    {
        return view('livewire.users.edit');
    }
}
