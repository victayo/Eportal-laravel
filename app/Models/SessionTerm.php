<?php

namespace Eportal\Models;

use Eportal\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class SessionTerm extends Model
{
    protected $fillable = ['session_id', 'term_id'];
    protected $table = 'session_term';



    public function scopeTerms($query, Session $session){
        return $query->where('session_id', $session->getId())
                ->join('terms', 'terms.id', '=', 'term_id')
                ->select('terms.*')
                ->orderBy('terms.name');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'session_term_users');
    }
}
