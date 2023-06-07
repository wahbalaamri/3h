<?php

namespace App\Http\Controllers;

use App\Models\Sectors;
use App\Http\Requests\StoreSectorsRequest;
use App\Http\Requests\UpdateSectorsRequest;
use App\Models\Departments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class SectorsController extends Controller
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
     * @param  \App\Http\Requests\StoreSectorsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSectorsRequest $request)
    {
        //save new sector
        $sector = new Sectors();
        $sector->client_id = $request->client_id;
        $sector->sector_name_en = $request->name_en;
        $sector->sector_name_ar = $request->name_ar;
        $sector->save();
        //return back to client show page
        return redirect()->route('clients.show', $request->client_id)->with('success', 'Sector added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sectors  $sectors
     * @return \Illuminate\Http\Response
     */
    public function show(Sectors $sectors)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sectors  $sectors
     * @return \Illuminate\Http\Response
     */
    public function edit(Sectors $sectors)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSectorsRequest  $request
     * @param  \App\Models\Sectors  $sectors
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSectorsRequest $request, Sectors $sectors)
    {
        //save updated sector
        $sector = Sectors::find($request->sector_id);
        $sector->sector_name_en = $request->sector_name_en;
        $sector->sector_name_ar = $request->sector_name_ar;
        $sector->save();
        //return back to client show page
        return redirect()->route('clients.show', $request->client_id)->with('success', 'Sector updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sectors  $sectors
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //destroy a sector
        $sector=Sectors::find($id);
        $client_id=$sector->client_id;
        // delete all related departments which is related to companies
        // get bluck of companies IDs
        $companies_ids = $sector->companies()->pluck('id');
        //delete departments
        Departments::whereIn('company_id',$companies_ids)->delete();
        // delete all related companies
        $sector->companies()->delete();
        $sector->delete();
        //return back to client show page
        return redirect()->route('clients.show', $client_id)->with('success', 'Sector deleted successfully');
    }
    // getClientsSectors for yajra table
    public function getClientsSectors(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = Sectors::where('client_id', $id)->get();
            return Datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('sectors.show', $row->id) . '" class="edit btn btn-primary btn-sm m-1"><i class="fa fa-eye"></i></a>';
                    $btn .= '<a href="' . route('sectors.edit', $row->id) . '" class="edit btn btn-primary btn-sm m-1"><i class="fa fa-edit"></i></a>';
                    $btn .= '<form action="' . route('sectors.destroy', $row->id) . '" method="POST" class="delete_form" style="display:inline">';
                    $btn .= '<input type="hidden" name="_method" value="DELETE">';
                    $btn .= csrf_field();
                    $btn .= '<button type="submit" class="btn btn-danger btn-sm m-1"><i class="fa fa-trash"></i></button>';
                    $btn .= '</form>';
                    return $btn;
                })
                //add column to add view companies modal
                ->addColumn('view_companies', function ($row) {
                    $btn = '<a href="javascript:void(0);" onclick="viewCompanies(\''.$row->id.'\')" class="edit btn btn-primary btn-sm m-1">'.__('Companies').'</a>';
                    return $btn;
                })
                ->addColumn('SectorName', function ($row) {
                    return App()->getLocale() == 'en' ? $row->sector_name_en : $row->sector_name_ar;
                })
                ->editColumn('created_at', function ($row) {
                    //format date with dd-mm-yyyy
                    return $row->created_at->format('d-m-Y');
                })
                ->rawColumns(['action','view_companies'])
                ->addIndexColumn()
                ->make(true);
        }
    }
}
