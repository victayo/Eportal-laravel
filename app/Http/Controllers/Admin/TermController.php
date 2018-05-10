<?php

namespace Eportal\Http\Controllers\Admin;

use Eportal\Models\Term;
use Eportal\Repositories\Term\TermRepositoryInterface;
use Illuminate\Http\Request;
use Eportal\Http\Controllers\Controller;

class TermController extends Controller
{
    /**
     * @var TermRepositoryInterface
     */
    protected $termService;

    protected $property = 'term';
    /**
     * TermController constructor.
     * @param TermRepositoryInterface $termService
     */
    public function __construct(TermRepositoryInterface $termService)
    {
        $this->termService = $termService;
    }

    public function index()
    {
        $terms = $this->termService->getTerms();
        return view('admin.index', [
            'properties' => $terms,
            'property_name' => $this->property,
            'create_new_link' => route('admin.term.create'),
            'edit_link' => route('admin.term.edit', ['term' => '?']),
            'delete_link' => route('admin.term.delete')
        ]);
    }

    public function store(Request $request)
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $this->validate($request, [
                'name' => 'required|unique:terms,id'
            ]);
            $this->termService->create($request->all());
            return redirect()->route('admin.term.index');
        }
        return view('admin.create', [
            'property_name' => $this->property,
            'create_link' => route('admin.term.create')
        ]);
    }

    public function update(Request $request, Term $term)
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $this->validate($request, [
                'name' => 'required|unique:terms,name'
            ]);
            $this->termService->update($term, $request->all());
            return redirect()->route('admin.term.index');
        }
        return view('admin.edit', [
            'property_name' => $this->property,
            'property' => $term,
            'edit_link' => route('admin.term.edit', ['term' => $term->getId()])
        ]);
    }

    public function delete(Request $request)
    {
        $this->validate($request, [
            'term' => 'required|exists:terms,id'
        ]);
        $term = $this->termService->findById($request->input('term'));
        $success = $this->termService->delete($term);
        if($request->wantsJson()){
            return response()->json(['success' => $success, 'redirect' => route('admin.term.index')]);
        }
        return redirect()->route('admin.term.index');
    }
}
