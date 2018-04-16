<?php

namespace Eportal\Http\Controllers\Term;

use Eportal\Models\Term;
use Eportal\Repositories\Term\TermRepository;
use Illuminate\Http\Request;
use Eportal\Http\Controllers\Controller;

class TermController extends Controller
{
    /**
     * @var TermRepository
     */
    protected $termRepo;

    public function __construct(TermRepository $termRepository)
    {
        $this->termRepo = $termRepository;
    }

    public function index(){
        $terms = $this->termRepo->getTerms();
        return response()->json(['success' => true, 'terms' => $terms]);
    }

    public function show(Term $term){
        return response()->json(['success' => true, 'term' => $term]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:terms,name',
        ]);
        $term = $this->termRepo->create($request->all());
        return response()->json(['success' => true, 'term' => $term]);
    }

    public function update(Request $request, Term $term){
        $name = $request->input('name', '');
        if (strcasecmp($name, $term->getName()) == 0) {
            //nothing to update
            return response()->json(['success' => true, 'term' => $term]);
        }
        $this->validate($request, [
            'name' => 'required|string|unique:terms,name'
        ]);
        $success = $this->termRepo->update($term, $request->all());
        return response()->json(['success' => $success, 'term' => $term]);
    }

    public function delete(Term $term){
        $success = $this->termRepo->delete($term);
        return response()->json(['success' => $success]);
    }
}
