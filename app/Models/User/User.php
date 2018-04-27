<?php

namespace Eportal\Models\User;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property mixed $session_terms
 */
class User extends Authenticatable
{
    const USER_STUDENT = 'student';
    const USER_TEACHER = 'teacher';

    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'first_name', 'last_name', 'middle_name', 'username', 'gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function getId(){
        return $this->id;
    }

    public function sessionTerms(){
        return $this->belongsTo(SessionUser::class);
    }
}
