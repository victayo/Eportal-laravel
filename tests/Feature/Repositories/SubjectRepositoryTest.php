<?php

namespace Tests\Feature\Repositories;

use Eportal\Repositories\Department\DepartmentRepository;
use Eportal\Repositories\Subject\SubjectRepository;
use Eportal\Repositories\Subject\SubjectRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Feature\EportalProperty;

class SubjectRepositoryTest extends EportalProperty
{
    /**
     * @var MockObject
     */
    protected $departmentRepository;

    /**
     * @var SubjectRepositoryInterface
     */
    protected $subjectRepository;

    public function setUp()
    {
        parent::setUp();
        $this->departmentRepository = $this->getMockBuilder(DepartmentRepository::class)->getMock();
        $this->subjectRepository = new SubjectRepository();
        $this->subjectRepository->setDepartmentRepository($this->departmentRepository);
    }

    public function testAddUser()
    {
        $session = $this->getSessions()->first();
        $term = $this->getTerms()->first();
        $school = $this->getSchools()->first();
        $class = $this->getClasses()->first();
        $department = $this->getDepartments()->first();
        $subject = $this->getSubjects()->first();
        $user = $this->getUsers()->first();
        $sessionTerm = $this->createSessionTerm($session, $term);
        $sessionUser = $this->addToSession($user, $sessionTerm);
        $schoolUser = $this->addToSchool($school, $sessionUser);
        $classUser = $this->addToClass($class, $schoolUser);
        $deptUser = $this->addToDepartment($department, $classUser);
        $this->departmentRepository->expects($this->any())
            ->method('getDepartmentUser')
            ->will($this->returnValue($deptUser));
        $result = $this->subjectRepository->addUser($user, $school, $class, $department, $subject, $session, $term);
        $this->assertTrue($result);
        $this->assertDatabaseHas('subject_users', ['subject_id' => $subject->getId(), 'department_user_id' => $deptUser->id]);
        $result = $this->subjectRepository->removeUser($user, $school, $class, $department, $subject, $session, $term);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('subject_users', ['subject_id' => $subject->getId(), 'department_user_id' => $deptUser->id]);
    }

    public function testRemoveUser(){
        $session = $this->getSessions()->first();
        $term = $this->getTerms()->first();
        $school = $this->getSchools()->first();
        $class = $this->getClasses()->first();
        $department = $this->getDepartments()->first();
        $subject = $this->getSubjects()->first();
        $user = $this->getUsers()->first();
        $sessionTerm = $this->createSessionTerm($session, $term);
        $sessionUser = $this->addToSession($user, $sessionTerm);
        $schoolUser = $this->addToSchool($school, $sessionUser);
        $classUser = $this->addToClass($class, $schoolUser);
        $deptUser = $this->addToDepartment($department, $classUser);
        $this->addToSubject($subject, $deptUser);
        $this->departmentRepository->expects($this->any())
            ->method('getDepartmentUser')
            ->will($this->returnValue($deptUser));
        $result = $this->subjectRepository->removeUser($user, $school, $class, $department, $subject, $session, $term);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('subject_users', ['subject_id' => $subject->getId(), 'department_user_id' => $deptUser->id]);
    }

    public function testGetUsers(){
        $amt = 5;
        $session = $this->getSessions()->first();
        $term = $this->getTerms()->first();
        $school = $this->getSchools()->first();
        $class = $this->getClasses()->first();
        $department = $this->getDepartments()->first();
        $subject = $this->getSubjects()->first();
        $sessionTerm = $this->createSessionTerm($session, $term);
        $users = $this->getUsers($amt);
        $users->map(function ($user) use($sessionTerm, $school, $class, $department, $subject){
            $sessionUser = $this->addToSession($user, $sessionTerm);
            $schoolUser = $this->addToSchool($school, $sessionUser);
            $classUser = $this->addToClass($class, $schoolUser);
            $deptUser = $this->addToDepartment($department, $classUser);
            $this->addToSubject($subject, $deptUser);
        });
        $result = $this->subjectRepository->getUsers($school, $class, $department, $subject, $session, $term);
        $this->assertEquals($amt, $result->count());
    }
}
