<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionsController extends Controller
{
    public function render()
    {
        $accounts = Account::all();
        $transactions = Transaction::with('account')->orderByDesc('created_at')->get();

        return Inertia::render('Transactions/Index', [
            'accounts' => $accounts,
            'transactions' => $transactions,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_id' => 'required|numeric',
            'concept' => 'required',
            'type' => 'required',
            'amount' => 'required',
            'has_taxes' => 'nullable',
            'description' => 'nullable',
        ]);

        $data = $request->all();

        $transaction = new Transaction();
        $transaction->user_id = auth()->user()->id;
        $transaction->account_id = $data['account_id'];
        $transaction->concept = $data['concept'];
        $transaction->type = $data['type'];
        $transaction->amount = $data['amount'];
        $transaction->taxes = $data['has_taxes'] ?? 0;
        $transaction->description = $data['description'] ?? '';
        $transaction->save();

        return response()->json([ 'message' => 'Registrado correctamente' ]);
    }
}
