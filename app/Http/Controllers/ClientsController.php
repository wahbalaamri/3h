<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Models\Clients;
use App\Models\Surveys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
class ClientsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients = Clients::all();

        return view('Clients.index', compact('clients'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('Clients.create');
    }

    /**
     * @param \App\Http\Requests\ClientsStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientStoreRequest $request)
    {
        $client = Clients::create($request->validated());

        return redirect()->route('clients.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Clients $client
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Clients $client)
    {
        Log::alert($request->ajax());

        return view('Clients.show', compact('client'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Clients $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Clients $client)
    {
        return view('Clients.edit', compact('client'));
    }

    /**
     * @param \App\Http\Requests\ClientsUpdateRequest $request
     * @param \App\Models\Clients $client
     * @return \Illuminate\Http\Response
     */
    public function update(ClientUpdateRequest $request, Clients $client)
    {
        $client->update($request->validated());

        return redirect()->route('clients.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Clients $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Clients $client)
    {
        $client->delete();

        return redirect()->route('clients.index');
    }
    public function getClients($id)
    {

            return Datatables()->of(Surveys::where('ClientId', $id)->get())
                ->addIndexColumn()
                ->addColumn('survey_result', function ($row) {
                    $url = route('survey-answers.result', $row->id);
                    $data='<a  data-bs-toggle="modal" href="#RespondentEmails" onclick="GetRespondentsEmails(\'' . $row->id . '\')" class="btn btn-success btn-sm float-start"> Respondents</a>';
                    $data .= '<a href="' . $url . '" class="btn btn-info btn-sm float-end"> Result</a>';
                    return $data;
                })
                // ->addColumn('respondents', function ($row) {

                //     return '<a  data-bs-toggle="modal" href="#RespondentEmails" onclick="GetRespondentsEmails(\'' . $row->id . '\')" class="btn btn-success btn-sm">View Respondents</a>';
                // })
                ->addColumn('send_survey', function ($row) {
                    // $url = route('emails.Ssurvey', $row->id,$row->ClientId);
                    // $url = route('survey-answers.result', $row->id);
                    $data = '<a href="/emails/send-reminder/' . $row->id . '/' . $row->ClientId . '" class="btn btn-info btn-sm float-start"> Reminder</a>';
                    $data .= '<a href="/emails/send-survey/' . $row->id . '/' . $row->ClientId . '" class="btn btn-success btn-sm float-end"> Survey</a>';
                    return $data;
                })
                // ->addColumn('send_reminder', function ($row) {
                //     $url = route('survey-answers.result', $row->id);
                //     return '<a href="/emails/send-reminder/' . $row->id . '/' . $row->ClientId . '" class="btn btn-success btn-sm">Send Reminder</a>';
                // })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('surveys.show', $row->id) . '" class="edit btn btn-primary btn-sm m-1"><i class="fa fa-eye"></i></a>';
                    $btn .= '<a href="' . route('surveys.edit', $row->id) . '" class="edit btn btn-primary btn-sm m-1"><i class="fa fa-edit"></i></a>';
                    $btn .= '<form action="' . route('surveys.destroy', $row->id) . '" method="POST" class="delete_form" style="display:inline">';
                    $btn .= '<input type="hidden" name="_method" value="DELETE">';
                    $btn .= csrf_field();
                    $btn .= '<button type="submit" class="btn btn-danger btn-sm m-1"><i class="fa fa-trash"></i></button>';
                    $btn .= '</form>';
                    return $btn;
                })
                ->editColumn('created_at', function ($row) {
                    //format date with dd-mm-yyyy
                    return $row->created_at->format('d-m-Y');
                })
                ->editColumn('PlanId', function ($row) {
                    return $row->plan->PlanTitle;
                })
                ->editColumn('SurveyStat', function ($row) {
                    $isChecked = $row->SurveyStat ? "checked" : "";
                    $lable = $row->SurveyStat ? "Active" : "In-Active";
                    $check = '<div class="form-check form-switch">';
                    $check .= '<input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked' . $row->id . '" ' . $isChecked . ' onchange="ChangeCheck(this,\'' . $row->id . '\')" >';
                    $check .= '<label class="form-check-label" for="flexSwitchCheckChecked' . $row->id . '">' . $lable . '</label></div>';
                    return $check;
                })
                ->rawColumns(['action', 'survey_result', 'SurveyStat',  'send_survey'])
                ->addIndexColumn()
                ->make(true);

    }
}
