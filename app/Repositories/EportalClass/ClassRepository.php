<?php

namespace Eportal\Repositories\EportalClass;

use Eportal\Models\ClassDepartment;
use Eportal\Models\Department;
use Eportal\Models\EportalClass;
use Eportal\Models\School;
use Eportal\Models\Session;
use Eportal\Models\Term;
use Eportal\Models\User\ClassUser;
use Eportal\Models\User\User;
use Eportal\Repositories\School\SchoolRepository;
use Eportal\Repositories\School\SchoolRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use function app;

/**
 * Description of ClassRepository
 *
 * @author OKALA
 */
class ClassRepository implements ClassRepositoryInterface {

    /**
     *
     * @var SchoolRepositoryInterface
     */
    protected $schoolRepository;

    /**
     * @param $id
     * @return EportalClass|null
     */
    public function findById($id) {
        return EportalClass::find($id);
    }

    /**
     * @param $name
     * @return EportalClass|null
     */
    public function findByName($name) {
        return EportalClass::where('name', strtolower(trim($name)))->first();
    }

    /**
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @return bool
     */
    public function addDepartment(School $school, EportalClass $class, Department $department) {
        if ($this->hasDepartment($school, $class, $department)) {
            return false;
        }
        $schoolClass = $this->getSchoolRepository()->getSchoolClass($school, $class);
        $schoolClass->departments()->attach($department->getId());
        return true;
    }

    /**
     * @param School $school
     * @param EportalClass $class
     * @param array $departments
     * @return int
     */
    public function addDepartments(School $school, EportalClass $class, array $departments){
        $added = 0;
        foreach($departments as $department){
           $department = Department::find($department);
           if(!$department){
               continue;
           }
           $success = $this->addDepartment($school, $class, $department);
           if($success){
               $added++;
           }
        }
        return $added;
    }

    /**
     * @param array $attributes
     * @return EportalClass
     */
    public function create(array $attributes) {
        return EportalClass::create($attributes);
    }

    /**
     * @param EportalClass $class
     * @return bool|null
     * @throws \Exception
     */
    public function delete(EportalClass $class) {
        return $class->delete();
    }

    /**
     * @return Collection
     */
    public function getClasses() {
        return EportalClass::get();
    }

    /**
     * @param School $school
     * @param EportalClass $class
     * @return Collection
     */
    public function getDepartments(School $school, EportalClass $class) {
        $schoolClass = $this->getSchoolRepository()->getSchoolClass($school, $class);
        if(!$schoolClass){
            return collect();
        }
        return $schoolClass->departments()->get();
    }

    /**
     * @param School $school
     * @param EportalClass $class
     * @return Collection
     */
    public function getUnaddedDepartments(School $school, EportalClass $class){
        $departments = $this->getDepartments($school, $class)->pluck('id')->toArray();
        return Department::WhereNotIn('id', $departments)->get();
    }

    /**
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @return bool
     */
    public function hasDepartment(School $school, EportalClass $class, Department $department) {
        $sc = $this->getSchoolRepository()->getSchoolClass($school, $class);
        if(!$sc){
            return false;
        }
        $cd = ClassDepartment::where('school_class_id', $sc->id)
                ->where('department_id', $department->getId())
                ->first();
        return boolval($cd);
    }

    /**
     * 
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @return boolean
     */
    public function removeDepartment(School $school, EportalClass $class, Department $department) {
        if(!$this->hasDepartment($school, $class, $department)){
            return false;
        }
        $sc = $this->getSchoolRepository()->getSchoolClass($school, $class);
        $sc->departments()->detach($department->getId());
        return true;
    }

    /**
     * @param School $school
     * @param EportalClass $class
     * @param array $departments
     * @return int
     */
    public function removeDepartments(School $school, EportalClass $class, array $departments) {
        $removed = 0;
        foreach($departments as $department){
           $department = Department::find($department);
           if(!$department){
               continue;
           }
           $success = $this->removeDepartment($school, $class, $department);
           if($success){
               $removed++;
           }
        }
        return $removed;
    }

    /**
     * @param EportalClass $class
     * @param array $attributes
     * @return bool
     */
    public function update(EportalClass $class, array $attributes) {
        return $class->update($attributes);
    }

    /**
     * 
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @return ClassDepartment|null
     */
    public function getClassDepartment(School $school, EportalClass $class, Department $department){
        $sc = $this->getSchoolRepository()->getSchoolClass($school, $class);
        if(!$sc){
            return null;
        }
        return ClassDepartment::where(['school_class_id' => $sc->id, 'department_id' => $department->getId()])->first();
    }

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Session $session
     * @param Term $term
     * @return bool
     */
    public function addUser(User $user, School $school, EportalClass $class, Session $session, Term $term)
    {
        $schoolUser = $this->getSchoolRepository()->getSchoolUser($user, $school, $session, $term);
        if(!$schoolUser){
            return false;
        }
        if($this->hasUser($user, $school, $class, $session, $term)){
            return false;
        }
        $schoolUser->eportalClass()->attach($class->getId());
        return true;
    }

    /**
     * @param School $school
     * @param EportalClass $class
     * @param Session $session
     * @param Term $term
     * @return Collection
     */
    public function getUsers(School $school, EportalClass $class, Session $session, Term $term)
    {
        $users = EportalClass::users($school, $class, $session, $term)->get();
        return $users->map(function ($user){
            $u = new User();
            return $u->forceFill($user->toArray());
        });
    }

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Session $session
     * @param Term $term
     * @return bool
     * @throws \Exception
     */
    public function removeUser(User $user, School $school, EportalClass $class, Session $session, Term $term)
    {
        $schoolUser = $this->getSchoolRepository()->getSchoolUser($user, $school, $session, $term);
        if(!$schoolUser){
            return false;
        }
        if(!$this->hasUser($user, $school, $class, $session, $term)){
            return false;
        }
        $schoolUser->eportalClass()->detach($class->getId());
        return true;
    }

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Session $session
     * @param Term $term
     * @return ClassUser|null
     */
    public function getClassUser(User $user, School $school, EportalClass $class, Session $session, Term $term)
    {
        $schoolUser = $this->getSchoolRepository()->getSchoolUser($user, $school, $session, $term);
        if(!$schoolUser){
            return null;
        }
        return ClassUser::where('school_user_id', $schoolUser->id)
            ->where('class_id', $class->getId())
            ->first();
    }

    public function hasUser(User $user, School $school, EportalClass $class, Session $session, Term $term){
        return boolval($this->getClassUser($user, $school, $class, $session, $term));
    }
    /**
     * SchoolRepositoryInterface
     */
    public function getSchoolRepository() {
        if (!$this->schoolRepository) {
            $this->schoolRepository = app()->make(SchoolRepository::class);
        }
        return $this->schoolRepository;
    }

    /**
     * @param SchoolRepositoryInterface $schoolRepository
     * @return $this
     */
    public function setSchoolRepository(SchoolRepositoryInterface $schoolRepository){
        $this->schoolRepository = $schoolRepository;
        return $this;
    }
}
