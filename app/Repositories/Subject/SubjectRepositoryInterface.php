<?php


namespace Eportal\Repositories\Subject;

use Eportal\Models\Department;
use Eportal\Models\EportalClass;
use Eportal\Models\School;
use Eportal\Models\Session;
use Eportal\Models\Subject;
use Eportal\Models\Term;
use Eportal\Models\User\SubjectUser;
use Eportal\Models\User\User;
use Illuminate\Database\Eloquent\Collection;

/**
 *
 * @author OKALA
 */
interface SubjectRepositoryInterface
{

    /**
     * @param $name
     * @return Subject|null
     */
    public function findByName($name);

    /**
     * @param $id
     * @return Subject|null
     */
    public function findById($id);

    /**
     * @param array $attributes
     * @return Subject
     */
    public function create(array $attributes);

    /**
     * @param Subject $subject
     * @param array $attributes
     * @return bool
     */
    public function update(Subject $subject, array $attributes);


    /**
     * @param Subject $subject
     * @return bool
     */
    public function delete(Subject $subject);

    /**
     * @return Collection
     */
    public function getSubjects();

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Subject $subject
     * @param Session $session
     * @param Term $term
     * @return bool
     */
    public function hasUser(User $user, School $school, EportalClass $class, Department $department, Subject $subject, Session $session, Term $term);

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Subject $subject
     * @param Session $session
     * @param Term $term
     * @return bool
     */
    public function addUser(User $user, School $school, EportalClass $class, Department $department, Subject $subject, Session $session, Term $term);

    /**
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Subject $subject
     * @param Session $session
     * @param Term $term
     * @return Collection
     */
    public function getUsers(School $school, EportalClass $class, Department $department, Subject $subject, Session $session, Term $term);

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Subject $subject
     * @param Session $session
     * @param Term $term
     * @return bool
     */
    public function removeUser(User $user, School $school, EportalClass $class, Department $department, Subject $subject, Session $session, Term $term);

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Subject $subject
     * @param Session $session
     * @param Term $term
     * @return SubjectUser
     */
    public function getSubjectUser(User $user, School $school, EportalClass $class, Department $department, Subject $subject, Session $session, Term $term);
}
