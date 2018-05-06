<?php

namespace Eportal\Http\Controllers\Session;

use Eportal\Repositories\Session\SessionRepositoryInterface;
use Eportal\Repositories\Term\TermRepositoryInterface;
use Eportal\Repositories\User\UserServiceInterface;
use Illuminate\Http\Request;
use Eportal\Http\Controllers\Controller;

class UserController extends Controller
{
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

    public function __construct(SessionRepositoryInterface $sessionService)
    {
        $this->sessionService = $sessionService;
    }

    public function getUsers(Request $request)
    {
        $this->validate($request, [
            'session' => 'required|exists:sessions,id',
            'term' => 'required|exists:terms,id'
        ]);
        $session = $this->sessionService->findById($request->query('session'));
        $term = $this->getTermService()->findById($request->query('term'));
        $users = $this->sessionService->getUsers($session, $term);
        return response()->json(['success' => true, 'users' => $users]);
    }

    public function addUsers(Request $request)
    {
        $this->validate($request, [
            'session' => 'required|exists:sessions,id',
            'term' => 'required|exists:terms,id',
            'users.*' => 'required|exists:users,id'
        ]);
        $session = $this->sessionService->findById($request->input('session'));
        $term = $this->getTermService()->findById($request->input('term'));
        $users = $request->input('users');
        $userService = $this->getUserService();
        $added = 0;
        foreach ($users as $user) {
            $user = $userService->findById($user);
            $success = $this->sessionService->addUser($user, $session, $term);
            !$success ?: $added++;
        }
        return response()->json(['success' => true, 'added' => $added]);
    }

    public function removeUsers(Request $request)
    {
        $this->validate($request, [
            'session' => 'required|exists:sessions,id',
            'term' => 'required|exists:terms,id',
            'users.*' => 'required|exists:users,id'
        ]);
        $session = $this->sessionService->findById($request->input('session'));
        $term = $this->getTermService()->findById($request->input('term'));
        $users = $request->input('users');
        $userService = $this->getUserService();
        $removed = 0;
        foreach ($users as $user) {
            $user = $userService->findById($user);
            $success = $this->sessionService->removeUser($user, $session, $term);
            !$success ?: $removed++;
        }
        return response()->json(['success' => true, 'added' => $removed]);
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
