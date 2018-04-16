<?php

namespace Eportal\Repositories\EportalClass;

use Eportal\Models\Department;
use Eportal\Models\EportalClass;
use Eportal\Models\School;
use Eportal\Models\Session;
use Eportal\Models\Term;
use Eportal\Models\User\User;

/**
 *
 * @author OKALA
 */
interface ClassRepositoryInterface {

    public function getClasses();

    public function findByName($name);

    public function findById($id);

    public function create(array $attributes);

    public function update(EportalClass $class, array $attributes);

    public function delete(EportalClass $class);

    public function getDepartments(School $school, EportalClass $class);

    public function addDepartment(School $school, EportalClass $class, Department $departments);

    public function removeDepartment(School $school, EportalClass $class, Department $department);

    public function hasDepartment(School $school, EportalClass $class, Department $department);

    public function addUser(User $user, School $school, EportalClass $class, Session $session, Term $term);

    public function getUsers(School $school, EportalClass $class, Session $session, Term $term);

    public function removeUser(User $user, School $school, EportalClass $class, Session $session, Term $term);

    public function getClassUser(User $user, School $school, EportalClass $class, Session $session, Term $term);
}
