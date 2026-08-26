<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\AdminUsuario;
use App\Services\AdminService;

class Admin extends Controller
{
    public function __construct(private AdminService $adminService) {}

    public function index()
    {
        
    }
}
