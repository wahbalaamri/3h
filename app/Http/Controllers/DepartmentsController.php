<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use App\Http\Requests\StoreDepartmentsRequest;
use App\Http\Requests\UpdateDepartmentsRequest;

class DepartmentsController extends Controller
{
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
        $departments = new Departments();
        //company id
        $departments->company_id = $request->input('company_id');
        //department name in english
        $departments->dep_name_en = $request->input('dep_name_en');
        //department name in arabic
        $departments->dep_name_ar = $request->input('dep_name_ar');
        //department parent
        $departments->parent_id = $request->input('parent_id');
        $departments->save();
        //return back to client show page
        return redirect()->route('clients.show', $request->client_id)->with('success', 'Department added successfully');
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
    public function destroy(Departments $departments)
    {
        //destroy department
        $departments->delete();
        //return back to client show page
        return redirect()->route('clients.show', $departments->company->sector->client->id)->with('success', 'Department deleted successfully');
    }
}
