<?php

namespace Eportal\Repositories\Session;

use Eportal\Models\Session;
use Eportal\Models\Term;
use Eportal\Models\User\User;

/**
 *
 * @author OKALA
 */
interface SessionRepositoryInterface {
    
    public function findByName($name);

    public function findById($id);

    public function create(array $attributes);

    public function update(Session $session, array $attributes);

    public function delete(Session $session);

    public function getSessions();
    
    public function addTerm(Session $session, Term $term);
    
    public function removeTerm(Session $session, Term $term);
    
    public function getTerms(Session $session);
    
    public function hasTerm(Session $session, Term $term);

    public function addUser(User $user, Session $session, Term $term);

    public function removeUser(User $user, Session $session, Term $term);

    public function hasUser(User $user, Session $session, Term $term);

    public function getUsers(Session $session, Term $term);

    public function getSessionTermUser(User $user, Session $session, Term $term);
}
