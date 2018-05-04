<?php

namespace Eportal\Models;

use Eportal\Models\User\ClassUser;

class Department extends AbstractProperty
{
    const DEPARTMENT_DEFAULT = 'default';

    public static function users(School $school, EportalClass $class, Department $department, Session $session, Term $term)
    {
        return EportalClass::users($school, $class, $session, $term)
            ->join('department_users', 'department_users.class_user_id', '=', 'class_users.id')
            ->where('department_id', $department->getId());
    }
}
