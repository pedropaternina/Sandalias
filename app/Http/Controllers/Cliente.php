<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\ClienteService;

class Cliente extends Controller
{
    public function __construct(ClienteService $clienteService) {}

    
}
