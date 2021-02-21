<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function render()
    {
        $accounts = Account::all();
        $transactions = Transaction::with('account')->with('user')->orderByDesc('created_at')->paginate(5);
        $income = Transaction::where('type', 'ingreso')->sum('amount');
        $expences = Transaction::where('type', 'egreso')->sum('amount');
        $balance = $income - $expences;

        return Inertia::render('Transactions/Index', [
            'accounts' => $accounts,
            'transactions' => $transactions,
            'balance' => $balance,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_id' => 'required|numeric',
            'concept' => 'required',
            'type' => 'required',
            'amount' => 'required',
            'taxes' => 'nullable',
            'description' => 'nullable',
        ]);

        $data = $request->all();

        $transaction = new Transaction();
        $transaction->user_id = auth()->user()->id;
        $transaction->account_id = $data['account_id'];
        $transaction->concept = $data['concept'];
        $transaction->type = $data['type'];
        $transaction->amount = $data['amount'];
        $transaction->taxes = $data['taxes'] ?? 0;
        $transaction->description = $data['description'] ?? '';
        $transaction->save();

        return response()->json([ 'message' => 'Registrado correctamente' ]);
    }
}
