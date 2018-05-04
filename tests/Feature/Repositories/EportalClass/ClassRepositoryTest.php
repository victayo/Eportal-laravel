<?php

namespace Tests\Feature\Repositories\EportalClass;

use Eportal\Models\ClassDepartment;
use Eportal\Models\SchoolClass;
use Eportal\Repositories\EportalClass\ClassRepository;
use Eportal\Repositories\EportalClass\ClassRepositoryInterface;
use Eportal\Repositories\School\SchoolRepository;
use Eportal\Repositories\School\SchoolRepositoryInterface;
use Tests\Feature\EportalProperty;

class ClassRepositoryTest extends EportalProperty
{

    /**
     * @var ClassRepositoryInterface
     */
    protected $classRepository;

    /**
     * @var SchoolRepositoryInterface
     */
    protected $schoolRepository;

    public function setUp()
    {
        parent::setUp();
        $this->schoolRepository = $this->getMockBuilder(SchoolRepository::class)->getMock();
        $this->classRepository = new ClassRepository();
        $this->classRepository->setSchoolRepository($this->schoolRepository);
    }

    public function testAddDepartment()
    {
        $school = $this->getSchools()->first();
        $class = $this->getClasses()->first();
        $sc = SchoolClass::create(['school_id' => $school->getId(), 'class_id' => $class->getId()]);
        $this->schoolRepository->expects($this->exactly(2))
            ->method('getSchoolClass')
            ->will($this->returnValue($sc));
        $department = $this->getDepartments()->first();
        $result = $this->classRepository->addDepartment($school, $class, $department);
        $this->assertDatabaseHas('class_department', ['school_class_id' => $sc->id, 'department_id' => $department->getId()]);
        $this->assertTrue($result);
    }

    public function testHasDepartmentReturnFalse()
    {
        $school = $this->getSchools()->first();
        $class = $this->getClasses()->first();
        $department = $this->getDepartments()->first();
        $this->schoolRepository->expects($this->once())
            ->method('getSchoolClass')
            ->will($this->returnValue(null));
        $result = $this->classRepository->hasDepartment($school, $class, $department);
        $this->assertFalse($result);
    }

    public function testHasDepartmentReturnTrue()
    {
        $school = $this->getSchools()->first();
        $class = $this->getClasses()->first();
        $department = $this->getDepartments()->first();
        $sc = SchoolClass::create(['school_id' => $school->getId(), 'class_id' => $class->getId()]);
        $this->schoolRepository->expects($this->once())
            ->method('getSchoolClass')
            ->will($this->returnValue($sc));
        ClassDepartment::create(['school_class_id' => $sc->id, 'department_id' => $department->getId()]);
        $result = $this->classRepository->hasDepartment($school, $class, $department);
        $this->assertTrue($result);
    }

    public function testRemoveDepartment()
    {
        $school = $this->getSchools()->first();
        $class = $this->getClasses()->first();
        $department = $this->getDepartments()->first();
        $sc = SchoolClass::create(['school_id' => $school->getId(), 'class_id' => $class->getId()]);
        $this->schoolRepository->expects($this->exactly(2))
            ->method('getSchoolClass')
            ->will($this->returnValue($sc));
        ClassDepartment::create(['school_class_id' => $sc->id, 'department_id' => $department->getId()]);
        $result = $this->classRepository->removeDepartment($school, $class, $department);
        $this->assertTrue($result);
    }

    public function testGetUsers()
    {
        $amt = 5;
        $session = $this->getSessions()->first();
        $term = $this->getTerms()->first();
        $school = $this->getSchools()->first();
        $class = $this->getClasses()->first();
        $sessionTerm = $this->createSessionTerm($session, $term);
        $users = $this->getUsers($amt);
        $users->map(function ($user) use ($school, $class, $session, $term, $sessionTerm) {
            $sessionUser = $this->addToSession($user, $sessionTerm);
            $schoolUser = $this->addToSchool($school, $sessionUser);
            $this->addToClass($class, $schoolUser);
        });
        $classUsers = $this->classRepository->getUsers($school, $class, $session, $term);
        $this->assertEquals($classUsers->count(), $amt);
    }

    public function testAddUser(){
        $session = $this->getSessions()->first();
        $term = $this->getTerms()->first();
        $school = $this->getSchools()->first();
        $class = $this->getClasses()->first();
        $sessionTerm = $this->createSessionTerm($session, $term);
        $user = $this->getUsers()->first();
        $sessionUser = $this->addToSession($user, $sessionTerm);
        $result = $this->classRepository->addUser($user, $school, $class, $session, $term);
        $schoolUser = $this->addToSchool($school, $sessionUser);
        $this->schoolRepository->expects($this->any())
            ->method('getSchoolUser')
            ->will($this->returnValue($schoolUser));
        $this->assertFalse($result);
        $this->assertDatabaseMissing('class_users', ['class_id' => $class->getId(), 'school_user_id' => $schoolUser->id]);
        $result = $this->classRepository->addUser($user, $school, $class, $session, $term);
        $this->assertTrue($result);
        $this->assertDatabaseHas('class_users', ['class_id' => $class->getId(), 'school_user_id' => $schoolUser->id]);
    }

    public function testRemoveUser(){
        $session = $this->getSessions()->first();
        $term = $this->getTerms()->first();
        $school = $this->getSchools()->first();
        $class = $this->getClasses()->first();
        $sessionTerm = $this->createSessionTerm($session, $term);
        $user = $this->getUsers()->first();
        $sessionUser = $this->addToSession($user, $sessionTerm);
        $schoolUser = $this->addToSchool($school, $sessionUser);
        $this->addToClass($class, $schoolUser);
        $this->schoolRepository->expects($this->any())
            ->method('getSchoolUser')
            ->will($this->returnValue($schoolUser));
        $result = $this->classRepository->removeUser($user, $school, $class, $session, $term);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('class_users', ['class_id' => $class->getId(), 'school_user_id' => $schoolUser->id]);
    }
}
