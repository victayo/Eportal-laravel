<?php

namespace Tests\Feature\Repositories\School;

use Eportal\Models\EportalClass;
use Eportal\Models\School;
use Eportal\Models\SchoolClass;
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
        factory(School::class, $amt)->create();
        $result = $this->schoolRepository->getSchools();
        $this->assertEquals($amt, $result->count());
    }

    public function testGetClasses() {
        $school = $this->getSchool();
        $amt = 5;
        $classes = factory(EportalClass::class, $amt)->create();
        foreach ($classes as $class) {
            SchoolClass::create(['school_id' => $school->getId(), 'class_id' => $class->getId()]);
        }
        $result = $this->schoolRepository->getClasses($school);
        $this->assertEquals($amt, $result->count());
    }

    public function testHasClass() {
        $school = $this->getSchool();
        $class = $this->getClass();
        $result = $this->schoolRepository->hasClass($school, $class);
        $this->assertFalse($result);
        SchoolClass::create(['school_id' => $school->getId(), 'class_id' => $class->getId()]);
        $result = $this->schoolRepository->hasClass($school, $class);
        $this->assertTrue($result);
    }

    public function testAddClass() {
        $school = $this->getSchool();
        $class = $this->getClass();
        $result = $this->schoolRepository->addClass($school, $class);
        $this->assertTrue($result);
        $this->assertDatabaseHas('school_class', ['school_id' => $school->getId(), 'class_id' => $class->getId()]);
    }

}
