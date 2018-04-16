<?php

namespace Eportal\Models\User;

use Eportal\Models\Department;
use Eportal\Models\EportalClass;
use Eportal\Models\School;
use Eportal\Models\Session;
use Eportal\Models\Term;
use Illuminate\Database\Eloquent\Model;

class DepartmentUser extends Model
{
    protected $fillable = ['class_user_id', 'department_id'];

    public function scopeUsers($query, School $school, EportalClass $class, Department $department, Session $session, Term $term)
    {
        return $query->join('class_users', 'class_users.id', '=', 'class_user_id')
            ->join('school_users', 'school_users.id', '=', 'class_users.school_user_id')
            ->join('session_users', 'session_users.id', '=', 'school_users.session_user_id')
            ->join('users', 'users.id', '=', 'session_users.users_id')
            ->where('school_users.school_id', $school->getId())
            ->where('class_id', $class->getId())
            ->where('department_id', $department->getId())
            ->where('session_users.session_id', $session->getId())
            ->where('session_users.term_id', $term->getId())
            ->select('users.*');
    }

    public static function users(School $school, EportalClass $class, Department $department, Session $session, Term $term)
    {
        return ClassUser::users($school, $class, $session, $term)
            ->join('department_users', 'department_users.class_user_id', '=', 'class_users.id')
            ->where('department_id', $department->getId());
    }
}
