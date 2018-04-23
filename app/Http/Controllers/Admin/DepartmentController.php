<?php

namespace Eportal\Http\Controllers\Admin;

use Eportal\Http\Controllers\Controller;
use Eportal\Models\Department;
use Eportal\Repositories\Department\DepartmentRepositoryInterface;
use Eportal\Repositories\EportalClass\ClassRepositoryInterface;
use Eportal\Repositories\School\SchoolRepositoryInterface;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * @var DepartmentRepositoryInterface
     */
    protected $departmentService;

    /**
     * @var SchoolRepositoryInterface
     */
    protected $schoolService;

    /**
     * @var ClassRepositoryInterface
     */
    protected $classService;

    /**
     * DepartmentController constructor.
     * @param DepartmentRepositoryInterface $departmentService
     */
    public function __construct(DepartmentRepositoryInterface $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function index()
    {
        $departments = $this->departmentService->getDepartments();
        return view('admin.department.index', ['departments' => $departments]);
    }

    public function store(Request $request)
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $this->validate($request, [
                'name' => 'required|unique:departments,name'
            ]);
            $this->departmentService->create($request->all());
            return redirect()->route('admin.department.index');
        }
        return view('admin.department.create');
    }

    public function update(Request $request, Department $department)
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $this->validate($request, [
                'name' => 'required|unique:departments,name'
            ]);
            $this->departmentService->update($department, $request->all());
            return redirect()->route('admin.department.index');
        }
        return view('admin.department.edit', ['department' => $department]);
    }

    public function delete(Request $request)
    {
        $this->validate($request, [
            'department' => 'required|exists:departments,id'
        ]);
        $department = $this->departmentService->findById($request->input('department'));
        $success = $this->departmentService->delete($department);
        if ($request->wantsJson()) {
            return response()->json(['success' => $success, 'redirect' => route('admin.department.index')]);
        }
        return redirect()->route('admin.department.index');
    }

    public function getSubjects(Request $request)
    {
        $this->validate($request, [
            'school' => 'required|exists:schools,id',
            'class' => 'required|exists:eportal_classes,id',
            'department' => 'required|exists:departments,id'
        ]);
        $school = $this->getSchoolService()->findById($request->query('school'));
        $class = $this->getClassService()->findById($request->query('class'));
        $department = $this->departmentService->findById($request->query('department'));
        $subjects = $this->departmentService->getSubjects($school, $class, $department);
        return view('admin.department.subjects', [
            'school' => $school,
            'class' => $class,
            'department' => $department,
            'subjects' => $subjects
        ]);
    }

    public function addSubjects(Request $request)
    {
        $this->validate($request, [
            'school' => 'required|exists:schools,id',
            'class' => 'required|exists:eportal_classes,id',
            'department' => 'required|exists:departments,id'
        ]);
        $school = $this->getSchoolService()->findById($request->input('school'));
        $class = $this->getClassService()->findById($request->input('class'));
        $department = $this->departmentService->findById($request->input('department'));
        if ($request->isMethod(Request::METHOD_POST)) {
            $this->validate($request, [
                'subjects.*' => 'required|exists:subjects,id'
            ]);
            $subjects = $request->input('subjects');
            $this->departmentService->addSubjects($school, $class, $department, $subjects);
            return redirect()->route('admin.department.subjects', [
                'school' => $school,
                'class' => $class,
                'department' => $department,
            ]);
        }
        $subjects = $this->departmentService->getUnaddedSubjects($school, $class, $department);
        return view('admin.department.add_subjects', [
            'school' => $school,
            'class' => $class,
            'department' => $department,
            'subjects' => $subjects
        ]);
    }

    public function removeSubjects(Request $request)
    {
        $this->validate($request, [
            'school' => 'required|exists:schools,id',
            'class' => 'required|exists:eportal_classes,id',
            'department' => 'required|exists:departments,id',
            'subjects.*' => 'required|exists:subjects,id'
        ]);
        $school = $this->getSchoolService()->findById($request->input('school'));
        $class = $this->getClassService()->findById($request->input('class'));
        $department = $this->departmentService->findById($request->input('department'));
        $subjects = $request->input('subjects');
        $this->departmentService->removeSubjects($school, $class, $department, $subjects);
        if($request->wantsJson()){
            return response()->json(['success' => true, 'redirect' => route('admin.department.subjects', [
                'school' => $school,
                'class' => $class,
                'department' => $department,
            ])]);
        }
        return view('admin.department.subjects', [
            'school' => $school,
            'class' => $class,
            'department' => $department,
        ]);
    }

    /**
     * @return SchoolRepositoryInterface
     */
    public function getSchoolService(): SchoolRepositoryInterface
    {
        if (!$this->schoolService) {
            $this->schoolService = app(SchoolRepositoryInterface::class);
        }
        return $this->schoolService;
    }

    /**
     * @return ClassRepositoryInterface
     */
    public function getClassService(): ClassRepositoryInterface
    {
        if (!$this->classService) {
            $this->classService = app(ClassRepositoryInterface::class);
        }
        return $this->classService;
    }


}
