<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use App\Project;
use App\Country;
use App\Category;
use App\Code;

class ProjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = DB::table('projects')
        ->leftJoin('category', 'projects.category_id', '=', 'category.id')
        ->leftJoin('codes', 'projects.codes_id', '=', 'codes.id')
        ->leftJoin('country', 'projects.country_id', '=', 'country.id')
        ->select('projects.*', 'codes.id as codes_id', 'codes.project_code as p_code', 'category.type as category_type',  'category.id as category_id','country.id as country_id', 'country.name as country_name')
        ->paginate(5);

        return view('project/index', ['projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $cities = City::all();
        // $states = State::all();
        $categories = Category::all();
        $codes = Code::all();
        $countries = Country::all();
        return view('project/create', ['categories' => $categories, 'codes' => $codes, 'countries' => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateInput($request);
        $keys = ['category_id', 'codes_id', 'country_id', 'client', 'project_manager', 'project_status', 'budget',
        'start', 'end'];
        $input = $this->createQueryInput($keys, $request);
        Project::create($input);

        return redirect()->intended('/project');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);
        // Redirect to state list if updating state wasn't existed
        if ($project == null || count($project) == 0) {
            return redirect()->intended('/project');
        }
        $categories = Category::all();
        $codes = Code::all();
        $countries = Country::all();
        return view('project/edit', ['project' => $project, 'categories' => $categories, 'codes' => $codes, 'countries' => $countries]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $this->validateInput($request);
        $keys = ['category_id', 'codes_id', 'client', 'project_manager', 'project_status', 'country_id', 'budget', 'start', 'end'];
        $input = $this->createQueryInput($keys, $request);
        Project::where('id', $id)
            ->update($input);

        return redirect()->intended('/project');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         Project::where('id', $id)->delete();
         return redirect()->intended('/project');
    }

    /**
     * Search state from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'codes.project_code' => $request['p_code'],
            'project_manager' => $request['project_manager']
            ];
        $projects = $this->doSearchingQuery($constraints);
        $constraints['p_code'] = $request['p_code'];
        return view('project/index', ['projects' => $projects, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = DB::table('projects')
        ->leftJoin('category', 'projects.category_id', '=', 'category.id')
        ->leftJoin('codes', 'projects.codes_id', '=', 'codes.id')
        ->leftJoin('country', 'projects.country_id', '=', 'country.id')
        ->select('projects.*', 'codes.project_code as p_code', 'codes.id as codes_id', 'category.type as category_type', 'category.id as category_id','country.id as country_id', 'country.name as country_name');
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where($fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate(5);
    }

     /**
     * Load image resource.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    /*public function load($name) {
         $path = storage_path().'/app/avatars/'.$name;
        if (file_exists($path)) {
            return Response::download($path);
        }
    }*/

    public function exportPDF(Request $request) {
         $constraints = [
            'from' => $request['from'],
            'to' => $request['to']
        ];
        $projects = $this->getExportingData($constraints);
        $pdf = PDF::loadView('project/pdf', ['projects' => $projects, 'searchingVals' => $constraints]);
        return $pdf->download('report_from_'. $request['from'].'_to_'.$request['to'].'pdf');
        // return view('system-mgmt/report/pdf', ['employees' => $employees, 'searchingVals' => $constraints]);
    }

    private function validateInput($request) {
        $this->validate($request, [
            'category_id' => 'required',
            'codes_id' => 'required',
            'country_id' => 'required',
            'client' => 'required|max:1000',
            'project_manager' => 'required|max:1000',
            'project_status' => 'required|max:1000',
            'budget' => 'required|max:1000',
            'start' => 'required',
            'end' => 'required'
        ]);
    }

    private function createQueryInput($keys, $request) {
        $queryInput = [];
        for($i = 0; $i < sizeof($keys); $i++) {
            $key = $keys[$i];
            $queryInput[$key] = $request[$key];
        }

        return $queryInput;
    }

    private function getExportingData($constraints) {
        return DB::table('projects')
        ->leftJoin('category', 'projects.category_id', '=', 'category.id')
        ->leftJoin('codes', 'projects.codes_id', '=', 'codes.id')
        ->leftJoin('country', 'projects.country_id', '=', 'country.id')
        ->select('projects.*', 'codes.id as codes_id', 'codes.project_code as p_code', 'category.type as category_type',  'category.id as category_id','country.id as country_id', 'country.name as country_name')
        ->where('start', '>=', $constraints['from'])
        ->where('end', '<=', $constraints['to'])
        ->get()
        ->map(function ($item, $key) {
        return (array) $item;
        })
        ->all();
    }
}
