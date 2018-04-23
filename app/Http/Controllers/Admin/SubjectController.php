<?php

namespace Eportal\Http\Controllers\Admin;

use Eportal\Http\Controllers\Controller;
use Eportal\Models\Subject;
use Eportal\Repositories\Subject\SubjectRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubjectController extends Controller
{
    /**
     * @var SubjectRepositoryInterface
     */
    protected $subjectService;

    /**
     * SubjectController constructor.
     * @param SubjectRepositoryInterface $subjectService
     */
    public function __construct(SubjectRepositoryInterface $subjectService)
    {
        $this->subjectService = $subjectService;
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = $this->subjectService->getSubjects();
        return view('admin.subject.index', ['subjects' => $subjects]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $this->validate($request, [
                'name' => 'required|unique:subjects,id'
            ]);
            $this->subjectService->create($request->all());
            return redirect()->route('admin.subject.index');
        }
        return view('admin.subject.create');
    }

    /**
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     *
     * @param  Request $request
     * @param Subject $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $this->validate($request, [
                'name' => 'required|unique:subjects,name'
            ]);
            $this->subjectService->update($subject, $request->all());
            return redirect()->route('admin.subject.index');
        }
        return view('admin.subject.edit', ['subject' => $subject]);
    }

    /**
     *
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request)
    {
        $this->validate($request, [
            'subject' => 'required|exists:subjects,id'
        ]);
        $subject = $this->subjectService->findById($request->input('subject'));
        $success = $this->subjectService->delete($subject);
        if($request->wantsJson()){
            return response()->json(['success' => $success, 'redirect' => route('admin.subject.index')]);
        }
        return redirect()->route('admin.subject.index');
    }
}
