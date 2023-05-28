<?php

namespace App\Http\Controllers;

use App\Models\Sectors;
use App\Http\Requests\StoreSectorsRequest;
use App\Http\Requests\UpdateSectorsRequest;

class SectorsController extends Controller
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
     * @param  \App\Http\Requests\StoreSectorsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSectorsRequest $request)
    {
        //save new sector
        $sector = new Sectors();
        $sector->client_id = $request->client_id;
        $sector->sector_name_en = $request->sector_name_en;
        $sector->sector_name_ar = $request->sector_name_ar;
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
    public function destroy(Sectors $sectors)
    {
        //destroy a sector
        $sector = Sectors::find($sectors->id);
        $sector->delete();
        //return back to client show page
        return redirect()->route('clients.show', $sectors->client_id)->with('success', 'Sector deleted successfully');
    }
}
