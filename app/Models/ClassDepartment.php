<?php

namespace Eportal\Models;

use Illuminate\Database\Eloquent\Model;

class ClassDepartment extends Model
{
    protected $fillable = ['school_class_id', 'department_id'];
    
    protected $table = 'class_department';

    public function scopeDepartments($query, School $school, EportalClass $class){
        return $query->join('school_class', 'school_class.id', '=', 'school_class_id')
            ->join('departments', 'departments.id', '=', 'department_id')
            ->where('school_id', $school->getId())
            ->where('class_id', $class->getId())
            ->select('departments.*')
            ->orderBy('departments.name');
    }

    public function subjects(){
        return $this->belongsToMany(Subject::class, 'department_subject');
    }
}
