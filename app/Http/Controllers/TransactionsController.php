<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionsController extends Controller
{
    public function render()
    {
        return Inertia::render('Transactions/Index');
    }
}
