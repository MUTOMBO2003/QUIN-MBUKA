<?php

namespace App\Http\Controllers\Secretaire;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SecretaireDashboardController extends Controller
{
    public function index()
    {
        $secretaire = Auth::user();
        return view('secretaire.dashboard', compact('secretaire'));
    }
}
