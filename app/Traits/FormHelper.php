<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission;

trait FormHelper
{    
    /**
     * groupPermissions
     *
     * @param  $group
     * @return void
     */
    public function groupPermissions($group)
    {
        return Permission::where('group_name', $group->group_name)->get();
    }
    
    /**
     * HavePermissions
     *
     * @param  $group
     * @param  $user
     * @return void
     */
    public function HavePermissions($group, $user)
    {
        $permissions = Permission::where('group_name', $group->group_name)->get();
        $count = 0;
        foreach ($permissions as  $permission) {
            if ($user->hasPermissionTo($permission->name)) {
                $count += 1;
                break;
            }
        }
        if($count > 0)
        {
            return true;
        }else{
            return false;
        }
    }

}
