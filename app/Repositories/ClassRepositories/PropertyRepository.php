<?php
/**
 * Created by PhpStorm.
 * User: mighty
 * Date: 3/12/2018
 * Time: 5:28 PM
 */

namespace Eportal\Repositories\ClassRepositories;


use Eportal\Models\Property;
use Eportal\Models\PropertyValue;
use Eportal\Models\RelPropertyValue;
use Illuminate\Support\Facades\DB;

class PropertyRepository implements PropertyRepositoryInterface
{
    private $pvTable;

    private $relPvTable;

    private $propertyTable;

    public function __construct()
    {
        $this->pvTable = env("PROPERTY_VALUE_TABLE");
        $this->relPvTable = env("REL_PROPERTY_VALUE_TABLE");
        $this->propertyTable = env("PROPERTY_TABLE");
    }

    public function addDepartment(PropertyValue $school, PropertyValue $class, PropertyValue $department)
    {
        if ($this->hasDepartment($school, $class, $department)) {
            return null;
        }
        $schClass = $this->getRelPropertyValue($school, $class);
        if (!$schClass) { //$class has not being added to $school
            return null;
        }
        $rpv = RelPropertyValue::create([
            'property_value' => $department->id,
            'parent' => $schClass
        ]);
        return $rpv;
    }

    public function addSubject(PropertyValue $school, PropertyValue $class, PropertyValue $subject)
    {
        $deptProp = Property::where('name', 'department')->first();
        $department = PropertyValue::where(['property_id' => $deptProp->id], ['name' => 'general'])->first();
        if (!$this->hasDepartment($school, $class, $department)) {
            $subParent = $this->addDepartment($school, $class, $department)->id;
        } else {
            $subParent = $this->getDeptRpv($school, $class, $department);
        }
        return RelPropertyValue::create([
            'property_value' => $subject->id,
            'parent' => $subParent
        ]);
    }

    public function getSchools(PropertyValue $class)
    {
        $schools = $this->getRelTable('school')
            ->leftjoin($this->relPvTable . ' as class', 'class.parent', '=', 'school.id')
            ->join($this->pvTable . ' as schools', 'schools.id', '=', 'school.property_value')
            ->join($this->propertyTable . ' as prop', 'prop.id', '=', 'schools.property_id')
            ->where(['property.name' => 'school'], ['class.property_value' => $class->id])
            ->select('schools.*')
            ->get();
        $colSchools = $schools->map(function($school){
            $pv = new PropertyValue();
            $pv->fill((array)$school);
            return $pv;
        });
        return collect($colSchools);
    }

    public function getDepartments(PropertyValue $school, PropertyValue $class)
    {
        // TODO: Implement getDepartments() method.
    }

    public function getSubjects(PropertyValue $school, PropertyValue $class)
    {
        // TODO: Implement getSubjects() method.
    }

    public function removeSubject(PropertyValue $school, PropertyValue $class, PropertyValue $subject)
    {
        // TODO: Implement removeSubject() method.
    }

    public function removeDepartment(PropertyValue $school, PropertyValue $department)
    {
        // TODO: Implement removeDepartment() method.
    }

    protected function getRelPropertyValue($school, $class)
    {
        return $this->getRelTable('school')
            ->join($this->relPvTable . ' as class', 'class.parent', '=', 'school.id')
            ->where(['school.property_value' => $school], ['class.property_value' => $class])
            ->select('class.id')
            ->first();
    }

    protected function getDeptRpv($school, $class, $department)
    {
        return $this->getRelTable('school')
            ->leftjoin($this->relPvTable . ' as class', 'class.parent', '=', 'school.id')
            ->leftjoin($this->relPvTable . ' as department', 'department.parent', '=', 'class.id')
            ->where(
                ['school.property_value' => $school->id],
                ['class.property_value' => $class->id],
                ['department.property_value' => $department->id]
            )
            ->select('department.id')
            ->first();
    }

    protected function getRelTable($alias = null)
    {
        if ($alias) {
            return DB::table($this->relPvTable . ' as ' . $alias);
        }
        return DB::table($this->relPvTable);
    }

    public function hasDepartment(PropertyValue $school, PropertyValue $class, PropertyValue $department)
    {
        // TODO: Implement hasDepartment() method.
    }

    public function hasSubject(PropertyValue $school, PropertyValue $class, PropertyValue $subject)
    {
        // TODO: Implement hasSubject() method.
    }
}