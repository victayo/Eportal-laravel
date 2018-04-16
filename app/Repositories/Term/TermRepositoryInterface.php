<?php

namespace Eportal\Repositories\Term;

use Eportal\Models\Term;

/**
 *
 * @author OKALA
 */
interface TermRepositoryInterface {
    public function findByName($name);

    public function findById($id);

    public function create(array $attributes);

    public function update(Term $term, array $attributes);

    public function delete(Term $term);

    public function getTerms();
}
