<?php

namespace Eportal\Http\Controllers\Admin;

use Eportal\Repositories\Session\SessionRepositoryInterface;
use Illuminate\Http\Request;
use Eportal\Http\Controllers\Controller;

class SessionController extends Controller
{
    /**
     * @var SessionRepositoryInterface
     */
    protected $sessionService;

    /**
     * SessionController constructor.
     * @param SessionRepositoryInterface $sessionService
     */
    public function __construct(SessionRepositoryInterface $sessionService)
    {
        $this->sessionService = $sessionService;
    }
    
    public function index(){
        $sessions = $this->sessionService->getSessions();
        return view('admin.session.index', ['sessions' => $sessions]);
    }

    public function create(Request $request){
        if($request->isMethod('GET')) {
            return view('admin.session.create');
        }
        //method is post
        $this->validate($request, [
            'name' => 'required|unique:sessions,name'
        ]);
        $this->sessionService->create($request->all());
        return redirect()->route('admin.session.index')->with('success', 'Session successfully created');
    }

    public function update(Request $request, Session $session){
        if($request->isMethod(Request::METHOD_GET)) {
            return view('admin.session.edit', ['session' => $session]);
        }
        $this->sessionService->update($session, $request->all());
        return redirect()->route('admin.session.index')->with('success', 'Session successfully updated');
    }

    public function delete(Request $request){
        $this->validate($request, [
            'session' => 'required|exists:sessions,id',
        ]);
        $session = $this->sessionService->findById($request->input('session'));
        $success = $this->sessionService->delete($session);
        if($request->wantsJson()){
            return response()->json([
                'success' => $success,
                'redirect' => route('admin.session.index')
            ]);
        }
        return redirect()->route('admin.session.index');
    }

    public function getTerms(Request $request){
        $this->validate($request, [
            'session' => 'required|exists:sessions,id'
        ]);
        $session = $this->sessionService->findById($request->query('session'));
        $terms = $this->sessionService->getTerms($session);
        return view('admin.session.terms', ['terms' => $terms, 'session' => $session]);
    }

    public function addTerms(Request $request){
        $this->validate($request, [
            'session' => 'required|exists:sessions,id',
        ]);
        $session = $this->sessionService->findById($request->query('session'));
        if($request->isMethod(Request::METHOD_GET)){
            $terms = $this->sessionService->getUnaddedTerms($session);
            return view('admin.session.add_terms', ['terms' => $terms, 'session' => $session]);
        }
        $this->validate($request, [
            'terms.*' => 'required|exists:terms,id'
        ]);
        $terms = $request->input('terms');
        $this->sessionService->addTerms($session, $terms);
        return redirect()->route('admin.session.terms', ['session' => $session->getId()]);
    }

    public function removeTerms(Request $request){
        $this->validate($request, [
            'session' => 'required|exists:sessions,id',
            'terms.*' => 'required|exists:terms,id'
        ]);
        $session = $this->sessionService->findById($request->input('session'));
        $terms = $request->input('terms');
        $this->sessionService->removeTerms($session, $terms);
        if($request->wantsJson()){
            return response()->json([
                'success'=>true,
                'redirect' => route('admin.session.terms', ['session' => $session->getId()])
            ]);
        }
        return redirect()->route('admin.session.terms', ['session' => $session->getId()]);
    }
}
