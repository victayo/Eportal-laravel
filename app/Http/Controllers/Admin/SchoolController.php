<?php

namespace Eportal\Http\Controllers\Admin;

use Eportal\Models\School;
use Eportal\Repositories\School\SchoolRepositoryInterface;
use Illuminate\Http\Request;
use Eportal\Http\Controllers\Controller;

class SchoolController extends Controller
{
    /**
     * @var SchoolRepositoryInterface
     */
    protected $schoolService;

    /**
     * SchoolController constructor.
     * @param SchoolRepositoryInterface $schoolService
     */
    public function __construct(SchoolRepositoryInterface $schoolService)
    {
        $this->schoolService = $schoolService;
    }

    public function index(){
        $schools = $this->schoolService->getSchools();
        return view('admin.school.index', ['schools' => $schools]);
    }

    public function create(Request $request){
        if($request->isMethod('GET')) {
            return view('admin.school.create');
        }
        //method is post
        $this->validate($request, [
            'name' => 'required|unique:schools,name'
        ]);
        $this->schoolService->create($request->all());
        return redirect()->route('admin.school.index')->with('success', 'School successfully created');
    }

    public function update(Request $request, School $school){
        if($request->isMethod(Request::METHOD_GET)) {
            return view('admin.school.edit', ['school' => $school]);
        }
        $this->schoolService->update($school, $request->all());
        return redirect()->route('admin.school.index')->with('success', 'School successfully updated');
    }

    public function getClasses(Request $request){
        $this->validate($request, [
            'school' => 'required|exists:schools,id'
        ]);
        $school = $this->schoolService->findById($request->query('school'));
        $classes = $this->schoolService->getClasses($school);
        return view('admin.school.classes', ['classes' => $classes]);
    }

    public function addClasses(Request $request){
        $this->validate($request, [
            'school' => 'required|exists:schools,id',
        ]);
        $school = $this->schoolService->findById($request->query('school'));
        if($request->isMethod(Request::METHOD_GET)){
            $classes = $this->schoolService->getUnaddedClasses($school);
            return view('admin.school.add_classes', ['classes' => $classes]);
        }
        $this->validate($request, [
            'classes.id' => 'required|exists:eportal_classes,id'
        ]);
        $classes = $request->input('classes');
        $this->schoolService->addClasses($school, $classes);
        return redirect()->back();
    }

    public function removeClasses(Request $request){

    }
}
