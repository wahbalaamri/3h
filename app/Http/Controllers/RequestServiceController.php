<?php

namespace App\Http\Controllers;

use App\Models\RequestService;
use App\Http\Requests\StoreRequestServiceRequest;
use App\Http\Requests\UpdateRequestServiceRequest;
use App\Models\Clients;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RequestServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requests = RequestService::all();
        return view('request_service.index', compact('requests'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('', compact('id'));
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRequestServiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequestServiceRequest $request, RequestService $res)
    {
        //autherize guest user
        // $user->store(RequestService::create($request->validate()));
        $this->authorize('create', RequestService::class);
        RequestService::create($request->except('_token'));
        return redirect()->route('home.index')->with('success', 'Request Service Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RequestService  $requestService
     * @return \Illuminate\Http\Response
     */
    public function show(RequestService $requestService, $id)
    {
        $request = RequestService::find($id);
        $clients = Clients::where('CilentFPEmil', $request->fp_email)->get();
        return view('request_service.show', compact('request', 'clients'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RequestService  $requestService
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestService $requestService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRequestServiceRequest  $request
     * @param  \App\Models\RequestService  $requestService
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequestServiceRequest $request, RequestService $requestService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequestService  $requestService
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestService $requestService)
    {
        //
    }
    public function addClient(RequestService $requestService, $id)
    {
        $request = RequestService::find($id);
        $client = new Clients();
        $client->ClientName = $request->company_name;
        $client->ClientPhone = $request->company_phone;
        $client->CilentFPName = $request->fp_name;
        $client->CilentFPEmil = $request->fp_email;
        $client->save();
        return redirect()->route('service-request.show', $id)->with('success', 'Client Added Successfully');

    }
}
