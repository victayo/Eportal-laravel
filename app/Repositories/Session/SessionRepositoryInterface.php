<?php

namespace Eportal\Repositories\Session;

use Eportal\Models\Session;
use Eportal\Models\Term;
use Eportal\Models\User\SessionUser;
use Eportal\Models\User\User;
use Illuminate\Database\Eloquent\Collection;

/**
 *
 * @author OKALA
 */
interface SessionRepositoryInterface {

    /**
     * @param $name
     * @return Session|null
     */
    public function findByName($name);

    /**
     * @param $id
     * @return Session|null
     */
    public function findById($id);

    /**
     * @param array $attributes
     * @return Session
     */
    public function create(array $attributes);

    /**
     * @param Session $session
     * @param array $attributes
     * @return boolean
     */
    public function update(Session $session, array $attributes);

    /**
     * @param Session $session
     * @return boolean
     */
    public function delete(Session $session);

    /**
     * @return Collection
     */
    public function getSessions();

    /**
     * @param Session $session
     * @param Term $term
     * @return boolean
     */
    public function addTerm(Session $session, Term $term);

    /**
     * @param Session $session
     * @param array $terms
     * @return int
     */
    public function addTerms(Session $session, array $terms);

    /**
     * @param Session $session
     * @param Term $term
     * @return boolean
     */
    public function removeTerm(Session $session, Term $term);

    /**
     * @param Session $session
     * @param array $terms
     * @return int
     */
    public function removeTerms(Session $session, array $terms);
    /**
     * @param Session $session
     * @return mixed
     */
    public function getTerms(Session $session);

    /**
     * @param Session $session
     * @return Collection
     */
    public function getUnaddedTerms(Session $session);

    /**
     * @param Session $session
     * @param Term $term
     * @return boolean
     */
    public function hasTerm(Session $session, Term $term);

    /**
     * @param User $user
     * @param Session $session
     * @param Term $term
     * @return boolean
     */
    public function addUser(User $user, Session $session, Term $term);

    /**
     * @param User $user
     * @param Session $session
     * @param Term $term
     * @return boolean
     */
    public function removeUser(User $user, Session $session, Term $term);

    /**
     * @param User $user
     * @param Session $session
     * @param Term $term
     * @return boolean
     */
    public function hasUser(User $user, Session $session, Term $term);

    /**
     * @param Session $session
     * @param Term $term
     * @return Collection
     */
    public function getUsers(Session $session, Term $term);

    /**
     * @param User $user
     * @param Session $session
     * @param Term $term
     * @return SessionUser
     */
    public function getSessionUser(User $user, Session $session, Term $term);
}
