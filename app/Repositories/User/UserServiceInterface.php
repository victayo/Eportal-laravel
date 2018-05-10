<?php
/**
 * Created by PhpStorm.
 * User: OKALA
 * Date: 14/04/2018
 * Time: 09:36
 */

namespace Eportal\Repositories\User;


use Eportal\Models\Department;
use Eportal\Models\EportalClass;
use Eportal\Models\School;
use Eportal\Models\Session;
use Eportal\Models\Subject;
use Eportal\Models\Term;
use Eportal\Models\User\User;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface
{
    /**
     * @param $id
     * @return User|null
     */
    public function findById($id);

    /**
     * @param array $attributes
     * @return User|null
     */
    public function createUser(array $attributes);

    /**
     * @param array $userAttributes
     * @param Session $session
     * @param Term $term
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Subject $subject
     * @return User|null
     */
    public function registerStudent(array $userAttributes, Session $session, Term $term, School $school, EportalClass $class, Department $department, Subject $subject);

    /**
     * @param User $user
     * @param Session $session
     * @param Term $term
     * @return Collection
     */
    public function getSchools(User $user, Session $session, Term $term);

    /**
     * @param User $user
     * @param School $school
     * @param Session $session
     * @param Term $term
     * @return Collection
     */
    public function getClasses(User $user, School $school, Session $session, Term $term);

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Session $session
     * @param Term $term
     * @return Collection
     */
    public function getDepartments(User $user, School $school, EportalClass $class, Session $session, Term $term);

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Session $session
     * @param Term $term
     * @return Collection
     */
    public function getSubjects(User $user, School $school, EportalClass $class, Department $department, Session $session, Term $term);
}