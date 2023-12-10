<?php

namespace Modules\User\Src\HTTP\Controllers;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        return view('user::lists');
    }

    public function detail($id)
    {
        return view('user::detail', compact('id'));
    }
}
// Test