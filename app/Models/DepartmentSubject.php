<?php

namespace Eportal\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentSubject extends Model
{
    protected $fillable = ['class_department_id', 'subject_id'];
    protected $table = 'department_subject';

    public function scopeSubjects($query, School $school, EportalClass $class, Department $department){
        return $query->join('class_department', 'class_department.id', '=', 'class_department_id')
            ->join('school_class', 'school_class.id', '=', 'class_department.school_class_id')
            ->join('subjects', 'subjects.id', '=', 'subject_id')
            ->where('school_class.school_id', $school->getId())
            ->where('school_class.class_id', $class->getId())
            ->where('class_department.department_id', $department->getId())
            ->select('subjects.*')
            ->orderBy('subjects.name');
    }
}
