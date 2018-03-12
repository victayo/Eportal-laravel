<?php
/**
 * Created by PhpStorm.
 * User: mighty
 * Date: 3/12/2018
 * Time: 5:22 PM
 */

namespace Eportal\Repositories\ClassRepositories;


use Eportal\Models\PropertyValue;

interface PropertyRepositoryInterface
{
    public function addDepartment(PropertyValue $school, PropertyValue $class, PropertyValue $department);

    public function addSubject(PropertyValue $school, PropertyValue $class, PropertyValue $subject);

    public function getSchools(PropertyValue $class);

    public function getDepartments(PropertyValue $school, PropertyValue $class);

    public function getSubjects(PropertyValue $school, PropertyValue $class);

    public function hasDepartment(PropertyValue $school, PropertyValue $class, PropertyValue $department);

    public function hasSubject(PropertyValue $school, PropertyValue $class, PropertyValue $subject);

    public function removeSubject(PropertyValue $school, PropertyValue $class, PropertyValue $subject);

    public function removeDepartment(PropertyValue $school, PropertyValue $department);
}