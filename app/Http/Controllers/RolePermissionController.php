<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function __construct()
    {
        //$this->middleware(['role_or_permission:super-admin|index.roles|edit.roles']);
        $this->middleware(['auth']);
    }

    public function render()
    {
        $props = [
            'permissions' => Permission::all(),
            'roles' => Role::all(),
        ];
        return Inertia::render('RolesPermissions/Index', $props);
    }

    public function givePermission(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|exists:permissions'
        ]);

        $role->givePermissionTo($request->name);
        return response()->json(['message' => 'Permiso asignado correctamente.', 'role' => $role]);
    }

    public function revokePermission(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|exists:permissions,name'
        ]);

        $role->revokePermissionTo($request->name);
        return response()->json(['message' => 'Permiso revocado correctamente.', 'role' => $role]);
    }
}
