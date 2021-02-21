<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AccountsController extends Controller
{
    public function render()
    {
        return Inertia::render('Accounts/Index');
    }
}
