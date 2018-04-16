<?php

namespace Eportal\Models;


class EportalClass extends AbstractProperty
{
    public static function users(School $school, EportalClass $class, Session $session, Term $term)
    {
        return School::users($school, $session, $term)
            ->join('class_users', 'class_users.school_user_id', '=', 'school_users.id')
            ->where('class_id', $class->getId());
    }
}
