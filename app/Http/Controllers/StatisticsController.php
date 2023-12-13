<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailStoreRequest;
use App\Models\Clients;
use App\Models\Companies;
use App\Models\Departments;
use App\Models\Emails;
use App\Models\Sectors;
use App\Models\SurveyAnswers;
use App\Models\Surveys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class StatisticsController extends Controller
{
    private $respondent_answers;
    private $number_emails;
    private $number_response;
    private $obj_sector_emails;
    private $id;
    private $clientID;
    //
    function index($id, $clientID)
    {
        //get all emails where survey id =$id
        $number_all_respondent = 0;
        $minutes = 5;
        $this->id = $id;
        $this->clientID = $clientID;
        // $number_all_respondent =  Cache::remember('number_all_respondent', $minutes, function () {
        //     return Emails::where('SurveyId', $this->id)->count();
        // });
        $number_all_respondent = 5551;
        $number_all_respondent_answers = Cache::remember('number_all_respondent_answers', $minutes, function () {
            return SurveyAnswers::where('SurveyId', $this->id)->distinct('AnsweredBy')->count();
        });
        //get all sectors where client id =clientID
        $sectors = Cache::remember('sectors', $minutes, function () {
            return Sectors::where('client_id', $this->clientID)->get();
        });
        //pluck sector IDs to an array
        $sectors_ids = $sectors->pluck('id')->all();
        //get all companies for each sector
        $companies_list = collect([]);
        //get all departments
        $dep_list = collect([]);
        foreach ($sectors as $sector) {
            $companies = $sector->companies;
            //push companies to  companies_list object
            $companies_list = $companies_list->merge($companies);
            foreach ($companies as $company) {
                $dep_list = $dep_list->merge($company->departments);
            }
        }
        //pluck companies IDs to an array
        $companies_ids = $companies_list->pluck('id')->all();
        //pluck departments IDs to an array
        $dep_ids = $dep_list->pluck('id')->all();
        Log::info($dep_ids);
        //get all emails where survey id =$id and foreach sectors
        $sector_emails = [];

        $companies_emails = [];
        $sectors_details = [];
        $companies_details = [];
        //sector-wise statistics
        foreach ($sectors as $sector) {
            $sector_emails = [];
            $number_of_emails = 0;
            switch ($sector->sector_name_en) {
                case 'THE ZUBAIR CORPORATION':
                    $number_of_emails = 84;
                    break;
                case 'Zubair Investments':
                    $number_of_emails = 125;
                    break;
                case 'Digitizationan & Information Technology':
                    $number_of_emails = 93;
                    break;
                case 'Education':
                    $number_of_emails = 377;
                    break;
                case 'Energy & Natural Resources':
                    $number_of_emails = 220;
                    break;
                case 'Fast Moving Consumer Good':
                    $number_of_emails = 2451;
                    break;
                case 'Industrial & Chemical':
                    $number_of_emails = 574;
                    break;
                case 'Mobility & Equipment':
                    $number_of_emails = 686;
                    break;
                case 'Real Estate':
                    $number_of_emails = 80;
                    break;
                case 'Smart Electrification & Automation':
                    $number_of_emails = 867;
                    break;
                case 'Other':
                    $number_of_emails = 21;
                    break;
                default:
                    $number_of_emails = 1;
                    break;
            }
            $this->number_emails += Emails::where([['SurveyId', $id], ['sector_id', $sector->id]])->count();
            foreach (Emails::where([['SurveyId', $id], ['sector_id', $sector->id]])->get() as $em) {
                array_push($sector_emails, $em->id);
            }
            $number_of_emails > 0 ?
                $this->number_response = SurveyAnswers::where('SurveyId', $id)->whereIn('AnsweredBy', $sector_emails)->distinct('AnsweredBy')->count('AnsweredBy') : 0;
            // chunck survey answers to get count

            $sector_details = [
                'sector_name' => App()->getLocale() == 'en' ? $sector->sector_name_en : $sector->sector_name_ar,
                'sector_id' => $sector->id,
                'sector_emails' => $number_of_emails,
                'sector_answers' => $this->number_response,
            ];
            array_push($sectors_details, $sector_details);
            foreach ($sector->companies as $company) {
                //pluck of id
                $number_of_emails_comp = 0;
                $emails_comp = Emails::where([['SurveyId', $id], ['sector_id', $sector->id], ['comp_id', $company->id]])->pluck('id')->all();
                $this->number_response = SurveyAnswers::where('SurveyId', $id)->whereIn('AnsweredBy', $emails_comp)->distinct('AnsweredBy')->count('AnsweredBy');

                switch ($company->company_name_en) {
                    case 'The Zubair Corporation':
                        $number_of_emails_comp = 76 ;
                        break;
                    case 'BAZF':
                        $number_of_emails_comp = 34;
                        break;
                    case 'JO':
                        $number_of_emails_comp = 15;
                        break;
                    case 'PC-Imaging':
                        $number_of_emails_comp = 9;
                        break;
                    case 'PHOTOCENTRE':
                        $number_of_emails_comp = 12;
                        break;
                    case 'SPARK':
                        $number_of_emails_comp = 11;
                        break;
                    case 'OMAN COMPUTER SERVICES LLC':
                        $number_of_emails_comp = 93;
                        break;
                    case 'Azzan Bin Qais International School':
                        $number_of_emails_comp = 130;
                        break;
                    case 'As Seeb International School':
                        $number_of_emails_comp = 124;
                        break;
                    case 'Sohar International School':
                        $number_of_emails_comp = 116;
                        break;
                    case 'ARA PETROLEUM OMAN B44 LIMITED':
                        $number_of_emails_comp = 63;
                        break;
                    case 'ARA Petroleum E&P LLC':
                        $number_of_emails_comp = 154;
                        break;
                    case 'AL MUZN':
                        $number_of_emails_comp = 59;
                        break;
                    case 'OLC':
                        $number_of_emails_comp = 51;
                        break;
                    case 'OWC':
                        $number_of_emails_comp = 1076;
                        break;
                    case 'Mobility & Equipment':
                        $number_of_emails_comp = 686;
                        break;
                    case 'Romana Water':
                        $number_of_emails_comp = 716;
                        break;
                    case 'Al Arabiya Mineral Water and Packaging Factory':
                        $number_of_emails_comp = 549;
                        break;
                    case 'ELCO':
                        $number_of_emails_comp = 289;
                        break;
                    case 'Jaidah Energy LLC':
                        $number_of_emails_comp = 84;
                        break;
                    case 'Oman Oil Industry Supplies & Services Company LLC':
                        $number_of_emails_comp = 148;
                        break;
                    case 'Solentis':
                        $number_of_emails_comp = 25;
                        break;
                    case 'GAC':
                        $number_of_emails_comp = 475;
                        break;
                    case 'IHE':
                        $number_of_emails_comp = 139;
                        break;
                    case 'SRT':
                        $number_of_emails_comp = 33;
                        break;
                    case 'ZAG':
                        $number_of_emails_comp = 44;
                        break;
                    case 'Barr Al Jissah':
                        $number_of_emails_comp = 21;
                        break;
                    case 'HEMZ UAE':
                        $number_of_emails_comp = 5;
                        break;
                    case 'INMA PROPERTY DEVELOPMENT LLC':
                        $number_of_emails_comp = 47;
                        break;
                    case 'ZUBAIR ELECTRIC':
                        $number_of_emails_comp = 53;
                        break;
                    case 'Federal Transformers & Switchgears LLC':
                        $number_of_emails_comp = 67;
                        break;
                    case 'Business International Group LLC':
                        $number_of_emails_comp = 86;
                        break;
                    case 'AL ZUBAIR GENERAL TRADING LLC':
                        $number_of_emails_comp = 134;
                        break;
                    case 'ZAKHER ELECTRIC WARE EST':
                        $number_of_emails_comp = 16;
                        break;
                    case 'AL ZUBAIR ELECTRICAL APPLIANCES':
                        $number_of_emails_comp = 12;
                        break;
                    case 'SPECTRA INTERNATIONAL':
                        $number_of_emails_comp = 42;
                        break;
                    case 'ZEEMAN SERVICES & SOLUTIONS WLL':
                        $number_of_emails_comp = 14;
                        break;
                    case '4000-Federal Transformers Company LLC':
                        $number_of_emails_comp = 388;
                        break;
                    case 'Zakher Education Development Company':
                        $number_of_emails_comp = 7;
                        break;
                    case 'WILMAR INTERNATIONAL LLC':
                        $number_of_emails_comp = 4;
                        break;
                    case 'AL ZUBAIR TRADING ESTABLISHMENT':
                        $number_of_emails_comp = 6;
                        break;
                    case 'ARA Petroleum LLC':
                        $number_of_emails_comp = 3;
                        break;
                    case '4010-Federal Power Transformers LLC':
                        $number_of_emails_comp = 83;
                        break;
                    default:
                        $number_of_emails_comp = count($emails_comp);;
                        break;
                }
                $company_details = [
                    'company_name' => App()->getLocale() == 'en' ? $company->company_name_en : $company->company_name_ar,
                    'company_id' => $company->id,
                    //get all emails with comp_id = $company->id
                    'company_emails' => $number_of_emails_comp,
                    'company_answers' => $this->number_response,
                    //sector name
                    'sector_name' => App()->getLocale() == 'en' ? $company->sectors->sector_name_en : $company->sectors->sector_name_ar,
                    //response rate
                    'response_rate' => round(($this->number_response / $number_of_emails_comp), 2) * 100,

                ];
                array_push($companies_details, $company_details);
            }
        }
        //company-wise statistics

        $data = [
            'number_all_respondent' => $number_all_respondent,
            'number_all_respondent_answers' => $number_all_respondent_answers,
            'sectors' => $sectors->count(),
            'companies' => count($companies_list),
            'departments' => count($dep_list),
            'id' => $id,
            'sectors_details' => $sectors_details,
            'company_details' => $companies_details,
        ];
        return view('SurveyAnswers.statistics')->with($data);
    }
    function AddNewEmails($ClientID, $SurveyID)
    {
        $data = [
            'sectors' => Sectors::where('client_id', $ClientID)->get(),
            'clients' => Clients::all(),
            'surveys' => Surveys::where('ClientId', '=', $ClientID)->get(),
            'surveyId' => $SurveyID,
            'clientId' => $ClientID,
        ];
        return view('Emails.add')->with($data);
    }
    public function GetCompForSelect($id)
    {
        $companies = Companies::where('sector_id', $id)->get();
        return response()->json($companies);
    }
    public function GetDepForSelect($id)
    {
        $departments = Departments::where('company_id', $id)->get();
        return response()->json($departments);
    }
    function saveEamil(EmailStoreRequest $request)
    {
        // dd( $request->get('ClientId'));
        if ($request->Email != null || $request->Mobile != null) {

            $byEmail = $request->Email != null ? Emails::where([['SurveyId', $request->get('SurveyId')], ['Email', $request->Email]])->count() : 0;
            $byMobile = $request->Mobile != null ? Emails::where([['SurveyId', $request->get('SurveyId')], ['Mobile', $request->Mobile]])->count() : 0;
        } else {

            return redirect()->back()->withErrors(['You must provide Either Employee Email or Mobile']);
        }
        if ($byEmail > 0 || $byMobile > 0) {
            //return back with error
            return redirect()->back()->withErrors(['This Email or Mobile already Exists']);
        }
        //save new email
        $email = new Emails();
        $email->ClientId = $request->get('ClientId');
        $email->SurveyId = $request->get('SurveyId');
        $email->Email = $request->get('Email');
        $email->Mobile = $request->get('Mobile');
        $email->sector_id = $request->SectorId;
        $email->comp_id = $request->CompanyId;
        $email->EmployeeType = $request->EmployeeType;
        //department id
        // $email->dep_id = $request->get('DepartmentId');
        $email->dep_id = 0;
        $email->AddedBy = Auth()->user()->id;
        $email->save();
        //return back with success
        return redirect()->back()->with('success', 'Email Added Successfully');

    }
}
