<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Devuelve los roles de un usuario
     */
    public function getRoles(int $id)
    {
        $user = User::find($id);

        $roles = $user->roles;
        return response()->json([ 'roles' => $roles ]);
    }

    /**
     * Devuelve los permisos de un usuario
     */
    public function getPermissions(int $id)
    {
        $user = User::find($id);

        $permissions = $user->permissions;
        return response()->json([ 'permissions' => $permissions ]);
    }

    /**
     * Devuelve las empresas de un usuario
     */
    public function getCompanies(int $id)
    {
        $user = User::find($id);
        $companies = $user->companies;
        return response()->json([ 'companies' => $companies ]);
    }

    /**
     * Asigna una companía a un usuario
     */
    public function assignCompany(Request $request, int $id)
    {
        $data = $request->all();
        $request->validate([
            "company_id" => "required",
        ]);

        $user = User::find($id);

        $user->companies()->attach($data['company_id']);
        $user->save();

        return response()->json([ "message" => "Compañía asignada correctamente", "companies" => $user->companies ]);
    }

    /**
     * Revoca una compañia a un usuario
     */
    public function revokeCompany(Request $request, int $id)
    {
        $data = $request->all();
        $request->validate([
            "company_id" => "required",
        ]);

        $user = User::find($id);
        $user->companies()->detach($data['company_id']);
        $user->save();

        return response()->json([ "message" => "Compañía removida correctamente", "companies" => $user->companies ]);
    }

    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|exists:roles'
        ]);

        $user->assignRole($request->name);
        return response()->json(['message' => 'Rol asignado correctamente.', 'user' => $user]);
    }

    public function removeRole(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|exists:roles'
        ]);

        $user->removeRole($request->name);
        return response()->json(['message' => 'Rol removido correctamente.', 'user' => $user]);
    }
}
