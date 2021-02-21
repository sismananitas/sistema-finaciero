<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccountsController extends Controller
{
    public function render()
    {
        $accounts = Account::all();
        return Inertia::render('Accounts/Index', [ 'accounts' => $accounts ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'number' => 'required|numeric',
            'type' => 'required',
            'holder' => 'required',
            'description' => 'nullable',
        ]);

        $data = $request->all();

        $account = new Account();
        $account->name = $data['name'];
        $account->number = $data['number'];
        $account->type = $data['type'];
        $account->holder = $data['holder'];
        $account->description = $data['description'] ?? '';
        $account->balance = 0;
        $account->save();

        return response()->json([ 'message' => 'Registrada correctamente' ]);
    }
}
