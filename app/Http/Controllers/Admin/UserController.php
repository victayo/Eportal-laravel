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
            return view('admin.users.register_student', ['type' => User::USER_STUDENT]);
        }
        dd($request->all());
    }

    public function registerTeacher(Request $request){

    }
}
