<?php

namespace Eportal\Models\User;

use Eportal\Models\EportalClass;
use Eportal\Models\School;
use Eportal\Models\Session;
use Eportal\Models\Term;
use Illuminate\Database\Eloquent\Model;

class SchoolUser extends Model
{
    protected $fillable = ['session_user_id', 'school_id'];

    public function scopeUsers($query, School $school, Session $session, Term $term)
    {
        return $query->join('session_users', 'session_users.id', '=', 'session_user_id')
            ->join('users', 'users.id', '=', 'users_id')
            ->where('school_id', $school->getId())
            ->where('session_id', $session->getId())
            ->where('term_id', $term->getId())
            ->select('users.*');
    }

    public static function users(School $school, Session $session, Term $term)
    {
        return SessionUser::users($session, $term)
            ->join('school_users', 'session_users.id', '=', 'session_user_id')
            ->where('school_id', $school->getId());
    }

    public function eportalClass(){
        return $this->belongsToMany(EportalClass::class, 'class_users', 'school_user_id', 'class_id');
    }
}
