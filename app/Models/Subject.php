<?php

namespace Eportal\Models;


class Subject extends AbstractProperty
{
    public static function users(School $school, EportalClass $class, Department $department, Subject $subject, Session $session, Term $term)
    {
        return Department::users($school, $class, $department, $session, $term)
            ->join('subject_users', 'subject_users.department_user_id', '=', 'department_users.id')
            ->where('subject_id', $subject->getId());
    }
}
