<?php

namespace App\Tools;

use Spatie\Permission\Models\Permission as Perm;

class Permission{
    /**
     * Summary of resources
     * @var array
     * Resouces array element should be lower case singular
     */
    public static $resources = ['blog','category','user','role','permission'];

    public static function format($permission,$resource)
    {
        $permissionFormatted = '';
        $permission = strtolower($permission);
        $resource = strtolower($resource);
        $resources = array_map('strtolower', self::$resources);

        if (in_array($resource, $resources)) {
            $permissionFormatted = $permission."_". $resource;

            return $permissionFormatted;
        }else{
            abort(404);
        }

        if (!in_array($permissionFormatted, Perm::all())) {
            abort(404);
        }
    }
}
