<?php

namespace Tests\Feature;

use Eportal\Models\Department;
use Eportal\Models\EportalClass;
use Eportal\Models\School;
use Eportal\Models\Session;
use Eportal\Models\SessionTerm;
use Eportal\Models\Subject;
use Eportal\Models\Term;
use Eportal\Models\User\ClassUser;
use Eportal\Models\User\DepartmentUser;
use Eportal\Models\User\SchoolUser;
use Eportal\Models\User\SessionUser;
use Eportal\Models\User\SubjectUser;
use Eportal\Models\User\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function factory;

abstract class EportalProperty extends TestCase {

//    use RefreshDatabase;

    /**
     * @param int $amt
     * @return Collection
     */
    public function getSessions($amt = 1){
        return factory(Session::class, $amt)->create();
    }

    /**
     * @param int $amt
     * @return Collection
     */
    public function getTerms($amt = 1){
        return factory(Term::class, $amt)->create();
    }

    /**
     * @param int $amt
     * @return Collection
     */
    public function getSchools($amt = 1) {
        return factory(School::class, $amt)->create();
    }

    /**
     * @param int $amt
     * @return Collection
     */
    public function getClasses($amt = 1) {
        return factory(EportalClass::class, $amt)->create();
    }

    /**
     * @param int $amt
     * @return Collection
     */
    public function getDepartments($amt = 1) {
        return factory(Department::class, $amt)->create();
    }

    /**
     * @param int $amt
     * @return Collection
     */
    public function getSubjects($amt = 1){
        return factory(Subject::class, $amt)->create();
    }

    protected function getUsers($amt = 1){
        return factory(User::class, $amt)->create();
    }

    protected function createSessionTerm($session, $term){
        return SessionTerm::create(['session_id' => $session->getId(), 'term_id' => $term->getId()]);
    }

    protected function addToSession($user, $sessionTerm){
        return SessionUser::create(['user_id' => $user->id, 'session_term_id' => $sessionTerm->id]);
    }

    protected function addToSchool($school, $sessionUser){
        return SchoolUser::create([
            'school_id' => $school->getId(),
            'session_user_id' => $sessionUser->id
        ]);
    }

    protected function addToClass($class, $schoolUser){
        return ClassUser::create([
            'school_user_id' => $schoolUser->id,
            'class_id' => $class->getId()
        ]);
    }

    protected function addToDepartment($department, $classUser){
        return DepartmentUser::create([
            'class_user_id' => $classUser->id,
            'department_id' => $department->getId()
        ]);
    }

    protected function addToSubject($subject, $deptUser){
        return SubjectUser::create([
            'department_user_id' => $deptUser->id,
            'subject_id' => $subject->getId()
        ]);
    }
}
