<?php

namespace Eportal\Http\Controllers\EportalClass;

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

    public function __construct(ClassRepositoryInterface $classService)
    {
        $this->classService = $classService;
    }

    public function getUsers(Request $request)
    {
        $this->validate($request, [
            'school' => 'required|exists:schools,id',
            'class' => 'required|exists:eportal_classes, id',
            'session' => 'required|exists:sessions,id',
            'term' => 'required|exists:terms,id'
        ]);
        $school = $this->getSchoolService()->findById($request->query('school'));
        $class = $this->classService->findById($request->query('class'));
        $session = $this->getSessionService()->findById($request->query('session'));
        $term = $this->getTermService()->findById($request->query('term'));
        $users = $this->classService->getUsers($school, $class, $session, $term);
        return response()->json(['success' => true, 'users' => $users]);
    }

    public function addUsers(Request $request)
    {
        $this->validate($request, [
            'school' => 'required|exists:schools,id',
            'class' => 'required|exists:eportal_classes, id',
            'session' => 'required|exists:sessions,id',
            'term' => 'required|exists:terms,id',
            'users.*' => 'required|exists:users,id'
        ]);
        $school = $this->getSchoolService()->findById($request->input('school'));
        $class = $this->classService->findById($request->input('class'));
        $session = $this->getSessionService()->findById($request->input('session'));
        $term = $this->getTermService()->findById($request->input('term'));
        $users = $request->input('users');
        $userService = $this->getUserService();
        $added = 0;
        foreach ($users as $user) {
            $user = $userService->findById($user);
            $success = $this->classService->addUser($user, $school, $class, $session, $term);
            !$success ?: $added++;
        }
        return response()->json(['success' => true, 'added' => $added]);
    }

    public function removeUsers(Request $request)
    {
        $this->validate($request, [
            'school' => 'required|exists:schools,id',
            'class' => 'required|exists:eportal_classes, id',
            'session' => 'required|exists:sessions,id',
            'term' => 'required|exists:terms,id',
            'users.*' => 'required|exists:users,id'
        ]);
        $school = $this->schoolService->findById($request->input('school'));
        $class = $this->classService->findById($request->input('class'));
        $session = $this->getSessionService()->findById($request->input('session'));
        $term = $this->getTermService()->findById($request->input('term'));
        $users = $request->input('users');
        $userService = $this->getUserService();
        $removed = 0;
        foreach ($users as $user) {
            $user = $userService->findById($user);
            $success = $this->classService->removeUser($user, $school, $class, $session, $term);
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
