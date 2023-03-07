<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailByUploadStoreRequest;
use App\Http\Requests\EmailStoreRequest;
use App\Http\Requests\EmailUpdateRequest;
use App\Mail\SendSurvey;
use App\Models\EmailContent;
use App\Models\Emails;
use App\Models\SurveyAnswers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Exceptions\NoTypeDetectedException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use ImportUser;
use Symfony\Component\Console\Input\Input as InputInput;
use Yajra\DataTables\Facades\DataTables;

class EmailsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $emails = Emails::all();
        $data = [
            'emails' => array(),
            'clients' => \App\Models\Clients::all(),
            'surveys' => \App\Models\Surveys::all(),
        ];
        return view('Emails.index')->with($data);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = [
            'clients' => \App\Models\Clients::all(),
            'surveys' => \App\Models\Surveys::all(),
        ];
        return view('Emails.create')->with($data);
    }

    /**
     * @param \App\Http\Requests\EmailsStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmailStoreRequest $request)
    {
        // dd( $request->get('ClientId'));
        $email = Emails::create($request->validated());

        return redirect()->route('clients.show', $request->get('ClientId'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Emails $email
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Emails $email)
    {
        return view('Emails.show', compact('email'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Emails $email
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Emails $email)
    {
        $data = [
            'email' => $email,
            'clients' => \App\Models\Clients::all(),
            'surveys' => \App\Models\Surveys::all(),
        ];
        return view('Emails.edit')->with($data);
    }

    /**
     * @param \App\Http\Requests\EmailsUpdateRequest $request
     * @param \App\Models\Emails $email
     * @return \Illuminate\Http\Response
     */
    public function update(EmailUpdateRequest $request, Emails $email)
    {
        $email->update($request->validated());

        return redirect()->route('clients.show', $email->ClientId);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Emails $email
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Emails $email)
    {
        $id = $email->ClientId;
        $email->delete();

        return redirect()->route('clients.show', $id);
    }
    public function search(Request $request)
    {
        $ClientID = $request->get('ClientID');
        $SurveyID = $request->get('SurveyID');
        $emails = Emails::where([['ClientId', '=', $ClientID], ['SurveyId', '=', $SurveyID]])->get();
        $data = [
            'emails' => $emails,
            'clients' => \App\Models\Clients::all(),
            'surveys' => \App\Models\Surveys::all(),
        ];
        return view('Emails.index')->with($data);
    }
    public function saveUpload(EmailByUploadStoreRequest $request)
    {

        $request->validated();

        if ($request->hasFile('EmailFile')) {
            $file = $request->file('EmailFile')->getRealPath();

            // Excel::toArray([],$filePath);
            $array = array();
            $tss = Excel::toArray($array, $request->file('EmailFile'));
            Log::alert($tss[0]);
            $emails = Excel::toArray([], $request->file('EmailFile'));
            Log::alert($request->AddedBy);
            foreach ($emails[0] as $key => $value) {

                if (str_contains($value[0], '@')) {
                    $email = Emails::create([
                        'ClientId' => $request->get('ClientIdU'),
                        'SurveyId' => $request->get('SurveyIdU'),
                        'Email' => $value[0],
                        'EmployeeType' => $value[1],
                        'AddedBy' => $request->AddedBy,
                    ]);
                } else {
                    continue;
                }
            }
            return redirect()->route('clients.show', $request->ClientIdU);
        } else {
            return view('Emails.create')->with('error', 'Please Upload File');
        }
    }
    public function copy(Request $request)
    {
        $ClientID = $request->get('ClientIdC');
        $SurveyID = $request->get('SurveyIdC');
        $newSurveyID = $request->get('NewSurveyIdC');
        // dd($request->all());
        // dd('newSurveyID: '.$newSurveyID .' SurveyID: '.$SurveyID.' ClientID: '.$ClientID );
        $emails = Emails::where([['ClientId', '=', $ClientID], ['SurveyId', '=', $SurveyID]])->get();
        if ($SurveyID == $newSurveyID) {
            return redirect()->route('emails.create')->withErrors('Please Select Different Survey');
        } else {
            foreach ($emails as $key => $value) {
                $email = Emails::create([
                    'ClientId' => $ClientID,
                    'SurveyId' => $newSurveyID,
                    'Email' => $value->Email,
                    'EmployeeType' => $value->EmployeeType,
                    'AddedBy' => Auth::user()->user_type == 'superadmin' ? 0 : Auth::user()->company_id,
                ]);
            }
            return redirect()->route('clients.show', $ClientID);
        }
    }
    public function manage()
    {
        $data = [
            'emails' => EmailContent::all(),
            'clients' => \App\Models\Clients::all(),
            'surveys' => \App\Models\Surveys::all(),
        ];
        return view('Emails.manage')->with($data);
    }
    public function CreateContent(Request $request)
    {
        $data = [
            'clients' => \App\Models\Clients::all(),
            'surveys' => \App\Models\Surveys::all(),
        ];
        return view('Emails.createcontent')->with($data);
    }
    public function StoreContent(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'survey_id' => 'required',
            'subject' => 'required',
            'body_header' => 'required',
            'body_footer' => 'required',
        ]);
        $email = new EmailContent();
        $email->client_id = $request->client_id;
        $email->survey_id = $request->survey_id;
        $email->subject = $request->subject;
        $email->body_header = $request->body_header;
        $email->body_footer = $request->body_footer;
        $email->subject_ar = $request->subject_ar;
        $email->body_header_ar = $request->body_header_ar;
        $email->body_footer_ar = $request->body_footer_ar;
        $email->save();
        return redirect()->route('emails.manage');
    }
    public function ViewContent(Request $request, $id)
    {
        $email = EmailContent::find($id);
        $data = [
            'email' => $email,
            'clients' => \App\Models\Clients::all(),
            'surveys' => \App\Models\Surveys::all(),
        ];
        return view('Emails.viewcontent')->with($data);
    }
    public function SendSurvey($id)
    {
        $emailContent = EmailContent::find($id);
        $emails = Emails::where([['ClientId', '=', $emailContent->client_id], ['SurveyId', '=', $emailContent->survey_id]])->get();
        foreach ($emails as $key => $value) {
            $data = [
                'email' => $value->Email,
                'id' => $value->id,
                'subject' => $emailContent->subject,
                'body_header' => $emailContent->body_header,
                'body_footer' => $emailContent->body_footer,
                'subject_ar' => $emailContent->subject_ar,
                'body_header_ar' => $emailContent->body_header_ar,
                'body_footer_ar' => $emailContent->body_footer_ar,
            ];
            Mail::to($value->Email)->send(new SendSurvey($data));
            sleep(2);
        }
        return redirect()->route('emails.manage');
    }
    public function sendSurveyw(Request $request, $SurveyID, $ClientID)
    {
        $data = [
            'clients' => \App\Models\Clients::all(),
            'surveys' => \App\Models\Surveys::all(),
            'surveyId' => $SurveyID,
            'clientId' => $ClientID,
            'reminder' => 0
        ];
        return view('Emails.CreateEmail')->with($data);
    }
    public function sendTheSurvey(Request $request)
    {
        Log::alert($request->reminder);
        if ($request->reminder == 0)
            $emails = Emails::where([['ClientId', '=', $request->client_id], ['SurveyId', '=', $request->survey_id]])->get();
        else {
            $emails = Emails::where([['ClientId', '=', $request->client_id], ['SurveyId', '=', $request->survey_id]])
                ->whereNotIn('id', SurveyAnswers::where('SurveyId', $request->survey_id)->distinct()->pluck('AnsweredBy')->ToArray())
                ->get();
            Log::info($emails);
        }
        Log::alert($emails);
        foreach ($emails as $key => $value) {
            Log::alert($value);
            $data = [
                'email' => $value->Email,
                'id' => $value->id,
                'subject' => $request->subject,
                'body_header' => $request->body_header,
                'body_footer' => $request->body_footer,
            ];
            Mail::to($value->Email)->send(new SendSurvey($data));
            Log::alert($data);
            // sleep(2);
        }
        return redirect()->route('clients.show', $request->client_id);
    }
    public function sendReminder(Request $request, $SurveyID, $ClientID)
    {
        $data = [
            'clients' => \App\Models\Clients::all(),
            'surveys' => \App\Models\Surveys::all(),
            'surveyId' => $SurveyID,
            'clientId' => $ClientID,
            'reminder' => 1
        ];
        return view('Emails.CreateEmail')->with($data);
    }

    public function getEmails($ClientID, $SurveyID)
    {
        $emails = Emails::where([['ClientId', '=', $ClientID], ['SurveyId', '=', $SurveyID]])->get();
        //datatable
        return DataTables::of($emails)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="' . route('emails.edit', $row->id) . '" class="btn btn-sm m-1 btn-primary"><i class="fa fa-edit"></i></a>';
                $btn .= '<form action="' . route('emails.destroy', $row->id) . '" method="POST" class="delete_form" style="display:inline">';
                $btn .= '<input type="hidden" name="_method" value="DELETE">';
                $btn .= csrf_field();
                $btn .= '<button type="submit" class="btn btn-danger btn-sm m-1"><i class="fa fa-trash"></i></button>';
                $btn .= '</form>';
                return $btn;
            })
            ->editColumn('EmployeeType', function ($row) {
                switch ($row->EmployeeType) {
                    case 3:
                        return 'Employee';
                    case 1:
                        return 'Manager';
                    case 2:
                        return 'HR Team';
                    default:
                        return 'Others';
                }
            })
            ->make(true);
    }
    public function CreateNewEmails($ClientID, $SurveyID)
    {
        $data = [
            'clients' => \App\Models\Clients::all(),
            'surveys' => \App\Models\Surveys::where('ClientId', '=', $ClientID)->get(),
            'surveyId' => $SurveyID,
            'clientId' => $ClientID,
        ];
        return view('Emails.create')->with($data);
    }
}
