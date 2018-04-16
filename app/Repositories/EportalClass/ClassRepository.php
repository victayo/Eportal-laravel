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
use function app;
use Illuminate\Database\Eloquent\Collection;

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

    public function findById($id) {
        return EportalClass::find($id);
    }
    
    public function findByName($name) {
        return EportalClass::where('name', strtolower(trim($name)))->first();
    }
    
    public function addDepartment(School $school, EportalClass $class, Department $department) {
        if ($this->hasDepartment($school, $class, $department)) {
            return false;
        }
        $id = $this->getSchoolRepository()->getSchoolClass($school, $class)->id;
        ClassDepartment::create(['school_class_id' => $id, 'department_id' => $department->getId()]);
        return true;
    }
    
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

    public function create(array $attributes) {
        return EportalClass::create($attributes);
    }

    public function delete(EportalClass $class) {
        return $class->delete();
    }

    public function getClasses() {
        return EportalClass::all();
    }

    public function getDepartments(School $school, EportalClass $class) {
        return ClassDepartment::departments($school, $class)->get();
    }

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
        $cd = ClassDepartment::where('school_class_id', $sc->id)
                ->where('department_id', $department->getId())
                ->first();
        return $cd->delete();
    }

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
        return ClassDepartment::where(['school_class_id' => $sc->id, 'department_id' => $department->getId()])
                ->first();
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
        $classUser = $this->getClassUser($user, $school, $class, $session, $term);
        if($classUser){ //user already added to class
            return false;
        }
        ClassUser::create([
            'school_user_id' => $schoolUser->id,
            'class_id' => $class->getId()
        ]);
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
        return EportalClass::users($school, $class, $session, $term)->get();
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
        $classUser = $this->getClassUser($user, $school, $class, $session, $term);
        if(!$classUser){ //user not in class
            return false;
        }
        $classUser->delete();
        return true;
    }

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Session $session
     * @param Term $term
     * @return ClassUser
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
