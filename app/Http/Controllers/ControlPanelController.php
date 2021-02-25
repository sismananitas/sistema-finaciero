<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ControlPanelController extends Controller
{
    public function render()
    {
        return Inertia::render('ControlPanel/Index');
    }
}
