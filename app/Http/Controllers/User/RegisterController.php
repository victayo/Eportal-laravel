<?php

namespace Eportal\Http\Controllers\User;

use Eportal\Http\Controllers\Controller;
use Eportal\Repositories\Department\DepartmentRepositoryInterface;
use Eportal\Repositories\EportalClass\ClassRepositoryInterface;
use Eportal\Repositories\School\SchoolRepositoryInterface;
use Eportal\Repositories\Session\SessionRepositoryInterface;
use Eportal\Repositories\Subject\SubjectRepositoryInterface;
use Eportal\Repositories\Term\TermRepositoryInterface;
use Eportal\Repositories\User\UserServiceInterface;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    protected $userService;

    /**
     * @var SessionRepositoryInterface
     */
    protected $sessionService;

    /**
     * @var TermRepositoryInterface
     */
    protected $termService;

    /**
     * @var SchoolRepositoryInterface
     */
    protected $schoolService;

    /**
     * @var ClassRepositoryInterface
     */
    protected $classService;

    /**
     * @var DepartmentRepositoryInterface
     */
    protected $departmentService;

    /**
     * @var SubjectRepositoryInterface
     */
    protected $subjectService;

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
            'dob' => 'required|date_format:Y-m-d',
            'session' => 'required|exists:sessions,id',
            'term' => 'required|exists:terms,id',
            'school' => 'required|exists:schools,id',
            'class' => 'required|exists:eportal_classes,id',
            'department' => 'nullable|exists:departments,id',
            'subject' => 'nullable|exists:subjects,id'
        ]);
        $dept = $request->input('department');
        $subj = $request->input('subject');
        $attr = ['first_name', 'middle_name', 'last_name', 'username', 'gender', 'password'];

        $session = $this->getSessionService()->findById($request->input('session'));
        $term = $this->getTermService()->findById($request->input('term'));
        $school = $this->getSchoolService()->findById($request->input('school'));
        $class = $this->getClassService()->findById($request->input('class'));
        $department = !$dept ? null : $this->getDepartmentService()->findById($request->input('department'));
        $subject = !$subj ? null : $this->getSubjectService()->findById($request->input('subject'));

        $userAttr = $request->only($attr);
        $userAttr['password'] = bcrypt($userAttr['password']);
        $userAttr['gender'] = 1;
        $user = $this->userService->registerStudent($userAttr, $session, $term, $school, $class, $department, $subject);
        if($user){
            return response()->json(['success' => true, 'user' => $user]);
        }
        return response()->json(['success' => false]);
    }

    /**
     * @return SessionRepositoryInterface
     */
    public function getSessionService()
    {
        if (!$this->sessionService) {
            $this->sessionService = app(SessionRepositoryInterface::class);
        }
        return $this->sessionService;
    }

    /**
     * @param SessionRepositoryInterface $sessionService
     * @return RegisterController
     */
    public function setSessionService(SessionRepositoryInterface $sessionService)
    {
        $this->sessionService = $sessionService;
        return $this;
    }

    /**
     * @return TermRepositoryInterface
     */
    public function getTermService(){
        if(!$this->termService){
            $this->termService = app(TermRepositoryInterface::class);
        }
        return $this->termService;
    }

    /**
     * @param TermRepositoryInterface $termService
     * @return RegisterController
     */
    public function setTermService(TermRepositoryInterface $termService)
    {
        $this->termService = $termService;
        return $this;
    }


    /**
     * @return SchoolRepositoryInterface
     */
    public function getSchoolService()
    {
        if (!$this->schoolService) {
            $this->schoolService = app(SchoolRepositoryInterface::class);
        }
        return $this->schoolService;
    }

    /**
     * @param SchoolRepositoryInterface $schoolService
     * @return RegisterController
     */
    public function setSchoolService(SchoolRepositoryInterface $schoolService)
    {
        $this->schoolService = $schoolService;
        return $this;
    }

    /**
     * @return ClassRepositoryInterface
     */
    public function getClassService()
    {
        if (!$this->classService) {
            $this->classService = app(ClassRepositoryInterface::class);
        }
        return $this->classService;
    }

    /**
     * @param ClassRepositoryInterface $classService
     * @return RegisterController
     */
    public function setClassService(ClassRepositoryInterface $classService)
    {
        $this->classService = $classService;
        return $this;
    }

    /**
     * @return DepartmentRepositoryInterface
     */
    public function getDepartmentService()
    {
        if (!$this->departmentService) {
            $this->departmentService = app(DepartmentRepositoryInterface::class);
        }
        return $this->departmentService;
    }

    /**
     * @param DepartmentRepositoryInterface $departmentService
     * @return RegisterController
     */
    public function setDepartmentService(DepartmentRepositoryInterface $departmentService)
    {
        $this->departmentService = $departmentService;
        return $this;
    }

    /**
     * @return SubjectRepositoryInterface
     */
    public function getSubjectService()
    {
        if (!$this->subjectService) {
            $this->subjectService = app(SubjectRepositoryInterface::class);
        }
        return $this->subjectService;
    }

    /**
     * @param SubjectRepositoryInterface $subjectService
     * @return RegisterController
     */
    public function setSubjectService(SubjectRepositoryInterface $subjectService)
    {
        $this->subjectService = $subjectService;
        return $this;
    }
}
