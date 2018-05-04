<?php

namespace Eportal\Models\User;

use Eportal\Models\School;
use Eportal\Models\Session;
use Eportal\Models\Term;
use Illuminate\Database\Eloquent\Model;

class SessionUser extends Model
{
    protected $fillable = ['user_id', 'session_term_id'];

    public function scopeUsers($query, Session $session, Term $term){
        return $query->join('session_term', 'session_term.id', '=', 'session_term_id')
            ->join('users', 'users.id', '=', 'user_id')
            ->where('session_id', $session->getId())
            ->where('term_id', $term->getId())
            ->select('users.*');
    }

    public function schools(){
        return $this->belongsToMany(School::class, 'school_users');
    }
}
