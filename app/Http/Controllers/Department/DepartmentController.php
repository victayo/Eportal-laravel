<?php

namespace Eportal\Http\Controllers\Department;

use Eportal\Http\Controllers\Controller;
use Eportal\Models\Department;
use Eportal\Repositories\Department\DepartmentRepository;
use Eportal\Repositories\EportalClass\ClassRepository;
use Eportal\Repositories\EportalClass\ClassRepositoryInterface;
use Eportal\Repositories\School\SchoolRepository;
use Eportal\Repositories\School\SchoolRepositoryInterface;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * @var DepartmentRepository
     */
    protected $departmentRepo;

    /**
     * @var ClassRepositoryInterface
     */
    protected $classRepo;

    /**
     * @var SchoolRepositoryInterface
     */
    protected $schoolRepo;

    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepo = $departmentRepository;
    }

    public function index(){
        $departments = $this->departmentRepo->getDepartments();
        return response()->json(['success' => true, 'departments' => $departments]);
    }

    public function show(Department $department){
        return response()->json(['success' => true, 'department' => $department]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:departments,name',
        ]);
        $department = $this->departmentRepo->create($request->all());
        return response()->json(['success' => true, 'department' => $department]);
    }

    public function update(Request $request, Department $department){
        $name = $request->input('name', '');
        if (strcasecmp($name, $department->getName()) == 0) {
            //nothing to update
            return response()->json(['success' => true, 'department' => $department]);
        }
        $this->validate($request, [
            'name' => 'required|string|unique:departments,name'
        ]);
        $success = $this->departmentRepo->update($department, $request->all());
        return response()->json(['success' => $success, 'department' => $department]);
    }

    public function delete(Department $department){
        $success = $this->departmentRepo->delete($department);
        return response()->json(['success' => $success]);
    }

    public function getSubjects(Request $request){
        $this->validate($request, [
            'school' => 'required|exists:schools,id',
            'class' => 'required|exists:eportal_classes,id',
            'department' => 'required|exists:departments,id'
        ]);
        $school = $this->getSchoolRepository()->findById($request->query('school'));
        $class = $this->getClassRepository()->findById($request->query('class'));
        $department = $this->departmentRepo->findById($request->query('department'));
        $subjects = $this->departmentRepo->getSubjects($school, $class, $department);
        $success = true;
        if(null === $subjects){
            $success = false;
            $subjects = [];
        }
        return response()->json(['success' => $success, 'subjects' => $subjects]);
    }

    public function addSubject(Request $request){
        $this->validate($request, [
            'school' => 'required|exists:schools,id',
            'class' => 'required|exists:eportal_classes,id',
            'department' => 'required|exists:departments,id',
            'subjects.*' => 'required|exists:subjects,id'
        ]);
        $school = $this->getSchoolRepository()->findById($request->input('school'));
        $class = $this->getClassRepository()->findById($request->input('class'));
        $department = $this->departmentRepo->findById($request->input('department'));
        $subjects = $request->input('subjects');
        $added = $this->departmentRepo->addSubjects($school, $class, $department, $subjects);
        return response()->json(['success' => true, 'added' => $added]);
    }

    public function removeSubject(Request $request){
        $this->validate($request, [
            'school' => 'required|exists:schools,id',
            'class' => 'required|exists:eportal_classes,id',
            'department' => 'required|exists:departments,id',
            'subjects.*' => 'required|exists:subjects,id'
        ]);
        $school = $this->getSchoolRepository()->findById($request->input('school'));
        $class = $this->getClassRepository()->findById($request->input('class'));
        $department = $this->departmentRepo->findById($request->input('department'));
        $subjects = $request->input('subjects');
        $removed = $this->departmentRepo->removeSubjects($school, $class, $department, $subjects);
        return response()->json(['success' => true, 'removed' => $removed]);
    }

    /**
     * @return DepartmentRepository
     */
    public function getDepartmentRepository()
    {
        return $this->departmentRepo;
    }

    /**
     * @param DepartmentRepository $departmentRepo
     * @return DepartmentController
     */
    public function setDepartmentRepository($departmentRepo)
    {
        $this->departmentRepo = $departmentRepo;
        return $this;
    }

    /**
     * @return ClassRepositoryInterface
     */
    public function getClassRepository()
    {
        if(!$this->classRepo){
            $this->classRepo = app()->make(ClassRepository::class);
        }
        return $this->classRepo;
    }

    /**
     * @param ClassRepositoryInterface $classRepo
     * @return DepartmentController
     */
    public function setClassRepository($classRepo)
    {
        $this->classRepo = $classRepo;
        return $this;
    }

    /**
     * @return SchoolRepositoryInterface
     */
    public function getSchoolRepository()
    {
        if(!$this->schoolRepo){
            $this->schoolRepo = app()->make(SchoolRepository::class);
        }
        return $this->schoolRepo;
    }

    /**
     * @param SchoolRepositoryInterface $schoolRepo
     * @return DepartmentController
     */
    public function setSchoolRepository($schoolRepo)
    {
        $this->schoolRepo = $schoolRepo;
        return $this;
    }


}
