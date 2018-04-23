<?php

namespace Eportal\Repositories\Department;

use Eportal\Models\Department;
use Eportal\Models\EportalClass;
use Eportal\Models\School;
use Eportal\Models\Session;
use Eportal\Models\Subject;
use Eportal\Models\Term;
use Eportal\Models\User\User;

/**
 *
 * @author OKALA
 */
interface DepartmentRepositoryInterface {

    public function findByName($name);

    public function findById($id);

    public function create(array $attributes);

    public function update(Department $department, array $attributes);

    public function delete(Department $department);

    public function getDepartments();

    public function addSubject(School $school, EportalClass $class, Department $department, Subject $subject);

    public function addSubjects(School $school, EportalClass $class, Department $department, array $subjects);

    public function removeSubject(School $school, EportalClass $class, Department $department, Subject $subject);

    public function removeSubjects(School $school, EportalClass $class, Department $department, array $subjects);

    public function getUnaddedSubjects(School $school, EportalClass $class, Department $department);

    public function hasSubject(School $school, EportalClass $class, Department $department, Subject $subject);

    public function getSubjects(School $school, EportalClass $class, Department $department);

    public function addUser(User $user, School $school, EportalClass $class, Department $department, Session $session, Term $term);

    public function getUsers(School $school, EportalClass $class, Department $department, Session $session, Term $term);

    public function removeUser(User $user, School $school, EportalClass $class, Department $department, Session $session, Term $term);

    public function getDepartmentUser(User $user, School $school, EportalClass $class, Department $department, Session $session, Term $term);
}
