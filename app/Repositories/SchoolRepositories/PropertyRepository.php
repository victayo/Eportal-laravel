<?php
/**
 * Created by PhpStorm.
 * User: mighty
 * Date: 3/12/2018
 * Time: 2:36 PM
 */

namespace Eportal\Repositories\SchoolRepositories;


use Eportal\Models\PropertyValue;
use Illuminate\Support\Facades\DB;

class PropertyRepository implements PropertyRepositoryInterface
{
    private $pvTable;

    private $relPvTable;

    public function __construct()
    {
        $this->pvTable = env("PROPERTY_VALUE_TABLE");
        $this->relPvTable = env("REL_PROPERTY_VALUE_TABLE");
    }

    public function getClasses(PropertyValue $school)
    {
        $classes =$this->getRelTable('school')
            ->leftjoin($this->relPvTable.' as class', 'class.parent', '=', 'school.id')
            ->join($this->pvTable, $this->pvTable.'.id', '=', 'class.property_value')
            ->where('school.property_value', $school->id)
            ->select($this->pvTable.'.*')
            ->get();
       $colClasses = $classes->map(function($class){
           $pv = new PropertyValue();
           $pv->fill((array)$class);
           return $pv;
       });
       return collect($colClasses);
    }

    public function addClass(PropertyValue $school, PropertyValue $class)
    {
        if($this->hasClass($school, $class)){
            return false;
        }
        $rpvId = $this->getRelPropertyValue($school->id);
        if(!$rpvId){ //school has not been added to rel_property_value_table. Add
            $rpvId = $this->getRelTable()->insertGetId([
                    'property_value' => $school->id,
                    'parent' => null
                ]);
        }
        $this->getRelTable()->insert([
            'property_value' => $school->id,
            'parent' => $rpvId
        ]);
        return true;
    }

    public function removeClass(PropertyValue $school, PropertyValue $class)
    {
        if(!$this->hasClass($school, $class)){
            return false;
        }
        $rpvId = $this->getRelPropertyValue($school);
        $this->getRelTable()->where(
            ['property_value' => $class->id],
            ['parent' => $rpvId]
            )
            ->delete();
        return true;
    }

    public function hasClass(PropertyValue $school, PropertyValue $class)
    {
        $hasClass = $this->getRelTable('school')
            ->leftjoin($this->relPvTable.' as class', 'class.parent', '=', 'school.id')
            ->where(['school.property_value' => $school->id], ['class.property_value' => $class->id])
            ->first();
        return boolval($hasClass);
    }

    protected function getRelPropertyValue($school){
        return DB::table($this->relPvTable)
            ->where('property_value', $school)
            ->whereNull('parent')
            ->select('id')
            ->first();
    }

    protected function getRelTable($alias = null){
        if($alias){
            return  DB::table($this->relPvTable.' as '.$alias);
        }
        return  DB::table($this->relPvTable);
    }
}