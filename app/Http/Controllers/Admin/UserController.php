<?php

namespace Eportal\Http\Controllers\Admin;

use Eportal\Models\User\User;
use Illuminate\Http\Request;
use Eportal\Http\Controllers\Controller;

class UserController extends Controller
{
    public function register(Request $request){
        $type = $request->query('type', User::USER_STUDENT);
        switch($type){
            case User::USER_STUDENT:
                return $this->registerStudent($request);
            case User::USER_TEACHER:
                return $this->registerTeacher($request);
        }
    }

    public function registerStudent(Request $request){
        if($request->isMethod(Request::METHOD_GET)){
            $fields = ['school', 'class', 'department']; //fields to display
            return view('admin.users.register_student', ['type' => User::USER_STUDENT, 'fields' => $fields]);
        }
        dd($request->all());
    }

    public function registerTeacher(Request $request){

    }

    public function registerAdmin(Request $request){
        if($request->isMethod(Request::METHOD_GET)){
            return view('admin.auth.register');
        }
        $this->validate($request, [
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'password' => 'required',
            'gender' => 'required',
            'dob' => 'required|date_format:Y-m-d',
        ]);
    }
}
