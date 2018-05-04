<?php

namespace Eportal\Models;

use Eportal\Models\User\SessionUser;

class School extends AbstractProperty
{

    public static function users(School $school, Session $session, Term $term){
        return SessionUser::users($session, $term)
            ->join('school_users', 'session_users.id', '=', 'session_user_id')
            ->where('school_id', $school->getId());
    }

    public function classes(){
        return $this->belongsToMany(EportalClass::class, 'school_class', 'school_id', 'class_id');
    }
}
