<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Http\Requests\StoreCompaniesRequest;
use App\Http\Requests\UpdateCompaniesRequest;
use App\Models\Sectors;

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
        $sector = Sectors::find($request->sector_id);
        //return back to client show page
        return redirect()->route('clients.show', $sector->clients->id)->with('success', 'Company added successfully');
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
    public function destroy($id)
    {
        //destroy company
        $company = Companies::find($id);
        $client_id = $company->sectors->clients->id;
        //delete related department
        $company->departments()->delete();
        $company->delete();
        //return back to client show page
        return redirect()->route('clients.show', $client_id)->with('success', 'Company deleted successfully');
    }
    //getClientsCompanies for yajra table
    public function getClientsCompanies($id)
    {

        $companies = Companies::where('sector_id', $id)->get();
        return datatables()->of($companies)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $button = '<a href="javascript:void(0)" data-toggle="modal" data-target="#editCompanyModal" data-id="' . $data->id . '" data-company_name_en="' . $data->company_name_en . '" data-company_name_ar="' . $data->company_name_ar . '" class="edit btn btn-primary btn-sm">Edit</a>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<form method="POST" action="'.route('companies.destroy', $data->id).'" style="display: inline-block;">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="client_id" value="'.$data->sectors->clients->id.'">
                <input type="hidden" name="_token" value="'.csrf_token().'">
                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>
                </form>';
                return $button;
            })
            //add column for depatments
            ->addColumn('Departments', function ($row) {
                return '<a href="javascript:void(0)" onclick="ShowDeps(\'' . $row->id . '\')" class="edit btn btn-primary btn-sm">' . __('Departments') . '</a>';
            })
            ->addColumn('CompanyName', function ($row) {
                return App()->getLocale() == 'ar' ? $row->company_name_ar : $row->company_name_en;
            })
            ->rawColumns(['action', 'Departments'])
            ->make(true);
    }
    //get companies GetForSelect
    public function GetForSelect($id)
    {
        $companies = Companies::where('sector_id', $id)->get();
        return response()->json($companies);
    }
}
