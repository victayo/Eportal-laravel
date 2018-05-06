<?php

namespace Eportal\Http\Controllers\Subject;

use Eportal\Repositories\Department\DepartmentRepositoryInterface;
use Eportal\Repositories\EportalClass\ClassRepositoryInterface;
use Eportal\Repositories\School\SchoolRepositoryInterface;
use Eportal\Repositories\Session\SessionRepositoryInterface;
use Eportal\Repositories\Subject\SubjectRepositoryInterface;
use Eportal\Repositories\Term\TermRepositoryInterface;
use Eportal\Repositories\User\UserServiceInterface;
use Illuminate\Http\Request;
use Eportal\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * @var SubjectRepositoryInterface
     */
    protected $subjectService;

    /**
     * @var DepartmentRepositoryInterface
     */
    protected $departmentService;

    /**
     * @var ClassRepositoryInterface
     */
    protected $classService;

    /**
     *
     * @var SchoolRepositoryInterface
     */
    protected $schoolService;

    /**
     * @var SessionRepositoryInterface
     */
    protected $sessionService;

    /**
     * @var TermRepositoryInterface
     */
    protected $termService;

    /**
     * @var UserServiceInterface
     */
    protected $userService;

    public function __construct(SubjectRepositoryInterface $subjectService)
    {
        $this->subjectService = $subjectService;
    }

    public function getUsers(Request $request)
    {
        $this->validate($request, [
            'school' => 'required|exists:schools,id',
            'class' => 'required|exists:eportal_classes,id',
            'department' => 'required|exists:departments,id',
            'subject' => 'required|exists:subjects,id',
            'session' => 'required|exists:sessions,id',
            'term' => 'required|exists:terms,id'
        ]);
        $school = $this->getSchoolService()->findById($request->query('school'));
        $class = $this->getClassService()->findById($request->query('class'));
        $department = $this->getDepartmentService()->findById($request->query('department'));
        $subject = $this->subjectService->findById($request->query('subject'));
        $session = $this->getSessionService()->findById($request->query('session'));
        $term = $this->getTermService()->findById($request->query('term'));
        $users = $this->subjecttService->getUsers($school, $class, $department, $subject, $session, $term);
        return response()->json(['success' => true, 'users' => $users]);
    }

    public function addUsers(Request $request)
    {
        $this->validate($request, [
            'school' => 'required|exists:schools,id',
            'class' => 'required|exists:eportal_classes,id',
            'department' => 'required|exists:departments,id',
            'subject' => 'required|exists:subjects,id',
            'session' => 'required|exists:sessions,id',
            'term' => 'required|exists:terms,id',
            'users.*' => 'required|exists:users,id'
        ]);
        $school = $this->getSchoolService()->findById($request->input('school'));
        $class = $this->getClassService()->findById($request->input('class'));
        $department = $this->getDepartmentService()->findById($request->input('department'));
        $subject = $this->subjectService->findById($request->input('subject'));
        $session = $this->getSessionService()->findById($request->input('session'));
        $term = $this->getTermService()->findById($request->input('term'));
        $users = $request->input('users');
        $userService = $this->getUserService();
        $added = 0;
        foreach ($users as $user) {
            $user = $userService->findById($user);
            $success = $this->subjecttService->addUser($user, $school, $class, $department, $subject, $session, $term);
            !$success ?: $added++;
        }
        return response()->json(['success' => true, 'added' => $added]);
    }

    public function removeUsers(Request $request)
    {
        $this->validate($request, [
            'school' => 'required|exists:schools,id',
            'class' => 'required|exists:eportal_classes,id',
            'department' => 'required|exists:departments,id',
            'subject' => 'required|exists:subjects,id',
            'session' => 'required|exists:sessions,id',
            'term' => 'required|exists:terms,id',
            'users.*' => 'required|exists:users,id'
        ]);
        $school = $this->schoolService->findById($request->input('school'));
        $class = $this->getClassService()->findById($request->input('class'));
        $department = $this->getDepartmentService()->findById($request->input('department'));
        $subject = $this->subjectService->findById($request->input('subject'));
        $session = $this->getSessionService()->findById($request->input('session'));
        $term = $this->getTermService()->findById($request->input('term'));
        $users = $request->input('users');
        $userService = $this->getUserService();
        $removed = 0;
        foreach ($users as $user) {
            $user = $userService->findById($user);
            $success = $this->subjecttService->removeUser($user, $school, $class, $department, $subject, $session, $term);
            !$success ?: $removed++;
        }
        return response()->json(['success' => true, 'added' => $removed]);
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
     * @return ClassRepositoryInterface
     */
    public function getClassService()
    {
        if (!$this->classService) {
            $this->classService = app(ClassRepositoryInterface::class);
        }
        return $this->classService;
    }

    public function getDepartmentService(){
        if(!$this->departmentService){
            $this->departmentService = app(DepartmentRepositoryInterface::class);
        }
        return $this->departmentService;
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
     * @return TermRepositoryInterface
     */
    public function getTermService()
    {
        if (!$this->termService) {
            $this->termService = app(TermRepositoryInterface::class);
        }
        return $this->termService;
    }

    /**
     * @return UserServiceInterface
     */
    public function getUserService()
    {
        if (!$this->userService) {
            $this->userService = app(UserServiceInterface::class);
        }
        return $this->userService;
    }
}
