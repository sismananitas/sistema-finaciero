<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    public function render()
    {
        $permissions = Permission::paginate();
        return Inertia::render('Permissions/Index', [ 'permissions' => $permissions ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name'
        ]);

        $data = $request->all();

        $permission = new Permission();
        $permission->create($data);
        
        return response()->json([ 'message' => 'Registrado coreectamente' ]);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id
        ]);

        $permission->update($request->all());

        return response()->json([ 'message' => 'Actualizado coreectamente' ]);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return response()->json([ 'message' => 'Eliminado correctamente' ]);
    }
}
