<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use App\Http\Requests\StoreDepartmentsRequest;
use App\Http\Requests\UpdateDepartmentsRequest;
use App\Models\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class DepartmentsController extends Controller
{
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
        $data=[
            'departments'=>Departments::all(),
        ];
        return view('departments.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=[
            'departments' =>null
        ];
        return view('departments.edit')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDepartmentsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartmentsRequest $request)
    {
        // save new department
        $departments = new Departments;
        //company id
        $departments->company_id = $request->input('company_id');
        //department name in english
        $departments->dep_name_en = $request->input('department_name_en');
        //department name in arabic
        $departments->dep_name_ar = $request->input('department_name_ar');
        //department parent
        $departments->parent_id = $request->input('parent_department_id');
        $departments->save();
        $company=Companies::find((int)$request->input('company_id'));

        //return back to client show page
        return redirect()->route('clients.show', $company->sectors->clients->id)->with('success', 'Department added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function show(Departments $departments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function edit(Departments $departments)
    {
        //edit department
        $data=[
            'departments' => $departments
        ];
        return view('departments.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDepartmentsRequest  $request
     * @param  \App\Models\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepartmentsRequest $request, Departments $departments)
    {
        // save updated department
        $departments->company_id = $request->input('company_id');
        $departments->dep_name_en = $request->input('dep_name_en');
        $departments->dep_name_ar = $request->input('dep_name_ar');
        $departments->parent_id = $request->input('parent_id');
        $departments->save();
        //return back to client show page
        return redirect()->route('clients.show', $request->client_id)->with('success', 'Department updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department=Departments::find($id);
        $client_id=$department->companies->sectors->clients->id;
        //destroy department
        $department->delete();
        //return back to client show page
        return redirect()->route('clients.show', $client_id)->with('success', 'Department deleted successfully');
    }
    //getClientsDepartments for yajra datatable
    public function getClientsDepartments(Request $request,$id)
    {
        $departments = Departments::where('company_id', $id)->get();
        return DataTables::of($departments)
        //index
        ->addIndexColumn()
        ->addColumn('action', function ($departments) {
            return '<a href="'.route('departments.edit', $departments->id).'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
            <form method="POST" action="'.route('departments.destroy', $departments->id).'" style="display: inline-block;">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="client_id" value="'.$departments->companies->sectors->clients->id.'">
            <input type="hidden" name="_token" value="'.csrf_token().'">
            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>
            </form>';
        })
        //name
        ->addColumn('DepartmentName', function ($departments) {
            return App()->getLocale()=='ar'?$departments->dep_name_ar:$departments->dep_name_en;
        })
        ->rawColumns(['action'])
        ->make(true);

    }
    // get department GetForSelect
    public function GetForSelect($id)
    {
        $departments = Departments::where('company_id', $id)->get();
        return response()->json($departments);
    }
}
