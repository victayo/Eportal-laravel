<?php

namespace Eportal\Models;

class Session extends AbstractProperty
{
    public function terms(){
        return $this->belongsToMany(Term::class, 'session_term');
    }
}
