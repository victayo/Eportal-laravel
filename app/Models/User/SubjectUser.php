<?php

namespace Eportal\Models\User;

use Eportal\Models\Department;
use Eportal\Models\EportalClass;
use Eportal\Models\School;
use Eportal\Models\Session;
use Eportal\Models\Subject;
use Eportal\Models\Term;
use Illuminate\Database\Eloquent\Model;

class SubjectUser extends Model
{
    protected $fillable = ['department_user_id', 'subject_id'];

    public function scopeUsers($query, School $school, EportalClass $class, Department $department, Subject $subject, Session $session, Term $term)
    {
        return $query->join('department_users', 'department_users.id', '=', 'department_user_id')
            ->join('class_users', 'class_users.id', '=', 'department_users.class_user_id')
            ->join('school_users', 'school_users.id', '=', 'class_users.school_user_id')
            ->join('session_users', 'session_users.id', '=', 'school_users.session_user_id')
            ->join('session', 'session.id', '=', 'session_users.session_id')
            ->join('users', 'users.id', '=', 'session_users.users_id')
            ->where('school_users.school_id', $school->getId())
            ->where('class_id', $class->getId())
            ->where('department_id', $department->getId())
            ->where('subject_id', $subject->getId())
            ->where('session.session_id', $session->getId())
            ->where('session.term_id', $term->getId())
            ->select('users.*');
    }

    public static function users(School $school, EportalClass $class, Department $department, Subject $subject, Session $session, Term $term)
    {
        return DepartmentUser::users($school, $class, $department, $session, $term)
            ->join('subject_users', 'subject_users.department_user_id', '=', 'department_users.id')
            ->where('subject_id', $subject->getId());
    }
}
