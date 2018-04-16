<?php


namespace Eportal\Repositories\Subject;

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
interface SubjectRepositoryInterface {
    public function findByName($name);

    public function findById($id);

    public function create(array $attributes);

    public function update(Subject $subject, array $attributes);

    public function delete(Subject $subject);

    public function getSubjects();

    public function addUser(User $user, School $school, EportalClass $class, Department $department, Subject $subject, Session $session, Term $term);

    public function getUsers(School $school, EportalClass $class, Department $department, Subject $subject,  Session $session, Term $term);

    public function removeUser(User $user, School $school, EportalClass $class, Department $department, Subject $subject,  Session $session, Term $term);

    public function getSubjectUser(User $user, School $school, EportalClass $class, Department $department, Subject $subject,  Session $session, Term $term);
}
