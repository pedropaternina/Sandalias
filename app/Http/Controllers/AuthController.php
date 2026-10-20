<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}


    public function showRegistro()
    {
        if (Auth::guard('cliente')->check()) {
            return redirect()->route('home');
        }

        return Inertia::render('Auth/RegistroShow');
    }

    public function showLogin()
    {
        return Inertia::render('Auth/LoginShow');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $cliente = $this->authService->autenticar($request->validated());

        Auth::guard('cliente')->login($cliente);

        return redirect()
        ->route('home')

        ->with('mensaje', "Usuario logueado con exito");
    }

    public function registro(RegisterRequest $request): RedirectResponse
    {
        $cliente = $this->authService->registrar($request->validated());

        Auth::guard('cliente')->login($cliente);

        return redirect()
        ->route('home')
        ->with('mensaje', 'Usuario registrado con exito');
    }

   public function logout(Request $request): RedirectResponse
    {
        Auth::guard('cliente')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
