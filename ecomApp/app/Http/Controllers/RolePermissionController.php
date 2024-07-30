<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class RolePermissionController extends Controller
{
    public function Role(){
        $permissions=Permission::all();
        $roles=Role::all();
        $users=User::all();
        return view('rolepermission.role',[
            'permissions'=>$permissions,
            'roles'=>$roles,
            'users'=>$users,
        ]);
    }
    public function role_store(Request $request){
        $permission = Permission::create(['name' => $request->permission_name]);

    }
    public function role_store_org(Request $request){
        $role = Role::create(['name' => $request->role_name]);
        $role->givePermissionTo($request->permission_id);


    }
    public function assign_role(Request $request){
        $user=User::find($request->user_id);
        $user->assignRole($request->role);
    }
    public function assign_role_remove($id){
        $user=User::find($id);
        $user->syncRoles([]);

    }
}
