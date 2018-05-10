<?php

namespace Eportal\Http\Controllers\Admin;

use Eportal\Models\EportalClass;
use Eportal\Repositories\EportalClass\ClassRepositoryInterface;
use Eportal\Repositories\School\SchoolRepositoryInterface;
use Illuminate\Http\Request;
use Eportal\Http\Controllers\Controller;

class ClassController extends Controller
{
    /**
     * @var ClassRepositoryInterface
     */
    protected $classService;

    /**
     * @var SchoolRepositoryInterface
     */
    protected $schoolService;

    protected $property = 'class';

    /**
     * ClassController constructor.
     * @param ClassRepositoryInterface $classService
     */
    public function __construct(ClassRepositoryInterface $classService)
    {
        $this->classService = $classService;
    }

    public function index(){
        $classes = $this->classService->getClasses();
        return view('admin.index', [
            'properties' => $classes,
            'property_name' => $this->property,
            'create_new_link' => route('admin.class.create'),
            'edit_link' => route('admin.class.edit', ['class' => '?']),
            'delete_link' => route('admin.class.delete')
        ]);
    }

    public function store(Request $request){
        if($request->isMethod(Request::METHOD_POST)){
            $this->validate($request, [
                'name' => 'required|unique:eportal_classes,name'
            ]);
            $this->classService->create($request->all());
            return redirect()->route('admin.class.index');
        }
        return view('admin.create', [
            'property_name' => $this->property,
            'create_link' => route('admin.class.create')
        ]);
    }

    public function update(Request $request, EportalClass $class){
        if($request->isMethod(Request::METHOD_POST)){
            $this->validate($request, [
                'name' => 'required|unique:eportal_classes,name'
            ]);
            $this->classService->update($class, $request->all());
            return redirect()->route('admin.class.index');
        }
        return view('admin.edit', [
            'property_name' => $this->property,
            'property' => $class,
            'edit_link' => route('admin.class.edit', ['class' => $class->getId()])
        ]);
    }

    public function delete(Request $request){
        $this->validate($request, [
            'class' => 'required|exists:eportal_classes,id'
        ]);
        $class = $this->classService->findById($request->input('class'));
        $success = $this->classService->delete($class);
        if($request->wantsJson()){
            return response()->json([
                'success' => $success,
                'redirect' => route('admin.class.index')
            ]);
        }
        return redirect()->route('admin.class.index');
    }

    public function getDepartments(Request $request){
        $this->validate($request, [
            'school' => 'required|exists:schools,id',
            'class' => 'required|exists:eportal_classes,id'
        ]);
        $school = $this->getSchoolService()->findById($request->input('school'));
        $class = $this->classService->findById($request->input('class'));
        $departments = $this->classService->getDepartments($school, $class);
        return view('admin.eportalclass.departments', ['school' => $school, 'class' => $class, 'departments' => $departments]);
    }

    public function addDepartments(Request $request){
        $this->validate($request, [
            'school' => 'required|exists:schools,id',
            'class' => 'required|exists:eportal_classes,id'
        ]);
        $school = $this->getSchoolService()->findById($request->input('school'));
        $class = $this->classService->findById($request->input('class'));
        if($request->isMethod(Request::METHOD_POST)){
            $this->validate($request, [
                'departments.*' => 'required|exists:departments,id'
            ]);
            $departments = $request->input('departments');
            $this->classService->addDepartments($school, $class, $departments);
            return redirect()->route('admin.class.departments', ['school' => $school, 'class' => $class]);
        }
        $departments = $this->classService->getUnaddedDepartments($school, $class);
        return view('admin.eportalclass.add_departments', ['school' => $school, 'class' => $class, 'departments' => $departments]);
    }

    public function removeDepartments(Request $request){
        $this->validate($request, [
            'school' => 'required|exists:schools,id',
            'class' => 'required|exists:eportal_classes,id',
            'departments.*' => 'required|exists:departments,id'
        ]);
        $school = $this->getSchoolService()->findById($request->input('school'));
        $class = $this->classService->findById($request->input('class'));
        $departments = $request->input('departments');
        $this->classService->removeDepartments($school, $class, $departments);
        if($request->wantsJson()){
            return response()->json( [
                'success' => true,
                'redirect' => route('admin.class.departments', ['school' => $school, 'class' => $class])
            ]);
        }
        return redirect()->route('admin.class.departments', ['school' => $school, 'class' => $class]);
    }

    /**
     * @return SchoolRepositoryInterface
     */
    protected function getSchoolService(){
        if(!$this->schoolService){
            $this->schoolService = app(SchoolRepositoryInterface::class);
        }
        return $this->schoolService;
    }
}
