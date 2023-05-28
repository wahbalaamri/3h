<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Http\Requests\StoreCompaniesRequest;
use App\Http\Requests\UpdateCompaniesRequest;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCompaniesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompaniesRequest $request)
    {
        //save new comapny
        $company = new Companies();
        $company->sector_id = $request->sector_id;
        $company->company_name_en = $request->company_name_en;
        $company->company_name_ar = $request->company_name_ar;
        $company->save();
        //return back to client show page
        return redirect()->route('clients.show', $request->client_id)->with('success', 'Company added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Companies  $companies
     * @return \Illuminate\Http\Response
     */
    public function show(Companies $companies)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Companies  $companies
     * @return \Illuminate\Http\Response
     */
    public function edit(Companies $companies)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCompaniesRequest  $request
     * @param  \App\Models\Companies  $companies
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompaniesRequest $request, Companies $companies)
    {
        //save update company
        $company = Companies::find($request->company_id);
        $company->company_name_en = $request->company_name_en;
        $company->company_name_ar = $request->company_name_ar;
        $company->save();
        //return back to client show page
        return redirect()->route('clients.show', $request->client_id)->with('success', 'Company updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Companies  $companies
     * @return \Illuminate\Http\Response
     */
    public function destroy(Companies $companies)
    {
        //destroy company
        $company = Companies::find($companies->id);
        $company->delete();
        //return back to client show page
        return redirect()->route('clients.show', $companies->sector->client->id)->with('success', 'Company deleted successfully');
    }
}
