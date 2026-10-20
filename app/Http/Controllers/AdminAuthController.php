<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return Inertia::render('Admin/Login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credenciales = $request->validate([
            'correo' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::guard('admin')->attempt($credenciales)) {
            return back()->withErrors(['correo' => 'Credenciales incorrectas.']);
        }

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
