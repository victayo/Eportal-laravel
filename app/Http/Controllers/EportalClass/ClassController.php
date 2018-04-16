<?php

namespace Eportal\Http\Controllers\EportalClass;

use Eportal\Http\Controllers\Controller;
use Eportal\Models\EportalClass;
use Eportal\Repositories\EportalClass\ClassRepository;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     *
     * @var ClassRepository
     */
    protected $classRepository;

    public function __construct(ClassRepository $classRepository)
    {
        $this->classRepository = $classRepository;
    }

    public function index()
    {
        $classes = $this->classRepository->getClasses();
        return response()->json(['success' => true, 'classes' => $classes]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:eportal_classes,name',
        ]);
        $class = $this->classRepository->create($request->all());
        return response()->json(['success' => true, 'class' => $class]);
    }

    public function show(EportalClass $eportalClass){
        return response()->json(['success' => true, 'class' => $eportalClass]);
    }

    public function update(Request $request, EportalClass $class)
    {
        $name = $request->input('name', '');
        if (strcasecmp($name, $class->getName()) == 0) {
            //nothing to update
            return response()->json(['success' => true, 'class' => $class]);
        }
        $this->validate($request, [
            'name' => 'required|string|unique:eportal_classes,name'
        ]);
        $success = $this->classRepository->update($class, $request->all());
        return response()->json(['success' => $success, 'class' => $class]);
    }

    public function delete(EportalClass $class)
    {
        $success = $this->classRepository->delete($class);
        return response()->json(['success' => $success]);
    }

    /**
     * @param Request $request
     * @param EportalClass $class
     * @return \Illuminate\Http\JsonResponse
     *
     * /class/department/{classId}?school={schoolId}
     */
    public function getDepartments(Request $request, EportalClass $class)
    {
        $this->validate($request, [
            'school' => 'required|exists:schools,id'
        ]);
        $school = $this->classRepository->getSchoolRepository()->findById($request->query('school'));
        $departments = $this->classRepository->getDepartments($school, $class);
        return response()->json(['success' => true, 'departments' => $departments]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * /class/department/add
     */
    public function addDepartment(Request $request)
    {
        $this->validate($request, [
            'school' => 'required|exists:schools,id',
            'class' => 'required|exists:eportal_classes,id',
            'departments.*' => 'nullable|exists:departments,id'
        ]);
        $departments = $request->input('departments');
        if (!$departments) {//no departments. return
            return response()->json(['success' => true]);
        }
        $class = $this->classRepository->findById($request->input('class'));
        $school = $this->classRepository->getSchoolRepository()->findById($request->input('school'));
        $added = $this->classRepository->addDepartments($school, $class, $departments);
        return response()->json(['success' => true, 'added' => $added]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * /class/department/remove
     */
    public function removeDepartment(Request $request)
    {
        $this->validate($request, [
            'school' => 'required|exists:schools,id',
            'class' => 'required|exists:eportal_classes,id',
            'departments.*' => 'nullable|exists:departments,id'
        ]);
        $departments = $request->input('departments');
        if (!$departments) {//no departments. return
            return response()->json(['success' => true]);
        }
        $school = $this->classRepository->getSchoolRepository()->findById($request->input('school'));
        $class = $this->classRepository->findById($request->input('class'));
        $removed = $this->classRepository->removeDepartments($school, $class, $departments);
        return response()->json(['success' => true, 'removed' => $removed]);
    }

    public function getClassRepository()
    {
        return $this->classRepository;
    }

    public function setClassRepository(ClassRepository $classRepository)
    {
        $this->classRepository = $classRepository;
        return $this;
    }
}
