<?php

namespace Eportal\Repositories\Term;

use Eportal\Models\Term;
use Illuminate\Database\Eloquent\Collection;

/**
 *
 * @author OKALA
 */
interface TermRepositoryInterface {

    /**
     * @param $name
     * @return Term|null
     */
    public function findByName($name);

    /**
     * @param $id
     * @return Term|null
     */
    public function findById($id);

    /**
     * @param array $attributes
     * @return Term
     */
    public function create(array $attributes);

    /**
     * @param Term $term
     * @param array $attributes
     * @return boolean
     */
    public function update(Term $term, array $attributes);

    /**
     * @param Term $term
     * @return boolean
     */
    public function delete(Term $term);

    /**
     * @return Collection
     */
    public function getTerms();
}
