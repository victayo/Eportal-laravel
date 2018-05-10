<?php
/**
 * Created by PhpStorm.
 * User: OKALA
 * Date: 14/04/2018
 * Time: 09:41
 */

namespace Eportal\Repositories\User;


use Eportal\Models\Department;
use Eportal\Models\EportalClass;
use Eportal\Models\School;
use Eportal\Models\Session;
use Eportal\Models\Subject;
use Eportal\Models\Term;
use Eportal\Models\User\SchoolUser;
use Eportal\Models\User\User;
use Eportal\Repositories\Department\DepartmentRepository;
use Eportal\Repositories\Department\DepartmentRepositoryInterface;
use Eportal\Repositories\EportalClass\ClassRepository;
use Eportal\Repositories\EportalClass\ClassRepositoryInterface;
use Eportal\Repositories\School\SchoolRepository;
use Eportal\Repositories\School\SchoolRepositoryInterface;
use Eportal\Repositories\Session\SessionRepository;
use Eportal\Repositories\Session\SessionRepositoryInterface;
use Eportal\Repositories\Subject\SubjectRepository;
use Eportal\Repositories\Subject\SubjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class UserService implements UserServiceInterface
{

    /**
     * @var SessionRepositoryInterface
     */
    protected $sessionService;

    /**
     * @var SchoolRepositoryInterface
     */
    protected $schoolService;

    /**
     * @var ClassRepositoryInterface
     */
    protected $classService;

    /**
     * @var DepartmentRepositoryInterface
     */
    protected $departmentService;

    /**
     * @var SubjectRepositoryInterface
     */
    protected $subjectService;

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
    public function registerStudent(array $userAttributes, Session $session, Term $term, School $school, EportalClass $class, Department $department = null, Subject $subject = null)
    {
        DB::beginTransaction();
        $user = $this->createUser($userAttributes);
        if (!$user) {
            return null;
        }
        $success = $this->register($user, $session, $term, $school, $class, $department, $subject);
        if (!$success) {
            DB::rollBack();
            return null;
        }
        DB::commit();
        return $user;
    }

    /**
     * @param User $user
     * @param Session $session
     * @param Term $term
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Subject $subject
     * @return bool
     */
    protected function register(User $user, Session $session, Term $term, School $school, EportalClass $class, Department $department, Subject $subject = null)
    {
        $success = $this->getSessionService()->addUser($user, $session, $term);
        if (!$success) {
            return false;
        }
        $success = $this->getSchoolService()->addUser($user, $school, $session, $term);
        if (!$success) {
            return false;
        }
        $success = $this->getClassService()->addUser($user, $school, $class, $session, $term);
        if (!$success) {
            return false;
        }

        $departmentService = $this->getDepartmentService();
        $subjectService = $this->getSubjectService();
        if (null === $department) { //add user to default department. All classes must have at least one department
            $department = $departmentService->findByName(Department::DEPARTMENT_DEFAULT);
            $subjects = $departmentService->getSubjects($school, $class, $department, $session, $term);
            $departmentService->addUser($user, $school, $class, $department, $session, $term);
            foreach ($subjects as $subject) {
                $subjectService->addUser($user, $school, $class, $department, $subject, $session, $term);
            }
            return true;
        }

        $success = $this->getDepartmentService()->addUser($user, $school, $class, $department, $session, $term);
        if (!$success) {
            return false;
        }
        if (null === $subject) {
            $subjects = $this->getDepartmentService()->getSubjects($school, $class, $department);
            foreach ($subjects as $subject) {
                $subjectService->addUser($user, $school, $class, $department, $subject, $session, $term);
            }
            return true;
        }
        $success = $this->getSubjectService()->addUser($user, $school, $class, $department, $subject, $session, $term);
        return $success;
    }

    /**
     * @param array $attributes
     * @return User
     */
    public function createUser(array $attributes)
    {
        return User::create($attributes);
    }

    /**
     * @param $id
     * @return User|null
     */
    public function findById($id)
    {
        return User::find($id);
    }

    /**
     * @return SessionRepositoryInterface
     */
    public function getSessionService()
    {
        if (!$this->sessionService) {
            $this->sessionService = app()->make(SessionRepository::class);
        }
        return $this->sessionService;
    }

    /**
     * @param SessionRepositoryInterface $sessionService
     * @return UserService
     */
    public function setSessionService(SessionRepositoryInterface $sessionService)
    {
        $this->sessionService = $sessionService;
        return $this;
    }

    /**
     * @return SchoolRepositoryInterface
     */
    public function getSchoolService()
    {
        if (!$this->schoolService) {
            $this->schoolService = app()->make(SchoolRepository::class);
        }
        return $this->schoolService;
    }

    /**
     * @param SchoolRepositoryInterface $schoolService
     * @return UserService
     */
    public function setSchoolService(SchoolRepositoryInterface $schoolService)
    {
        $this->schoolService = $schoolService;
        return $this;
    }

    /**
     * @return ClassRepositoryInterface
     */
    public function getClassService()
    {
        if (!$this->classService) {
            $this->classService = app()->make(ClassRepository::class);
        }
        return $this->classService;
    }

    /**
     * @param ClassRepositoryInterface $classService
     * @return UserService
     */
    public function setClassService(ClassRepositoryInterface $classService)
    {
        $this->classService = $classService;
        return $this;
    }

    /**
     * @return DepartmentRepositoryInterface
     */
    public function getDepartmentService()
    {
        if (!$this->departmentService) {
            $this->departmentService = app()->make(DepartmentRepository::class);
        }
        return $this->departmentService;
    }

    /**
     * @param DepartmentRepositoryInterface $departmentService
     * @return UserService
     */
    public function setDepartmentService(DepartmentRepositoryInterface $departmentService)
    {
        $this->departmentService = $departmentService;
        return $this;
    }

    /**
     * @return SubjectRepositoryInterface
     */
    public function getSubjectService()
    {
        if (!$this->subjectService) {
            $this->subjectService = app()->make(SubjectRepository::class);
        }
        return $this->subjectService;
    }

    /**
     * @param SubjectRepositoryInterface $subjectService
     * @return UserService
     */
    public function setSubjectService(SubjectRepositoryInterface $subjectService)
    {
        $this->subjectService = $subjectService;
        return $this;
    }

    /**
     * @param User $user
     * @param Session $session
     * @param Term $term
     * @return Collection|null
     */
    public function getSchools(User $user, Session $session, Term $term)
    {
        $sessionUser = $this->getSessionService()->getSessionTermUser($user, $session, $term);
        if (!$sessionUser) {
            return null;
        }
        return $sessionUser->schools()->get();
    }

    /**
     * @param User $user
     * @param School $school
     * @param Session $session
     * @param Term $term
     * @return Collection|null
     */
    public function getClasses(User $user, School $school, Session $session, Term $term)
    {
        $schoolUser = $this->getSchoolService()->getSchoolUser($user, $school, $session, $term);
        if (!$schoolUser) {
            return null;
        }
        return $schoolUser->eportalClass()->get();
    }

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Session $session
     * @param Term $term
     * @return Collection|null
     */
    public function getDepartments(User $user, School $school, EportalClass $class, Session $session, Term $term)
    {
        $classUser = $this->getClassService()->getClassUser($user, $school, $class, $session, $term);
        if (!$classUser) {
            return null;
        }
        return $classUser->department()->get();
    }

    /**
     * @param User $user
     * @param School $school
     * @param EportalClass $class
     * @param Department $department
     * @param Session $session
     * @param Term $term
     * @return Collection|null
     */
    public function getSubjects(User $user, School $school, EportalClass $class, Department $department, Session $session, Term $term)
    {
        $departmentUser = $this->getDepartmentService()->getDepartmentUser($user, $school, $class, $department, $session, $term);
        if (!$departmentUser) {
            return null;
        }
        return $departmentUser->subjects()->get();
    }
}