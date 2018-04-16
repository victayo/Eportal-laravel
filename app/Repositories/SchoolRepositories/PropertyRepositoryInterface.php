<?php
/**
 * Created by PhpStorm.
 * User: mighty
 * Date: 3/12/2018
 * Time: 2:37 PM
 */

namespace Eportal\Repositories\SchoolRepositories;


use Eportal\Models\PropertyValue;

interface PropertyRepositoryInterface
{
    public function getClasses(PropertyValue $school);

    public function addClass(PropertyValue $school, PropertyValue $class);

    public function removeClass(PropertyValue $school, PropertyValue $class);

    public function hasClass(PropertyValue $school, PropertyValue $class);
}