<?php

namespace App\Services;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
class AuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    public function registrar(array $datos): Cliente
    {

        return Cliente::create( [
            'nombres' => $datos['nombres'],
            'apellidos' => $datos['apellidos'],
            'correo' => $datos['correo'],
            'telefono' => $datos['telefono'],
            'password' => Hash::make($datos['password']),
            'email_verificado' => false,
        ]);
    }

    public function autenticar(array $datos): Cliente
    {
        $cliente = Cliente::where('correo', $datos['correo'])->first();


        if(!$cliente || !Hash::check($datos['password'], $cliente['password'])){
            throw ValidationException::withMessages([
                'correo' => 'Las credenciales son invalidas',
            ]);
        }

        return $cliente;
    }
}
