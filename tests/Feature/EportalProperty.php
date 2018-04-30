<?php

namespace Tests\Feature;

use Eportal\Models\Department;
use Eportal\Models\EportalClass;
use Eportal\Models\School;
use Eportal\Models\Session;
use Eportal\Models\Subject;
use Eportal\Models\Term;
use Eportal\Models\User\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function factory;

abstract class EportalProperty extends TestCase {

    use RefreshDatabase;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var Term
     */
    protected $term;

    /**
     * @var School
     */
    protected $school;

    /**
     * @var EportalClass
     */
    protected $class;

    /**
     * @var Department
     */
    protected $department;

    /**
     * @var Subject
     */
    protected $subject;

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

    protected function getUsers($amt){
        return factory(User::class, $amt)->create();
    }

    protected function sessionTerm(){
        $this->session = $this->getSessions()->first();
        $this->term = $this->getTerms()->first();
        $this->school = $this->getSchools()->first();
    }
}
