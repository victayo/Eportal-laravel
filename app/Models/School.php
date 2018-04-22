<?php

namespace Eportal\Models;

use Eportal\Models\User\SessionUser;

class School extends AbstractProperty
{

    public static function users(School $school, Session $session, Term $term){
        return SessionUser::users($session, $term)
            ->join('school_users', 'session_term_users.id', '=', 'session_term_user_id')
            ->where('school_id', $school->getId());
    }
}