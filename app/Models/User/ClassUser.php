<?php

namespace Eportal\Models\User;

use Eportal\Models\EportalClass;
use Eportal\Models\School;
use Eportal\Models\Session;
use Eportal\Models\Term;
use Illuminate\Database\Eloquent\Model;

class ClassUser extends Model
{
    protected $fillable = ['school_user_id', 'class_id'];

    public function scopeUsers($query, School $school, EportalClass $class, Session $session, Term $term)
    {
        return $query->join('school_users', 'school_users.id', '=', 'school_user_id')
            ->join('session_users', 'session_users.id', '=', 'school_users.session_user_id')
            ->join('users', 'users.id', '=', 'session_users.users_id')
            ->where('school_users.school_id', $school->getId())
            ->where('class_id', $class->getId())
            ->where('session_users.session_id', $session->getId())
            ->where('session_users.term_id', $term->getId())
            ->select('users.*');
    }

    public static function users(School $school, EportalClass $class, Session $session, Term $term)
    {
        return SchoolUser::users($school, $session, $term)
            ->join('class_users', 'class_users.school_user_id', '=', 'school_users.id')
            ->where('class_id', $class->getId());
    }
}
