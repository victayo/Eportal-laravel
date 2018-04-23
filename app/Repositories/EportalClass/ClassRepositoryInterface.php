<?php

namespace Eportal\Repositories\EportalClass;

use Eportal\Models\Department;
use Eportal\Models\EportalClass;
use Eportal\Models\School;
use Eportal\Models\Session;
use Eportal\Models\Term;
use Eportal\Models\User\ClassUser;
use Eportal\Models\User\User;
use Illuminate\Database\Eloquent\Collection;

/**
 *
 * @author OKALA
 */
interface ClassRepositoryInterface {

    /**
     * @return Collection
     */
    public function getClasses();

    /**
     * @param $name
     * @return EportalClass|null
     */
    public function findByName($name);

    /**
     * @param $id
     * @return EportalClass|null
     */
    public function findById($id);

    /**
     * @param array $attributes
     * @return EportalClass
     */
    public function create(array $attributes);

    /**
     * @param EportalClass $class
     * @param array $attributes
     * @return bool
     */
    public function update(EportalClass $class, array $attributes);

    /**
     * @param EportalClass $class
     * @return bool
     */
    public function delete(EportalClass $class);

    /**
     * @param School $school
     * @param EportalClass $class
     * @return Collection
     */
    public function getDepartments(School $school, EportalClass $class);

    /**
     * @param School $school
     * @param EportalClass $class
     * @return Collection
     */
    public function getUnaddedDepartments(School $school, EportalClass $class);

    /**
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @return bool
     */
    public function addDepartment(School $school, EportalClass $class, Department $department);

    /**
     * @param School $school
     * @param EportalClass $class
     * @param array $departments
     * @return int
     */
    public function addDepartments(School $school, EportalClass $class, array $departments);

    /**
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @return bool
     */
    public function removeDepartment(School $school, EportalClass $class, Department $department);

    /**
     * @param School $school
     * @param EportalClass $class
     * @param array $departments
     * @return int
     */
    public function removeDepartments(School $school, EportalClass $class, array $departments);

    /**
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @return bool
     */
    public function hasDepartment(School $school, EportalClass $class, Department $department);

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Session $session
     * @param Term $term
     * @return bool
     */
    public function addUser(User $user, School $school, EportalClass $class, Session $session, Term $term);

    /**
     * @param School $school
     * @param EportalClass $class
     * @param Session $session
     * @param Term $term
     * @return Collection
     */
    public function getUsers(School $school, EportalClass $class, Session $session, Term $term);

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Session $session
     * @param Term $term
     * @return bool
     */
    public function removeUser(User $user, School $school, EportalClass $class, Session $session, Term $term);

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Session $session
     * @param Term $term
     * @return ClassUser|null
     */
    public function getClassUser(User $user, School $school, EportalClass $class, Session $session, Term $term);
}
