<?php

namespace Tests\Feature\Repositories\EportalClass;

use Eportal\Models\ClassDepartment;
use Eportal\Models\SchoolClass;
use Eportal\Repositories\EportalClass\ClassRepository;
use Eportal\Repositories\School\SchoolRepository;
use Tests\Feature\EportalProperty;
use Tests\TestCase;

class ClassRepositoryTest extends EportalProperty {

    protected $classRepository;
    protected $schoolRepository;

    public function setUp() {
        parent::setUp();
        $this->schoolRepository = $this->getMockBuilder(SchoolRepository::class)
                ->getMock();
        $this->classRepository = new ClassRepository();
        $this->classRepository->setSchoolRepository($this->schoolRepository);
    }

    public function testAddDepartment() {
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

    public function testHasDepartmentReturnFalse(){
        $school = $this->getSchools()->first();
        $class = $this->getClasses()->first();
        $department = $this->getDepartments()->first();
        $this->schoolRepository->expects($this->once())
                ->method('getSchoolClass')
                ->will($this->returnValue(null));
        $result = $this->classRepository->hasDepartment($school, $class, $department);
        $this->assertFalse($result);
    }
    
    public function testHasDepartmentReturnTrue(){
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
    
    public function testRemoveDepartment(){
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
    
    public function testGetUsers(){

    }
}
