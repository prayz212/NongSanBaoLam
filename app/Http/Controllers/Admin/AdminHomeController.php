<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AdminHomeController extends Controller
{
    public function index() {
        dd(Auth::guard('admin'));
    }
}
