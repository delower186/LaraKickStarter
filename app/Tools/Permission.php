<?php

namespace App\Tools;

use Spatie\Permission\Models\Permission as Perm;

class Permission{
    /**
     * Summary of resources
     * @var array
     * Resouces array element should be lower case singular
     */

    public static function format($permission, $resource)
    {
        $permission = strtolower(trim($permission));
        $resource = strtolower(trim($resource));

        $permissionFormatted = "{$resource}.{$permission}";


        if (Perm::where('name', $permissionFormatted)->exists()) {
            return $permissionFormatted;
        }

        throw new \InvalidArgumentException(
            "Permission '{$permissionFormatted}' does not exist."
        );
    }
}
