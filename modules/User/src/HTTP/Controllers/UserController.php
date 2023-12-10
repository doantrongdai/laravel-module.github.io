<?php

namespace Modules\User\Src\HTTP\Controllers;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        return view('User::lists');
    }

    public function detail($id)
    {
        return view('User::detail', compact('id'));
    }
}
// Test