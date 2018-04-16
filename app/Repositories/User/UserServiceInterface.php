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

interface UserServiceInterface
{
    public function findById($id);

    public function createUser(array $attributes);

    public function registerStudent(array $userAttributes, Session $session, Term $term, School $school, EportalClass $class, Department $department, Subject $subject);
}