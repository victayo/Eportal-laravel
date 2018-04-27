<?php

namespace Eportal\Http\Controllers\School;

use Eportal\Http\Controllers\Controller;
use Eportal\Models\School;
use Eportal\Repositories\EportalClass\ClassRepository;
use Eportal\Repositories\School\SchoolRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SchoolController extends Controller
{
    /**
     *
     * @var SchoolRepositoryInterface
     */
    protected $schoolRepo;
    
    /**
     *
     * @var ClassRepository
     */
    protected $classRepo;
    
    public function __construct(SchoolRepositoryInterface $schoolRepo) {
        $this->schoolRepo = $schoolRepo;
    }
    
    public function index(){
        $schools = $this->schoolRepo->getSchools();
        return response()->json(['success' => true, 'schools' => $schools]);
    }
    
    public function show(School $school){
        return response()->json(['success' => true, 'school' => $school]);
    }
    
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|string|min:2|max:50|unique:schools,name'
        ]);
        $school = $this->schoolRepo->create($request->all());
        return response()->json(['success' => true, 'school' => $school]);
    }
    
    public function update(Request $request, School $school){
        //validate $request
        $success = $this->schoolRepo->update($school, $request->all());
        return response()->json(['success' => $success]);
    }
    
    public function delete(School $school){
        $success = $this->schoolRepo->delete($school);
        return response()->json(['success' => $success], 204);
    }
    
    public function getClasses(Request $request){
        $this->validate($request, [
            'school' => 'required|exists:schools,id'
        ]);
        $school = $this->schoolRepo->findById($request->query('school'));
        $classes = $this->schoolRepo->getClasses($school);
        return response()->json(['success' => true, 'classes' => $classes]);
    }

    public function getUnaddedClasses(School $school){
        $classes = $this->schoolRepo->getUnaddedClasses($school);
        return response()->json(['success' => true, 'classes' => $classes]);
    }
    
    public function addClass(Request $request){
        $this->validate($request, [
            'school' => 'required|exists:schools,id',
            'classes.*' => 'required|exists:eportal_classes,id'
        ]);
        $school = $this->schoolRepo->findById($request->input('school'));
        $classes = $request->input('classes');
        $added = $this->schoolRepo->addClasses($school, $classes);
        return response()->json(['success' => true, 'added' => $added]);
    }
    
    public function removeClass(Request $request){
        $this->validate($request, [
            'school' => 'required|exists:schools,id',
            'classes.*' => 'required|exists:eportal_classes,id'
        ]);
        $school = $this->schoolRepo->findById($request->input('school'));
        $classes = $request->input('classes');
        $removed = $this->schoolRepo->removeClasses($school, $classes);
        return response()->json(['success' => true, 'removed' => $removed]);
    }
}
