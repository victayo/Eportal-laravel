<?php

namespace Tests\Feature\Repositories\School;

use Eportal\Models\EportalClass;
use Eportal\Models\School;
use Eportal\Models\SchoolClass;
use Eportal\Models\SessionTerm;
use Eportal\Models\User\SchoolUser;
use Eportal\Models\User\SessionUser;
use Eportal\Repositories\School\SchoolRepository;
use function foo\func;
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
        $sessionTerm = $this->createSessionTerm($session, $term);
        $users = $this->getUsers($amt);
        $users->map(function($user) use ($sessionTerm, $school){
            $sessionUser = $this->addToSession($user, $sessionTerm);
            $this->addToSchool($school, $sessionUser);
        });
        $schoolUsers = $this->schoolRepository->getUsers($school, $session, $term);
        $this->assertEquals($amt, $schoolUsers->count());
    }

    public function testAddUser(){
        $session = $this->getSessions()->first();
        $term = $this->getTerms()->first();
        $school = $this->getSchools()->first();
        $user = $this->getUsers()->first();
        $sessionTerm = $this->createSessionTerm($session, $term);
        $sessionUser = $this->addToSession($user, $sessionTerm);
        $success = $this->schoolRepository->addUser($user, $school, $session, $term);
        $this->assertTrue($success);
        $this->assertDatabaseHas('school_users',['school_id' => $school->getId(), 'session_user_id' => $sessionUser->id]);
        /*
         * create a new session. Don't add user to session.
         */
        $session = $this->getSessions()->first();
        $this->createSessionTerm($session, $term);
        $success = $this->schoolRepository->addUser($user, $school, $session, $term);
        $this->assertFalse($success);
    }

    public function testRemoveUser(){
        $session = $this->getSessions()->first();
        $term = $this->getTerms()->first();
        $school = $this->getSchools()->first();
        $user = $this->getUsers()->first();
        $sessionTerm = $this->createSessionTerm($session, $term);
        $sessionUser = $this->addToSession($user, $sessionTerm);
        $this->addToSchool($school, $sessionUser);
        $this->assertDatabaseHas('school_users', ['school_id' => $school->getId(), 'session_user_id' => $sessionUser->id]);
        $success = $this->schoolRepository->removeUser($user, $school, $session, $term);
        $this->assertTrue($success);
        $this->assertDatabaseMissing('school_users', ['school_id' => $school->getId(), 'session_user_id' => $sessionUser->id]);
    }
}
