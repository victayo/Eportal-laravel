<?php

namespace Eportal\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $fillable = ['school_id', 'class_id'];
    protected $table = 'school_class';

    public function scopeClasses($query, School $school){
        return $query->join('eportal_classes', 'eportal_classes.id', '=', 'class_id')
                ->where('school_id', $school->getId())
                ->select('eportal_classes.*')
                ->orderBy('eportal_classes.name');
    }
    
    public function scopeSchools($query, EportalClass $class){
        return $query->join('schools', 'schools.id', '=', 'school_id')
                ->where('class_id', $class->getId())
                ->select('schools.*')
                ->orderBy('schools.name');
    }
}
