<?php

namespace Eportal\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Eportal\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index(){
        return view('admin.admin');
    }
}
