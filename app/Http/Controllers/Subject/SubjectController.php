<?php

namespace Eportal\Http\Controllers\Subject;

use Eportal\Models\Subject;
use Eportal\Repositories\Subject\SubjectRepository;
use Illuminate\Http\Request;
use Eportal\Http\Controllers\Controller;

class SubjectController extends Controller
{

    /**
     * @var SubjectRepository
     */
    protected $subjectRepo;

    public function __construct(SubjectRepository $subjectRepository)
    {
        $this->subjectRepo = $subjectRepository;
    }

    public function index(){
        $subjects = $this->subjectRepo->getSubjects();
        return response()->json(['success' => true, 'subjects' => $subjects]);
    }

    public function show(Subject $subject){
        return response()->json(['success' => true, 'subject' => $subject]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:subjects,name',
        ]);
        $subject = $this->subjectRepo->create($request->all());
        return response()->json(['success' => true, 'subject' => $subject]);
    }

    public function update(Request $request, Subject $subject){
        $name = $request->input('name', '');
        if (strcasecmp($name, $subject->getName()) == 0) {
            //nothing to update
            return response()->json(['success' => true, 'subject' => $subject]);
        }
        $this->validate($request, [
            'name' => 'required|string|unique:subjects,name'
        ]);
        $success = $this->subjectRepo->update($subject, $request->all());
        return response()->json(['success' => $success, 'subject' => $subject]);
    }

    public function delete(Subject $subject){
        $success = $this->subjectRepo->delete($subject);
        return response()->json(['success' => $success]);
    }
}
