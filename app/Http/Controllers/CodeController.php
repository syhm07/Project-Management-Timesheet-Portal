<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use App\Code;
use App\Department;

class CodeController extends Controller
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
         $codes = DB::table('codes')
        ->leftJoin('department', 'codes.department_id', '=', 'department.id')
        ->select('codes.*', 'department.name as department_name', 'department.id as department_id')
        ->paginate(5);
        return view('code/index', ['codes' => $codes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::all();
        return view('code/create', ['departments' => $departments]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    /*{
        Department::findOrFail($request['department_id']);
        $this->validateInput($request);
         Code::create([
            'project_code' => $request['project_code'],
            'project_name' => $request['project_name']
            'department_name' => $request['department_name'],
            'task' => $request['task'],
            'description' => $request['description']
        ]);

        return redirect()->intended('code');
    }*/

    {
        $this->validateInput($request);
        $keys = ['project_code', 'project_name', 'department_id', 'task', 'description'];
        $input = $this->createQueryInput($keys, $request);
        Code::create($input);

        return redirect()->intended('/code');
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
        $code = Code::find($id);
        // Redirect to state list if updating state wasn't existed
        if ($code == null || count($code) == 0) {
            return redirect()->intended('/code');
        }

        $departments = Department::all();
        return view('code/edit', ['code' => $code, 'departments' => $departments]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    /*{
        $code = Code::findOrFail($id);
         $this->validate($request, [
        'project_code' => 'required|max:1000'
        ]);
        $input = [
            'project_code' => $request['name'],
            'project_name' => $request['project_name'],
            'department_id' => $request['department_id'],
            'task' => $request['task'],
            'description' => $request['description']
        ];
        Code::where('id', $id)
            ->update($input);
        
        return redirect()->intended('code');
    }*/

     {
        $code = Code::findOrFail($id);
        $this->validateInput($request);
        $keys = ['project_code', 'project_name', 'department_id', 'task', 'description'];
        $input = $this->createQueryInput($keys, $request);
        /*if ($request->file('picture')) {
            $path = $request->file('picture')->store('avatars');
            $input['picture'] = $path;*/
        

        Code::where('id', $id)
            ->update($input);

        return redirect()->intended('/code');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Code::where('id', $id)->delete();
         return redirect()->intended('/code');
    }

    /*public function loadStates($departmentId) {
        $codes = Code::where('department_id', '=', $departmentId)->get(['id', 'name']);

        return response()->json($codes);
    }*/
    
    /**
     * Search state from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'project_code' => $request['project_code']
            //'project_name' => $request['project_name']
            ];

       $codes = $this->doSearchingQuery($constraints);
       $constraints['project_code'] = $request['project_code'];
       return view('code/index', ['codes' => $codes, 'searchingVals' => $constraints]);
    }

    /*private function doSearchingQuery($constraints) {
        $query = Code::table('codes')
        ->leftJoin('department', 'codes.department_id', '=', 'department.id')
        ->select('codes.project_code as project_code', 'codes.*','department.name as department_name', 'department.id as department_id');
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where( $fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate(5);
    }*/

    private function doSearchingQuery($constraints) {
        //$query = Code::query();
        $query = DB::table('codes')
        ->leftJoin('department', 'codes.department_id', '=', 'department.id')
        ->select('codes.*', 'department.name as department_name', 'department.id as department_id');
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where( $fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate(5);
    }
    private function validateInput($request) {
        $this->validate($request, [
        'project_name' => 'required|max:1000',
        'project_code' => 'required|max:1000',
        'department_id'=> 'required',
        'task' => 'required|max:1000',
        'description' => 'required|max:1000'
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
}
