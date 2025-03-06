<?php
namespace App\Tools;

use Illuminate\Support\Facades\Auth;

class RoleManager{

    public static function getRole($role_id = null): string
    {
        $role = "";

        if ($role_id) {

            switch($role_id){
                case 0:
                    $role = 'admin';
                break;
                case 1:
                    $role = 'vendor';
                break;
                default:
                    $role = 'customer';
            }

        }else{
            switch(Auth::user()->role){
                case 0:
                    $role = 'admin';
                break;
                case 1:
                    $role = 'vendor';
                break;
                default:
                    $role = 'customer';
            }
        }

        return $role;
    }

}
