<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use domain\Facades\PermissionFacade\PermissionFacade;
use Spatie\Permission\Models\Role;
use App\Traits\FormHelper;

class PermissionController extends ParentController
{
    use FormHelper;

    /**
     * groups
     *
     * @return void
     */
    public function groups()
    {
        return PermissionFacade::groups();
    }

    /**
     * allList
     *
     * @return void
     */
    public function allList()
    {
        return PermissionFacade::allList();
    }

    /**
     * rolePermissionsList
     *
     * @param  int $role_id
     * @return void
     */
    public function rolePermissionsList($role_id)
    {
        $role = Role::find($role_id);
        return $role->getAllPermissions()->pluck('name');
    }

    /**
     * updatePermissions
     *
     * @param  Request $request
     * @param  int $role_id
     * @return void
     */
    public function updatePermissions(Request $request, $role_id)
    {
        $user = Auth::user();
        if ($user->email == "Serendib@gmail.com") {
            $role = Role::find($role_id);
            $role->syncPermissions($request->permissions);
            return response()->json(['status' => 'success']);
        } else {
            $response['alert-danger'] = 'You do not have permission to update role permissions.';
            return redirect()->route('dashboard')->with($response);
        }
    }

    /**
     * print
     *
     * @param  mixed $roleData
     * @return void
     */
    public function print(Request $roleData)
    {
        $role = Auth::role();
        $response['printed_by'] = $role->name;
        $response['role'] = $roleData;
        $role = User::find($roleData->id);
        $response['tc'] =  $this;
        $response['role'] =  $role;
        $response['permissions'] =  PermissionFacade::allList();
        // $this->role = User::withTrashed()->find($roleId);
        // $this->permissions = Permission::all();
        // $this->groups = Permission::select('group')->distinct()->get();
        // dd($response['permissions']);
        $response['groups'] = PermissionFacade::groups();
        $pdf = PDF::loadView('print.pages.permission', $response);
        return $pdf->stream('Permission.pdf', ['Attachment' => false]);
    }

    /**
     * roles
     * To get all roles
     *
     * @return void
     */
    public function roles()
    {
        return Role::all();
    }
}
