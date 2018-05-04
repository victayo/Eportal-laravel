<?php

namespace Tests\Feature\Repositories;

use Eportal\Models\ClassDepartment;
use Eportal\Models\DepartmentSubject;
use Eportal\Models\SchoolClass;
use Eportal\Models\Subject;
use Eportal\Repositories\Department\DepartmentRepository;
use Eportal\Repositories\Department\DepartmentRepositoryInterface;
use Eportal\Repositories\EportalClass\ClassRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Feature\EportalProperty;

class DepartmentRepositoryTest extends EportalProperty
{

    /**
     * @var MockObject
     */
    protected $classRepository;

    /**
     * @var DepartmentRepositoryInterface
     */
    protected $departmentRepository;

    public function setUp()
    {
        parent::setUp();
        $this->classRepository = $this->getMockBuilder(ClassRepository::class)->getMock();
        $this->departmentRepository = new DepartmentRepository();
        $this->departmentRepository->setClassRepository($this->classRepository);
    }

    public function testAddSubject(){
        $school = $this->getSchools()->first();
        $class = $this->getClasses()->first();
        $department = $this->getDepartments()->first();
        $subject = $this->getSubjects()->first();
        $sc = $this->getSchoolClass($school, $class);
        $classDept = $this->getClassDepartment($sc, $department);
        $this->classRepository->expects($this->any())
            ->method('getClassDepartment')
            ->will($this->returnValue($classDept));
        $result = $this->departmentRepository->addSubject($school, $class, $department, $subject);
        $this->assertTrue($result);
        $this->assertDatabaseHas('department_subject', ['class_department_id' => $classDept->id, 'subject_id' => $subject->getId()]);
    }

    public function testGetSubjects(){
        $amt = 5;
        $school = $this->getSchools()->first();
        $class = $this->getClasses()->first();
        $department = $this->getDepartments()->first();
        $subjects = $this->getSubjects($amt);
        $sc = $this->getSchoolClass($school, $class);
        $classDept = $this->getClassDepartment($sc, $department);
        $subjects->map(function ($subject) use ($classDept){
            $this->getDepartmentSubject($classDept, $subject);
        });
        $this->classRepository->expects($this->any())
            ->method('getClassDepartment')
            ->will($this->returnValue($classDept));
        $result = $this->departmentRepository->getSubjects($school, $class, $department);
        $this->assertEquals($amt, $result->count());
        $this->assertInstanceOf(Subject::class, $result->first());
    }

    public function testRemoveSubject(){
        $school = $this->getSchools()->first();
        $class = $this->getClasses()->first();
        $department = $this->getDepartments()->first();
        $subject = $this->getSubjects()->first();
        $sc = $this->getSchoolClass($school, $class);
        $classDept = $this->getClassDepartment($sc, $department);
        $this->getDepartmentSubject($classDept, $subject);
        $this->classRepository->expects($this->any())
            ->method('getClassDepartment')
            ->will($this->returnValue($classDept));
        $result = $this->departmentRepository->removeSubject($school, $class, $department, $subject);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('department_subject', ['class_department_id' => $classDept->id, 'subject_id' => $subject->getId()]);
    }

    public function testAddUser(){
        $session = $this->getSessions()->first();
        $term = $this->getTerms()->first();
        $school = $this->getSchools()->first();
        $class = $this->getClasses()->first();
        $department = $this->getDepartments()->first();
        $user = $this->getUsers()->first();
        $sessionTerm = $this->createSessionTerm($session, $term);
        $sessionUser = $this->addToSession($user, $sessionTerm);
        $schoolUser = $this->addToSchool($school, $sessionUser);
        $classUser = $this->addToClass($class, $schoolUser);
        $this->classRepository->expects($this->any())
            ->method('getClassUser')
            ->will($this->returnValue($classUser));
        $result = $this->departmentRepository->addUser($user, $school, $class, $department, $session, $term);
        $this->assertTrue($result);
        $this->assertDatabaseHas('department_users', ['class_user_id' => $classUser->id, 'department_id' => $department->getId()]);
    }

    public function testRemoveUser(){
        $session = $this->getSessions()->first();
        $term = $this->getTerms()->first();
        $school = $this->getSchools()->first();
        $class = $this->getClasses()->first();
        $department = $this->getDepartments()->first();
        $user = $this->getUsers()->first();
        $sessionTerm = $this->createSessionTerm($session, $term);
        $sessionUser = $this->addToSession($user, $sessionTerm);
        $schoolUser = $this->addToSchool($school, $sessionUser);
        $classUser = $this->addToClass($class, $schoolUser);
        $this->addToDepartment($department, $classUser);
        $this->classRepository->expects($this->any())
            ->method('getClassUser')
            ->will($this->returnValue($classUser));
        $result = $this->departmentRepository->removeUser($user, $school, $class, $department, $session, $term);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('department_users', ['class_user_id' => $classUser->id, 'department_id' => $department->getId()]);
    }

    public function testGetUsers(){
        $amt = 5;
        $session = $this->getSessions()->first();
        $term = $this->getTerms()->first();
        $school = $this->getSchools()->first();
        $class = $this->getClasses()->first();
        $department = $this->getDepartments()->first();
        $sessionTerm = $this->createSessionTerm($session, $term);
        $users = $this->getUsers($amt);
        $users->map(function ($user) use($sessionTerm, $school, $class, $department){
            $sessionUser = $this->addToSession($user, $sessionTerm);
            $schoolUser = $this->addToSchool($school, $sessionUser);
            $classUser = $this->addToClass($class, $schoolUser);
            $this->addToDepartment($department, $classUser);
        });
        $result = $this->departmentRepository->getUsers($school, $class, $department, $session, $term);
        $this->assertEquals($amt, $result->count());
    }

    private function getSchoolClass($school, $class){
        return SchoolClass::create(['school_id' => $school->getId(), 'class_id' => $class->getId()]);
    }

    private function getClassDepartment($schoolClass, $department){
        return ClassDepartment::create(['department_id' => $department->getId(), 'school_class_id' => $schoolClass->id]);
    }

    private function getDepartmentSubject($classDept, $subject){
        return DepartmentSubject::create(['subject_id' => $subject->getId(), 'class_department_id' => $classDept->id]);
    }
}
