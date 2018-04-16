<?php


namespace Eportal\Repositories\School;

use Eportal\Models\EportalClass;
use Eportal\Models\School;
use Eportal\Models\Session;
use Eportal\Models\Term;
use Eportal\Models\User\SchoolUser;
use Eportal\Models\User\User;
use Illuminate\Support\Collection;

/**
 *
 * @author OKALA
 */
interface SchoolRepositoryInterface {

    /**
     * @param $id
     * @return School
     */
    public function findById($id);

    /**
     * @param $name
     * @return School
     */
    public function findByName($name);

    /**
     * @param array $attributes
     * @return School|null
     */
    public function create(array $attributes);

    /**
     * @param School $school
     * @param array $attributes
     * @return bool
     */
    public function update(School $school, array $attributes);

    /**
     * @param School $school
     * @return bool
     */
    public function delete(School $school);

    /**
     * @return Collection
     */
    public function getSchools();

    /**
     * @param School $school
     * @return Collection
     */
    public function getClasses(School $school);

    /**
     * @param School $school
     * @return Collection
     */
    public function getUnaddedClasses(School $school);

    /**
     * @param School $school
     * @param EportalClass $class
     * @return bool
     */
    public function addClass(School $school, EportalClass $class);

    /**
     * @param School $school
     * @param array $classes
     * @return int
     */
    public function addClasses(School $school, array $classes);

    /**
     * @param School $school
     * @param EportalClass $class
     * @return bool
     */
    public function removeClass(School $school, EportalClass $class);

    /**
     * @param School $school
     * @param array $classes
     * @return int
     */
    public function removeClasses(School $school, array $classes);

    /**
     * @param School $school
     * @param EportalClass $class
     * @return bool
     */
    public function hasClass(School $school, EportalClass $class);

    /**
     * @param User $user
     * @param School $school
     * @param Session $session
     * @param Term $term
     * @return bool
     */
    public function addUser(User $user, School $school, Session $session, Term $term);

    /**
     * @param School $school
     * @param Session $session
     * @param Term $term
     * @return Collection
     */
    public function getUsers(School $school, Session $session, Term $term);

    /**
     * @param User $user
     * @param School $school
     * @param Session $session
     * @param Term $term
     * @return bool
     */
    public function removeUser(User $user, School $school, Session $session, Term $term);

    /**
     * @param User $user
     * @param School $school
     * @param Session $session
     * @param Term $term
     * @return SchoolUser
     */
    public function getSchoolUser(User $user, School $school, Session $session, Term $term);
}
