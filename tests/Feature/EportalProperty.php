<?php

namespace Tests\Feature;

use Eportal\Models\Department;
use Eportal\Models\EportalClass;
use Eportal\Models\School;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function factory;

abstract class EportalProperty extends TestCase {

    use RefreshDatabase;

    protected $school;
    protected $class;
    protected $department;

    public function getSchool() {
        if (!$this->school) {
            $this->school = factory(School::class)->create();
        }
        return $this->school;
    }

    public function getClass() {
        if (!$this->class) {
            $this->class = factory(EportalClass::class)->create();
        }
        return $this->class;
    }

    public function getDepartment() {
        if (!$this->department) {
            $this->department = factory(Department::class)->create();
        }
        return $this->department;
    }

}
