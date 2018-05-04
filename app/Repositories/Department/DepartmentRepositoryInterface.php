<?php

namespace Eportal\Repositories\Department;

use Eportal\Models\Department;
use Eportal\Models\EportalClass;
use Eportal\Models\School;
use Eportal\Models\Session;
use Eportal\Models\Subject;
use Eportal\Models\Term;
use Eportal\Models\User\DepartmentUser;
use Eportal\Models\User\User;
use Illuminate\Database\Eloquent\Collection;

/**
 *
 * @author OKALA
 */
interface DepartmentRepositoryInterface {

    /**
     * @param $name
     * @return Department|null
     */
    public function findByName($name);

    /**
     * @param $id
     * @return Department|null
     */
    public function findById($id);

    /**
     * @param array $attributes
     * @return Department|null
     */
    public function create(array $attributes);

    /**
     * @param Department $department
     * @param array $attributes
     * @return bool
     */
    public function update(Department $department, array $attributes);

    /**
     * @param Department $department
     * @return bool
     */
    public function delete(Department $department);

    /**
     * @return Collection
     */
    public function getDepartments();

    /**
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Subject $subject
     * @return bool
     */
    public function addSubject(School $school, EportalClass $class, Department $department, Subject $subject);

    /**
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param array $subjects
     * @return int
     */
    public function addSubjects(School $school, EportalClass $class, Department $department, array $subjects);

    /**
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Subject $subject
     * @return bool
     */
    public function removeSubject(School $school, EportalClass $class, Department $department, Subject $subject);

    /**
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param array $subjects
     * @return int
     */
    public function removeSubjects(School $school, EportalClass $class, Department $department, array $subjects);

    /**
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @return Collection
     */
    public function getUnaddedSubjects(School $school, EportalClass $class, Department $department);

    /**
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Subject $subject
     * @return bool
     */
    public function hasSubject(School $school, EportalClass $class, Department $department, Subject $subject);

    /**
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @return Collection
     */
    public function getSubjects(School $school, EportalClass $class, Department $department);

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Session $session
     * @param Term $term
     * @return bool
     */
    public function addUser(User $user, School $school, EportalClass $class, Department $department, Session $session, Term $term);

    /**
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Session $session
     * @param Term $term
     * @return Collection
     */
    public function getUsers(School $school, EportalClass $class, Department $department, Session $session, Term $term);

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Session $session
     * @param Term $term
     * @return bool
     */
    public function removeUser(User $user, School $school, EportalClass $class, Department $department, Session $session, Term $term);

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Session $session
     * @param Term $term
     * @return DepartmentUser
     */
    public function getDepartmentUser(User $user, School $school, EportalClass $class, Department $department, Session $session, Term $term);
}
