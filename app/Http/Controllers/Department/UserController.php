<?php

namespace Eportal\Http\Controllers\Department;

use Eportal\Repositories\Department\DepartmentRepositoryInterface;
use Eportal\Repositories\EportalClass\ClassRepositoryInterface;
use Eportal\Repositories\School\SchoolRepositoryInterface;
use Eportal\Repositories\Session\SessionRepositoryInterface;
use Eportal\Repositories\Term\TermRepositoryInterface;
use Eportal\Repositories\User\UserServiceInterface;
use Illuminate\Http\Request;
use Eportal\Http\Controllers\Controller;

class UserController extends Controller
{

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

    public function __construct(DepartmentRepositoryInterface $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function getUsers(Request $request)
    {
        $this->validate($request, [
            'school' => 'required|exists:schools,id',
            'class' => 'required|exists:eportal_classes,id',
            'department' => 'required|exists:departments,id',
            'session' => 'required|exists:sessions,id',
            'term' => 'required|exists:terms,id'
        ]);
        $school = $this->getSchoolService()->findById($request->query('school'));
        $class = $this->getClassService()->findById($request->query('class'));
        $department = $this->departmentService->findById($request->query('department'));
        $session = $this->getSessionService()->findById($request->query('session'));
        $term = $this->getTermService()->findById($request->query('term'));
        $users = $this->departmentService->getUsers($school, $class, $department, $session, $term);
        return response()->json(['success' => true, 'users' => $users]);
    }

    public function addUsers(Request $request)
    {
        $this->validate($request, [
            'school' => 'required|exists:schools,id',
            'class' => 'required|exists:eportal_classes,id',
            'department' => 'required|exists:departments,id',
            'session' => 'required|exists:sessions,id',
            'term' => 'required|exists:terms,id',
            'users.*' => 'required|exists:users,id'
        ]);
        $school = $this->getSchoolService()->findById($request->input('school'));
        $class = $this->getClassService()->findById($request->input('class'));
        $department = $this->departmentService->findById($request->input('department'));
        $session = $this->getSessionService()->findById($request->input('session'));
        $term = $this->getTermService()->findById($request->input('term'));
        $users = $request->input('users');
        $userService = $this->getUserService();
        $added = 0;
        foreach ($users as $user) {
            $user = $userService->findById($user);
            $success = $this->departmentService->addUser($user, $school, $class, $department, $session, $term);
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
            'session' => 'required|exists:sessions,id',
            'term' => 'required|exists:terms,id',
            'users.*' => 'required|exists:users,id'
        ]);
        $school = $this->schoolService->findById($request->input('school'));
        $class = $this->getClassService()->findById($request->input('class'));
        $department = $this->departmentService->findById($request->input('department'));
        $session = $this->getSessionService()->findById($request->input('session'));
        $term = $this->getTermService()->findById($request->input('term'));
        $users = $request->input('users');
        $userService = $this->getUserService();
        $removed = 0;
        foreach ($users as $user) {
            $user = $userService->findById($user);
            $success = $this->departmentService->removeUser($user, $school, $class, $department, $session, $term);
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

    public function getUserService()
    {
        if (!$this->userService) {
            $this->userService = app(UserServiceInterface::class);
        }
        return $this->userService;
    }
}
