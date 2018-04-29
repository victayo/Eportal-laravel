<?php

namespace Eportal\Repositories\Subject;

use Eportal\Models\Department;
use Eportal\Models\EportalClass;
use Eportal\Models\School;
use Eportal\Models\Session;
use Eportal\Models\Subject;
use Eportal\Models\Term;
use Eportal\Models\User\SubjectUser;
use Eportal\Models\User\User;
use Eportal\Repositories\Department\DepartmentRepository;
use Eportal\Repositories\Department\DepartmentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Description of SubjectRepository
 *
 * @author OKALA
 */
class SubjectRepository implements SubjectRepositoryInterface {

    /**
     * @var DepartmentRepositoryInterface
     */
    protected $departmentRepository;

    /**
     * @param array $attributes
     * @return Subject
     */
    public function create(array $attributes) {
        $attributes['name'] = strtolower(trim($attributes['name']));
        return Subject::create($attributes);
    }

    /**
     * @param Subject $subject
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Subject $subject) {
        return $subject->delete();
    }

    /**
     * @param $id
     * @return Subject
     */
    public function findById($id) {
        return Subject::find($id);
    }

    /**
     * @param $name
     * @return Subject
     */
    public function findByName($name) {
        return Subject::where('name', strtolower(trim($name)))->first();
    }

    /**
     * @return Collection
     */
    public function getSubjects() {
        return Subject::get();
    }

    /**
     * @param Subject $subject
     * @param array $attributes
     * @return bool
     */
    public function update(Subject $subject, array $attributes) {
        return $subject->update($attributes);
    }

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Subject $subject
     * @param Session $session
     * @param Term $term
     * @return bool
     */
    public function addUser(User $user, School $school, EportalClass $class, Department $department, Subject $subject, Session $session, Term $term)
    {
        if($this->getSubjectUser($user, $school, $class, $department, $subject, $session, $term)){
            return false;
        }
        $du = $this->getDepartmentRepository()->getDepartmentUser($user, $school, $class, $department, $session, $term);
        if(!$du){
            return false;
        }
        SubjectUser::create([
            'department_user_id' => $du->id,
            'subject_id' => $subject->getId()
        ]);
        return true;
    }

    /**
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Subject $subject
     * @param Session $session
     * @param Term $term
     * @return Collection
     */
    public function getUsers(School $school, EportalClass $class, Department $department, Subject $subject, Session $session, Term $term)
    {
        return Subject::users($school, $class, $department, $subject, $session, $term)->get();
    }

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Subject $subject
     * @param Session $session
     * @param Term $term
     * @return bool|null
     * @throws \Exception
     */
    public function removeUser(User $user, School $school, EportalClass $class, Department $department, Subject $subject, Session $session, Term $term)
    {
        $su = $this->getSubjectUser($user, $school, $class, $department, $subject, $session, $term);
        if(!$su){
            return false;
        }
        return $su->delete();
    }

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Subject $subject
     * @param Session $session
     * @param Term $term
     * @return SubjectUser|null
     */
    public function getSubjectUser(User $user, School $school, EportalClass $class, Department $department, Subject $subject, Session $session, Term $term)
    {
       $du = $this->getDepartmentRepository()->getDepartmentUser($user, $school, $class, $department, $session, $term);
       if(!$du){
           return null;
       }
       return SubjectUser::where('department_user_id', $du->id)
           ->where('subject_id', $subject->getId())
           ->first();
    }

    /**
     * @return DepartmentRepositoryInterface
     */
    public function getDepartmentRepository(){
        if(!$this->departmentRepository){
            $this->departmentRepository = app()->make(DepartmentRepository::class);
        }
        return $this->departmentRepository;
    }

    /**
     * @param DepartmentRepositoryInterface $departmentRepository
     * @return $this
     */
    public function setDepartmentRepository(DepartmentRepositoryInterface $departmentRepository){
        $this->departmentRepository = $departmentRepository;
        return $this;
    }
}
