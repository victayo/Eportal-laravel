<?php

namespace Eportal\Repositories\Session;

use Eportal\Models\Session;
use Eportal\Models\SessionTerm;
use Eportal\Models\Term;
use Eportal\Models\User\SessionUser;
use Eportal\Models\User\User;
use Eportal\Repositories\User\UserService;
use Eportal\Repositories\User\UserServiceInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Description of SessionRepository
 *
 * @author OKALA
 */
class SessionRepository implements SessionRepositoryInterface{

    /**
     * @param Session $session
     * @param Term $term
     * @return bool
     */
    public function addTerm(Session $session, Term $term) {
        if($this->hasTerm($session, $term)){
            return false;
        }
        SessionTerm::create(['session_id' => $session->getId(), 'term_id' => $term->getId()]);
        return true;
    }

    /**
     * @param Session $session
     * @param array $terms
     * @return int
     */
    public function addTerms(Session $session, array $terms){
        $added = 0;
        foreach ($terms as $term){
            $term = Term::find($term);
            if(!$term){
                continue;
            }
            $suc = $this->addTerm($session, $term);
            if($suc){
                $added++;
            }
        }
        return $added;
    }

    /**
     * @param array $attributes
     * @return Session
     */
    public function create(array $attributes) {
        $attributes['name'] = strtolower(trim($attributes['name']));
        return Session::create($attributes);
    }

    /**
     * @param Session $session
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Session $session) {
        return $session->delete();
    }

    /**
     * @param $id
     * @return Session
     */
    public function findById($id) {
        return Session::find($id);
    }

    /**
     * @param $name
     * @return Session
     */
    public function findByName($name) {
        return Session::where('name', strtolower(trim($name)))->first();
    }

    /**
     * @return Collection
     */
    public function getSessions() {
        return Session::get();
    }

    /**
     * @param Session $session
     * @return Collection
     */
    public function getTerms(Session $session) {
        $sessionTerms = SessionTerm::terms($session)->get();
        $terms = $sessionTerms->map(function ($term) {
            $model = new Term();
            $model->forceFill($term->toArray());
            return $model;
        });
        return $terms;
    }

    /**
     * @param Session $session
     * @return Collection
     */
    public function getUnaddedTerms(Session $session){
        $terms = SessionTerm::terms($session)->pluck('id')->toArray();
        return Term::whereNotIn('id', $terms)->get();
    }

    /**
     * @param Session $session
     * @param Term $term
     * @return bool
     */
    public function hasTerm(Session $session, Term $term) {
        $st = $this->getSessionTerm($session, $term);
        return boolval($st);
    }

    /**
     * @param Session $session
     * @param Term $term
     * @return bool|null
     * @throws \Exception
     */
    public function removeTerm(Session $session, Term $term) {
        $st = $this->getSessionTerm($session, $term);
        if(!$st){
            return false;
        }
        return $st->delete();
    }


    /**
     * @param Session $session
     * @param array $terms
     * @return int
     * @throws \Exception
     */
    public function removeTerms(Session $session, array $terms){
        $removed = 0;
        foreach ($terms as $term) {
            $term = Term::find($term);
            if(!$term){
                continue;
            }
            $suc = $this->removeTerm($session, $term);
            if($suc){
                $removed++;
            }
        }
        return $removed;
    }

    /**
     * @param Session $session
     * @param array $attributes
     * @return bool
     */
    public function update(Session $session, array $attributes) {
        return $session->update($attributes);
    }

    /**
     * @param Session $session
     * @param Term $term
     * @return SessionTerm
     */
    public function getSessionTerm(Session $session, Term $term){
        return SessionTerm::where('session_id', $session->getId())
                ->where('term_id', $term->getId())
                ->first();
    }

    /**
     * @param User $user
     * @param Session $session
     * @param Term $term
     * @return bool
     */
    public function addUser(User $user, Session $session, Term $term)
    {
        if($this->hasUser($user, $session, $term)){
            return false;
        }
        $st = $this->getSessionTerm($session, $term);
        if(!$st){
            return false;
        }
        SessionUser::create([
            'user_id' => $user->getId(),
            'session_term_id' => $st->id,
        ]);
        return true;
    }

    /**
     * @param User $user
     * @param Session $session
     * @param Term $term
     * @return bool
     * @throws \Exception
     */
    public function removeUser(User $user, Session $session, Term $term)
    {
        $stu = $this->getSessionUser($user, $session, $term);
        if(!$stu){
            return false;
        }
        $stu->delete();
        return true;
    }

    /**
     * @param User $user
     * @param Session $session
     * @param Term $term
     * @return bool
     */
    public function hasUser(User $user, Session $session, Term $term)
    {
       return boolval($this->getSessionUser($user, $session, $term));
    }

    /**
     * @param Session $session
     * @param Term $term
     * @return Collection|null
     */
    public function getUsers(Session $session, Term $term)
    {
        $sessionTerm = $this->getSessionTerm($session, $term);
        if(!$sessionTerm){
            return null;
        }
        return $sessionTerm->users()->get();
    }

    /**
     * @param User $user
     * @param Session $session
     * @param Term $term
     * @return SessionUser|null
     */
    public function getSessionUser(User $user, Session $session, Term $term)
    {
        $st = $this->getSessionTerm($session, $term);
        if(!$st){
            return null;
        }
        return SessionUser::where('user_id', $user->getId())
            ->where('session_term_id', $st->id)
            ->first();
    }

    public function addUsers(array $users, Session $session, Term $term){
        $added = 0;
        $userService = $this->getUserService();
        foreach ($users as $user){
            $user =  $userService->findById($user);
            if(!$user){
                continue;
            }
            $success = $this->addUser($user, $session, $term);
            if($success){
                $added++;
            }
        }
        return $added;
    }

    /**
     * @return UserServiceInterface
     */
    protected function getUserService(){
        return app()->make(UserService::class);
    }
}
