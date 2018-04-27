<?php

namespace Eportal\Repositories\Term;

use Eportal\Models\Term;
use Illuminate\Database\Eloquent\Collection;

/**
 * Description of TermRepository
 *
 * @author OKALA
 */
class TermRepository implements TermRepositoryInterface {

    /**
     * @param array $attributes
     * @return Term
     */
    public function create(array $attributes) {
        $attributes['name'] = strtolower(trim($attributes['name']));
        return Term::create($attributes);
    }

    public function delete(Term $term) {
        return $term->delete();
    }

    /**
     * @param $id
     * @return Term|null
     */
    public function findById($id) {
        return Term::find($id);
    }

    /**
     * @param $name
     * @return Term|null
     */
    public function findByName($name) {
        return Term::where('name', strtolower(trim($name)))->first();
    }

    /**
     * @return Collection
     */
    public function getTerms() {
        return Term::all()->sortBy('name');
    }

    /**
     * @param Term $term
     * @param array $attributes
     * @return bool
     */
    public function update(Term $term, array $attributes) {
        return $term->update($attributes);
    }

}
