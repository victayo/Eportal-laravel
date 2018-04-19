<?php

namespace Eportal\Http\Controllers\Admin;

use Eportal\Models\School;
use Eportal\Repositories\School\SchoolRepositoryInterface;
use Illuminate\Http\Request;
use Eportal\Http\Controllers\Controller;

class SchoolController extends Controller
{
    /**
     * @var SchoolRepositoryInterface
     */
    protected $schoolService;

    /**
     * SchoolController constructor.
     * @param SchoolRepositoryInterface $schoolService
     */
    public function __construct(SchoolRepositoryInterface $schoolService)
    {
        $this->schoolService = $schoolService;
    }

    public function index(){
        $schools = $this->schoolService->getSchools();
        return view('admin.school.index', ['schools' => $schools]);
    }

    public function create(Request $request){

    }

    public function update(Request $request, School $school){

    }

    public function getClasses(School $school){

    }
}
