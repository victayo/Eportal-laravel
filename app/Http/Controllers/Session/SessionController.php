<?php

namespace Eportal\Http\Controllers\Session;

use Eportal\Http\Controllers\Controller;
use Eportal\Models\Session;
use Eportal\Repositories\Session\SessionRepository;
use Eportal\Repositories\Term\TermRepository;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    /**
     * @var SessionRepository
     */
    protected $sessionRepo;

    /**
     * @var TermRepository
     */
    protected $termService;

    public function __construct(SessionRepository $sessionRepository)
    {
        $this->sessionRepo = $sessionRepository;
    }

    public function index(){
        $sessions = $this->sessionRepo->getSessions();
        return response()->json(['success' => true, 'sessions' => $sessions]);
    }

    public function show(Session $session){
        return response()->json(['session' => $session]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|string|min:2|max:50|unique:sessions,name'
        ]);
        $session = $this->sessionRepo->create($request->all());
        return response()->json(['success' => true, 'session' => $session]);
    }

    public function update(Request $request, Session $session){
        //validate $request
        $success = $this->sessionRepo->update($session, $request->all());
        return response()->json(['success' => $success]);
    }

    public function delete(Session $session){
        $success = $this->sessionRepo->delete($session);
        return response()->json(['success' => $success]);
    }

    public function getTerms(Request $request){
        $this->validate($request, [
            'session' => 'required|exists:sessions,id'
        ]);
        $session = $this->sessionRepo->findById($request->query('session'));
        $terms = $this->sessionRepo->getTerms($session);
        return response()->json(['success' => true,'terms' => $terms]);
    }

    public function addTerm(Request $request){
        $this->validate($request, [
            'session' => 'required|exists:sessions,id',
            'terms.*' => 'required|exists:terms,id'
        ]);
        $session = $this->sessionRepo->findById($request->input('session'));
        $terms = $request->input('terms');
        $added = $this->sessionRepo->addTerms($session, $terms);
        return response()->json(['success' => true, 'added' => $added]);
    }

    public function removeTerm(Request $request){
        $this->validate($request, [
            'session' => 'required|exists:sessions,id',
            'terms.*' => 'required|exists:terms,id'
        ]);
        $session = $this->sessionRepo->findById($request->input('session'));
        $terms = $request->input('terms');
        $removed = $this->sessionRepo->removeTerms($session, $terms);
        return response()->json(['success' => true, 'removed' => $removed]);
    }

    public function getUsers(Request $request){
        $this->validate($request, [
            'session' => 'required|exists:sessions,id',
            'term' => 'required|exists:terms,id'
        ]);
        $session = $this->sessionRepo->findById($request->query('session'));
        $term = $this->getTermService()->findById($request->query('term'));
        $users = $this->sessionRepo->getUsers($session, $term);
        return response()->json(['success' => false, 'users' => $users]);
    }

    public function removeUsers(Request $request){
        $this->validate($request, [
            'session' => 'required|exists:sessions,id',
            'term' => 'required|exists:terms,id',
            'users.*' => 'required|exists:users,id'
        ]);
    }

    public function addUsers(Request $request){
        $this->validate($request, [
            'session' => 'required|exists:sessions,id',
            'term' => 'required|exists:terms,id',
            'users.*' => 'required|exists:users,id'
        ]);
        $session = $this->sessionRepo->findById($request->input('session'));
        $term = $this->getTermService()->findById($request->input('term'));
        $users = $request->input('users');
        $added = $this->sessionRepo->addUsers($users, $session, $term);
        return response()->json(['success' => true, 'added' => $added]);
    }

    public function getTermService(){
        if(!$this->termService){
            $this->termService = app()->make(TermRepository::class);
        }
        return $this->termService;
    }
}
