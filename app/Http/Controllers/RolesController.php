<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function render()
    {
        $roles = Role::paginate();
        $permissions = Permission::all();
        return Inertia::render('Roles/Index', [
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }

    public function show($id)
    {
        $response = [ 'role' => Role::with('permissions')->where('id', $id)->first() ];
        return response()->json($response);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles',
        ]);
        
        $data = $request->all();

        $role = new Role();
        $role->name = $data['name'];
        $role->save();

        return response()->json(['message' => 'Registrado correctamente']);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id
        ]);
        
        $data = $request->all();

        $role->name = $data['name'];
        $role->save();

        return response()->json(['message' => 'Actualizado correctamente']);
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(['message' => 'Eliminado correctamente']);
    }
}
