<?php

namespace Eportal\Http\Controllers\User;

use Eportal\Repositories\Department\DepartmentRepository;
use Eportal\Repositories\EportalClass\ClassRepository;
use Eportal\Repositories\School\SchoolRepository;
use Eportal\Repositories\Session\SessionRepository;
use Eportal\Repositories\Subject\SubjectRepository;
use Eportal\Repositories\Term\TermRepository;
use Eportal\Repositories\User\UserServiceInterface;
use Illuminate\Http\Request;
use Eportal\Http\Controllers\Controller;

class RegisterController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function studentRegister(Request $request){
        $this->validate($request, [
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'password' => 'required',
            'gender' => 'required',
            'session' => 'required|exists:sessions,id',
            'term' => 'required|exists:terms,id',
            'school' => 'required|exists:schools,id',
            'class' => 'required|exists:eportal_classes,id',
            'department' => 'nullable|exists:departments,id',
            'subject' => 'required|exists:subjects,id'
        ]);
        $attr = ['first_name', 'middle_name', 'last_name', 'username', 'gender', 'password'];
        $session = (app(SessionRepository::class))->findById($request->input('session'));
        $term = (app(TermRepository::class))->findById($request->input('term'));
        $school = (app(SchoolRepository::class))->findById($request->input('school'));
        $class = (app(ClassRepository::class))->findById($request->input('class'));
        $department = (app(DepartmentRepository::class))->findById($request->input('department'));
        $subject = (app(SubjectRepository::class))->findById($request->input('subject'));
        $userAttr = $request->only($attr);
        $user = $this->userService->registerStudent($userAttr, $session, $term, $school, $class, $department, $subject);
        dd($user);
    }
}
