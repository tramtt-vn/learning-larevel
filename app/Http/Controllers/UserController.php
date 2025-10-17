<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     echo 'aaaaad'; die();
    // }
    public function index()
    {
        // Lấy toàn bộ user
        $users = User::orderBy('created_at', 'desc')->get();

        // Truyền sang view
        return view('users.index', compact('users'));
    }
}
