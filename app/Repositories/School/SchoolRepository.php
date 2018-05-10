<?php

namespace Eportal\Repositories\School;

use Eportal\Models\EportalClass;
use Eportal\Models\School;
use Eportal\Models\SchoolClass;
use Eportal\Models\Session;
use Eportal\Models\Term;
use Eportal\Models\User\SchoolUser;
use Eportal\Models\User\User;
use Eportal\Repositories\Session\SessionRepository;
use Eportal\Repositories\Session\SessionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 *
 * @author OKALA
 */
class SchoolRepository implements SchoolRepositoryInterface
{

    /**
     * @var SessionRepositoryInterface
     */
    protected $sessionService;

    /**
     * @param int $id
     * @return School|null
     */
    public function findById($id)
    {
        return School::find($id);
    }

    /**
     * @param string $name
     * @return School|null
     */
    public function findByName($name)
    {
        return School::where('name', strtolower(trim($name)))->first();
    }

    /**
     * @param array $attributes
     * @return School
     */
    public function create(array $attributes)
    {
        $attributes['name'] = strtolower($attributes['name']);
        return School::create($attributes);
    }

    /**
     * @param School $school
     * @param array $attributes
     * @return bool
     */
    public function update(School $school, array $attributes)
    {
        $attributes['name'] = strtolower($attributes['name']);
        return $school->update($attributes);
    }

    /**
     * @param School $school
     * @return bool|null
     * @throws \Exception
     */
    public function delete(School $school)
    {
        return $school->delete();
    }

    /**
     *
     * @return Collection
     */
    public function getSchools()
    {
        return School::get();
    }

    /**
     *
     * @param School $school
     * @param EportalClass $class
     * @return boolean
     */
    public function addClass(School $school, EportalClass $class)
    {
        if ($this->hasClass($school, $class)) {
            return false;
        }
        $school->classes()->attach($class->getId());
        return true;
    }

    /**
     * @param School $school
     * @param array $classes
     * @return int number of classes added
     */
    public function addClasses(School $school, array $classes)
    {
        $added = 0;
        foreach ($classes as $class) {
            $class = EportalClass::find($class);
            if (!$class) {
                continue;
            }
            $success = $this->addClass($school, $class);
            if ($success) {
                $added++;
            }
        }
        return $added;
    }

    /**
     *
     * @param School $school
     * @return Collection
     */
    public function getClasses(School $school)
    {
        return $school->classes()->get();
    }

    /**
     * @param School $school
     * @return Collection
     */
    public function getUnaddedClasses(School $school){
        $addedClasses = $school->classes()->get()->pluck('id')->toArray();
        return EportalClass::whereNotIn('id', $addedClasses)->get();
    }
    /**
     *
     * @param School $school
     * @param EportalClass $class
     * @return bool
     */
    public function hasClass(School $school, EportalClass $class)
    {
        $bool = SchoolClass::where('school_id', $school->getId())
            ->where('class_id', $class->getId())
            ->first();
        return boolval($bool);
    }

    /**
     * @param School $school
     * @param EportalClass $class
     * @return bool
     */
    public function removeClass(School $school, EportalClass $class)
    {
        if(!$this->hasClass($school, $class)){
            return false;
        }
        $school->classes()->detach($class->getId());
        return true;
    }

    /**
     * @param School $school
     * @param array $classes
     * @return int number of classes removed
     */
    public function removeClasses(School $school, array $classes)
    {
        $removed = 0;
        foreach ($classes as $class) {
            $class = EportalClass::find($class);
            if(!$class){
                continue;
            }
            $success = $this->removeClass($school, $class);
            if($success){
                $removed++;
            }
        }
        return $removed;
    }

    /**
     *
     * @param School $school
     * @param EportalClass $class
     * @return SchoolClass
     */
    public function getSchoolClass(School $school, EportalClass $class)
    {
        return SchoolClass::where('school_id', $school->getId())
            ->where('class_id', $class->getId())
            ->first();
    }

    /**
     * @param User $user
     * @param School $school
     * @param Session $session
     * @param Term $term
     * @return bool
     */
    public function addUser(User $user, School $school, Session $session, Term $term)
    {
        if($this->hasUser($user, $school, $session, $term)){
            return false;
        }
        $sessionService = $this->getSessionService();
        $stu = $sessionService->getSessionUser($user, $session, $term);
        if(!$stu){
            return false;
        }
        $stu->schools()->attach($school->getId());
        return true;
    }

    /**
     * @param School $school
     * @param Session $session
     * @param Term $term
     * @return Collection
     */
    public function getUsers(School $school, Session $session, Term $term)
    {
        $users = School::users($school, $session, $term)->get();
        return $users->map(function ($user){
            $u = new User();
            return $u->forceFill($user->toArray());
        });
    }

    /**
     * @param User $user
     * @param School $school
     * @param Session $session
     * @param Term $term
     * @return bool
     */
    public function removeUser(User $user, School $school, Session $session, Term $term)
    {
        if(!$this->hasUser($user, $school, $session, $term)){
            return false;
        }
        $sessionService = $this->getSessionService();
        $stu = $sessionService->getSessionUser($user, $session, $term);
        $stu->schools()->detach($school->getId());
        return true;
    }

    /**
     * @param User $user
     * @param School $school
     * @param Session $session
     * @param Term $term
     * @return SchoolUser|null
     */
    public function getSchoolUser(User $user, School $school, Session $session, Term $term)
    {
        $stu = $this->getSessionService()->getSessionUser($user, $session, $term);
        if(!$stu){
            return null;
        }
        return SchoolUser::where('session_user_id', $stu->id)
            ->where('school_id', $school->getId())
            ->first();
    }

    /**
     * @param User $user
     * @param School $school
     * @param Session $session
     * @param Term $term
     * @return bool
     */
    public function hasUser(User $user, School $school, Session $session, Term $term){
        return boolval($this->getSchoolUser($user, $school, $session, $term));
    }

    /**
     * @return SessionRepositoryInterface|mixed
     */
    public function getSessionService(){
        if(!$this->sessionService){
            $this->sessionService = app()->make(SessionRepository::class);
        }
        return $this->sessionService;
    }

    /**
     * @param SessionRepositoryInterface $sessionRepository
     * @return $this
     */
    public function setSessionService(SessionRepositoryInterface $sessionRepository){
        $this->sessionService = $sessionRepository;
        return $this;
    }
}
