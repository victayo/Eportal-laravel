<?php

namespace Tests\Feature\Repositories\SchoolRepositories;

use Eportal\Models\Property;
use Eportal\Models\PropertyValue;
use Eportal\Repositories\SchoolRepositories\PropertyRepository;
use Eportal\Repositories\SchoolRepositories\PropertyRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PropertyRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var PropertyRepositoryInterface
     */
    protected $propertyRepository;
    
    public function setUp()
    {
        parent::setUp();
        $this->propertyRepository = new PropertyRepository();
        factory(Property::class)->create();
    }

    public function testHasClass(){
        $school = factory(PropertyValue::class)->create();
        $class = factory(PropertyValue::class)->create();
        $result = $this->propertyRepository->hasClass($school, $class);
        $this->assertFalse($result);
        DB::table(env("REL_PROPERTY_VALUE_TABLE"))->insert(['property_value' => $school->id]);
        DB::table(env("REL_PROPERTY_VALUE_TABLE"))->insert(['property_value' => $class->id, 'parent' => $school->id]);
        $result = $this->propertyRepository->hasClass($school, $class);
        $this->assertTrue($result);
    }

    public function testAddClass(){
        $school = factory(PropertyValue::class)->create();
        $class = factory(PropertyValue::class)->create();
        $result = $this->propertyRepository->addClass($school, $class);
        $this->assertTrue($result);
    }

    public function testGetClasses(){
        $amt = 5;
        $school = factory(PropertyValue::class)->create();
        $classes = factory(PropertyValue::class, $amt)->create();
        DB::table(env("REL_PROPERTY_VALUE_TABLE"))->insert(['property_value' => $school->id]);
        $classes->map(function($class) use($school){
            DB::table(env("REL_PROPERTY_VALUE_TABLE"))->insert(['property_value' => $class->id, 'parent' => $school->id]);
        });
        $result = $this->propertyRepository->getClasses($school);
        $this->assertEquals($amt, count($result));
    }

    public function testRemoveClass(){
        $school = factory(PropertyValue::class)->create();
        $class = factory(PropertyValue::class)->create();
        $result = $this->propertyRepository->removeClass($school, $class);
        $this->assertFalse($result);
        DB::table(env("REL_PROPERTY_VALUE_TABLE"))->insert(['property_value' => $school->id]);
        DB::table(env("REL_PROPERTY_VALUE_TABLE"))->insert(['property_value' => $class->id, 'parent' => $school->id]);
        $result = $this->propertyRepository->removeClass($school, $class);
        $this->assertTrue($result);
    }
}
