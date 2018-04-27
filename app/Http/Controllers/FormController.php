<?php

namespace Eportal\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index(){
        return view('admin.partials.property_form');
    }
}
