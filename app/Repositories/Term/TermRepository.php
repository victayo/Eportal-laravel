<?php

namespace Eportal\Repositories\Term;

use Eportal\Models\Term;

/**
 * Description of TermRepository
 *
 * @author OKALA
 */
class TermRepository implements TermRepositoryInterface {

    public function create(array $attributes) {
        $attributes['name'] = strtolower(trim($attributes['name']));
        return Term::create($attributes);
    }

    public function delete(Term $term) {
        return $term->delete();
    }

    public function findById($id) {
        return Term::find($id);
    }

    public function findByName($name) {
        return Term::where('name', strtolower(trim($name)))->first();
    }

    public function getTerms() {
        return Term::all()->sortBy('name');
    }

    public function update(Term $term, array $attributes) {
        return $term->update($attributes);
    }

}
