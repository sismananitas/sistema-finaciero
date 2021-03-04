<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function render()
    {
        $users = User::all();
        $roles = Role::all();
        return Inertia::render('Users/Index', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    public function index()
    {
        $users = User::all();
        return response()->json(['users' => $users]);
    }

    public function show($id)
    {
        return response()
        ->json([
            'user' => User::with('roles')->where('id', $id)->first()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $data = $request->all();
        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email',
            'password'  => 'required|confirmed',
            'password_confirmation' => 'nullable',
        ]);

        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->save();
        
        $this->createTeam($user);

        return response()->json(['message' => 'Registrado correctamente', 'user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->all();
        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email',
            'password'  => 'nullable|confirmed',
            'password_confirmation' => 'nullable',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        
        if (!empty($data['password']))
            $user->password = bcrypt($data['password']);

        $user->save();

        return response()->json(['message' => 'Actualizado correctamente', 'user' => $user]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'Eliminado correctamente', 'user' => $user]);
    }

    /**
     * Create a personal team for the user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    protected function createTeam(User $user)
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
    }
}
