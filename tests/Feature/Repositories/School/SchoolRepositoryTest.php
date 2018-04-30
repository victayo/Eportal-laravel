<?php

namespace Tests\Feature\Repositories\School;

use Eportal\Models\EportalClass;
use Eportal\Models\School;
use Eportal\Models\SchoolClass;
use Eportal\Models\SessionTerm;
use Eportal\Models\User\SchoolUser;
use Eportal\Models\User\SessionUser;
use Eportal\Repositories\School\SchoolRepository;
use Tests\Feature\EportalProperty;
use function factory;

class SchoolRepositoryTest extends EportalProperty {

    /**
     *
     * @var SchoolRepository
     */
    protected $schoolRepository;

    public function setUp() {
        parent::setUp();
        $this->schoolRepository = new SchoolRepository();
    }

    public function testGetSchools() {
        $amt = 5;
        $this->getSchools($amt);
        $result = $this->schoolRepository->getSchools();
        $this->assertEquals($amt, $result->count());
    }

    public function testGetClasses() {
        $school = $this->getSchools()->first();
        $amt = 5;
        $classes = $this->getClasses($amt);
        foreach ($classes as $class) {
            SchoolClass::create(['school_id' => $school->getId(), 'class_id' => $class->getId()]);
        }
        $result = $this->schoolRepository->getClasses($school);
        $this->assertEquals($amt, $result->count());
    }

    public function testHasClass() {
        $school = $this->getSchools()->first();
        $class = $this->getClasses()->first();
        $result = $this->schoolRepository->hasClass($school, $class);
        $this->assertFalse($result);
        SchoolClass::create(['school_id' => $school->getId(), 'class_id' => $class->getId()]);
        $result = $this->schoolRepository->hasClass($school, $class);
        $this->assertTrue($result);
    }

    public function testAddClass() {
        $school = $this->getSchools()->first();
        $class = $this->getClasses()->first();
        $result = $this->schoolRepository->addClass($school, $class);
        $this->assertTrue($result);
        $this->assertDatabaseHas('school_class', ['school_id' => $school->getId(), 'class_id' => $class->getId()]);
    }

    public function testGetUsers(){
        $amt = 5;
        $session = $this->getSessions()->first();
        $school = $this->getSchools()->first();
        $term = $this->getTerms()->first();
        $sessionTerm = SessionTerm::create(['session_id' => $session->getId(), 'term_id' => $term->getId()]);
        $users = $this->getUsers($amt);
        $users->map(function($user) use ($sessionTerm, $school){
            $su = SessionUser::create(['user_id' => $user->id, 'session_term_id' => $sessionTerm->id]);
            return SchoolUser::create(['school_id' => $school->getId(), 'session_user_id' => $su->id]);
        });
        $schoolUsers = $this->schoolRepository->getUsers($school, $session, $term);
        $this->assertEquals($amt, $schoolUsers->count());
    }
}
