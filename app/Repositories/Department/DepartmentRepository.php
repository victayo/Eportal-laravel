<?php

namespace Eportal\Repositories\Department;
use Eportal\Models\Department;
use Eportal\Models\DepartmentSubject;
use Eportal\Models\EportalClass;
use Eportal\Models\School;
use Eportal\Models\SchoolClass;
use Eportal\Models\Session;
use Eportal\Models\Subject;
use Eportal\Models\Term;
use Eportal\Models\User\DepartmentUser;
use Eportal\Models\User\User;
use Eportal\Repositories\EportalClass\ClassRepository;
use Eportal\Repositories\EportalClass\ClassRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Description of DepartmentRepository
 *
 * @author OKALA
 */
class DepartmentRepository implements DepartmentRepositoryInterface
{

    /**
     *
     * @var ClassRepositoryInterface
     */
    protected $classRepo;


    /**
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Subject $subject
     * @return bool
     */
    public function addSubject(School $school, EportalClass $class, Department $department, Subject $subject)
    {
        if ($this->hasSubject($school, $class, $department, $subject)) {
            return false;
        }
        $cd = $this->getClassRepository()->getClassDepartment($school, $class, $department);
        if (!$cd) {
            return false;
        }
        $cd->subjects()->attach($subject->getId());
        return true;
    }

    /**
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param array $subjects
     * @return int
     */
    public function addSubjects(School $school, EportalClass $class, Department $department, array $subjects){
        $added = 0;
        foreach ($subjects as $subject){
            $subject = Subject::find($subject);
            if(!$subject){
                continue;
            }
            $suc = $this->addSubject($school, $class, $department, $subject);
            if($suc){
                $added++;
            }
        }
        return $added;
    }

    /**
     * @param array $attributes
     * @return Department
     */
    public function create(array $attributes)
    {
        $attributes['name'] = strtolower(trim($attributes['name']));
        return Department::create($attributes);
    }

    /**
     * @param Department $department
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Department $department)
    {
        return $department->delete();
    }

    /**
     * @param $id
     * @return Department
     */
    public function findById($id)
    {
        return Department::find($id);
    }

    /**
     * @param $name
     * @return Department
     */
    public function findByName($name)
    {
        return Department::where('name', strtolower(trim($name)))->first();
    }

    /**
     * @return Collection
     */
    public function getDepartments()
    {
        return Department::get();
    }

    /**
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @return Collection
     */
    public function getSubjects(School $school, EportalClass $class, Department $department)
    {
        $cd = $this->getClassRepository()->getClassDepartment($school, $class, $department);
        if (!$cd) {
            return collect();
        }
        return $cd->subjects()->get();
    }

    /**
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Subject $subject
     * @return bool
     */
    public function hasSubject(School $school, EportalClass $class, Department $department, Subject $subject)
    {
        return boolval($this->getDepartmentSubject($school, $class, $department, $subject));
    }

    /**
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Subject $subject
     * @return bool
     */
    public function removeSubject(School $school, EportalClass $class, Department $department, Subject $subject)
    {
        $cd = $this->getClassRepository()->getClassDepartment($school, $class, $department);
        if (!$cd) {
            return false;
        }
        $cd->subjects()->detach($subject->getId());
        return true;
    }

    /**
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param array $subjects
     * @return int
     */
    public function removeSubjects(School $school, EportalClass $class, Department $department, array $subjects){
        $removed = 0;
        foreach ($subjects as $subject){
            $subject = Subject::find($subject);
            if(!$subject){
                continue;
            }
            $suc = $this->removeSubject($school, $class, $department, $subject);
            if($suc){
                $removed++;
            }
        }
        return $removed;
    }

    public function getUnaddedSubjects(School $school, EportalClass $class, Department $department){
        $deptSubjects = DepartmentSubject::subjects($school, $class, $department)->pluck('id')->toArray();
        return Subject::whereNotIn('id', $deptSubjects)->get();
    }

    /**
     * @param Department $department
     * @param array $attributes
     * @return bool
     */
    public function update(Department $department, array $attributes)
    {
        return $department->update($attributes);
    }

    /**
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Subject $subject
     * @return DepartmentSubject|null
     */
    public function getDepartmentSubject(School $school, EportalClass $class, Department $department, Subject $subject)
    {
        $cd = $this->getClassRepository()->getClassDepartment($school, $class, $department);
        if (!$cd) {
            return null;
        }
        return DepartmentSubject::where('class_department_id', $cd->id)
            ->where('subject_id', $subject->getId())
            ->first();
    }

    /**
     * @return ClassRepositoryInterface
     */
    public function getClassRepository()
    {
        if (!$this->classRepo) {
            $this->classRepo = app()->make(ClassRepository::class);
        }
        return $this->classRepo;
    }

    /**
     * @param ClassRepositoryInterface $classRepo
     * @return $this
     */
    public function setClassRepository(ClassRepositoryInterface $classRepo)
    {
        $this->classRepo = $classRepo;
        return $this;
    }

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Session $session
     * @param Term $term
     * @return bool
     */
    public function addUser(User $user, School $school, EportalClass $class, Department $department, Session $session, Term $term)
    {
        if($this->hasUser($user, $school, $class, $department, $session, $term)){
            return false;
        }
        $classUser = $this->getClassRepository()->getClassUser($user, $school, $class, $session, $term);
        if(!$classUser){
            return false;
        }
        $classUser->departments()->attach($department->getId());
        return true;
    }

    /**
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Session $session
     * @param Term $term
     * @return Collection
     */
    public function getUsers(School $school, EportalClass $class, Department $department, Session $session, Term $term)
    {
        return Department::users($school, $class, $department, $session, $term)->get();
    }

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Session $session
     * @param Term $term
     * @return bool|null
     */
    public function removeUser(User $user, School $school, EportalClass $class, Department $department, Session $session, Term $term)
    {
        if(!$this->hasUser($user, $school, $class, $department, $session, $term)){
            return false;
        }
        $classUser = $this->getClassRepository()->getClassUser($user, $school, $class, $session, $term);
        $classUser->departments()->detach($department->getId());
        return true;
    }

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Session $session
     * @param Term $term
     * @return bool
     */
    public function hasUser(User $user, School $school, EportalClass $class, Department $department, Session $session, Term $term){
        return boolval($this->getDepartmentUser($user, $school, $class, $department, $session, $term));
    }

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Session $session
     * @param Term $term
     * @return DepartmentUser|null
     */
    public function getDepartmentUser(User $user, School $school, EportalClass $class, Department $department, Session $session, Term $term)
    {
        $cu = $this->getClassRepository()->getClassUser($user, $school, $class, $session, $term);
        if(!$cu){
            return null;
        }
        return DepartmentUser::where('class_user_id', $cu->id)
            ->where('department_id', $department->getId())
            ->first();
    }
}
