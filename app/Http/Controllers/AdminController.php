<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    
    public function __construct()
{
    
    $this->middleware(['role:superadmin']);
}

public function index(Request $request)
{
    return 'this is from the admin controller';
}

}
