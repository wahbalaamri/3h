<?php

namespace App\Http\Controllers;

use App\Http\Requests\FunctionStoreRequest;
use App\Http\Requests\FunctionUpdateRequest;
use App\Models\FunctionPractice;
use App\Models\Functions;
use App\Models\PartnerShipPlans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class FunctionsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $remotFunctionsArry = array();
        $functions = Functions::all();
        $plans = PartnerShipPlans::all();
        foreach ($plans as $plan) {
            $remotFunctions = $this->GetRemotFunctions($plan->id);
            foreach ($remotFunctions as $remotFunction) {
                array_push($remotFunctionsArry, $remotFunction);
            }
        }
        $remotFunctions = $remotFunctionsArry;


        return view('Functions.index', compact('functions', 'remotFunctions', 'plans'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * @param \App\Http\Requests\FunctionsStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FunctionStoreRequest $request)
    {
        $function = Functions::create($request->validated());

        return redirect()->route('Function.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Functions $function
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Functions $function)
    {
        return view('Functions.show', compact('Function'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Functions $function
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Functions $function)
    {
        return view('Functions.edit', compact('function'));
    }

    /**
     * @param \App\Http\Requests\FunctionsUpdateRequest $request
     * @param \App\Models\Functions $function
     * @return \Illuminate\Http\Response
     */
    public function update(FunctionUpdateRequest $request, Functions $function)
    {
        $function->update($request->validated());

        return redirect()->route('Function.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Functions $function
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Functions $function)
    {
        $function->delete();

        return redirect()->route('Function.index');
    }
    public function FunctionsWithPlan($PlanId)
    {
        $functions = Functions::where('PlanId', $PlanId)->get();
        $remotFunctions = $this->GetRemotFunctions($PlanId);
        $plans = PartnerShipPlans::all();
        return view('Functions.index', compact('functions', 'remotFunctions', 'plans'));
    }
    private function GetRemotFunctions($id)
    {
        Log::info('GetRemotFunctions' . $id);
        $functions = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.hrfactoryapp.com/Admin/Functions/getFunctions?planID=$id");
        // Set so curl_exec returns the result instead of outputting it.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Get the response and close the channel.
        $response = curl_exec($ch);
        $result = json_decode($response);
        curl_close($ch);
        if (is_array($result)) {
            foreach ($result as $function) {
                if (Functions::find(intval($function->Id)) != null)
                    continue;
                // dd($function);
                $remotFunctions = new Functions();
                $remotFunctions->id = $function->Id;
                $remotFunctions->FunctionTitle = $function->FunctionTitle;
                $remotFunctions->FunctionTitleAr = $function->FunctionTitleAr;
                $remotFunctions->PlanId = $function->planId;
                $remotFunctions->Respondent = $function->Respondent;
                $remotFunctions->Status = $function->status;

                array_push($functions, $remotFunctions);
            }
        }
        return $functions;
    }
    public function search(Request $request)
    {
        // Log::info($request->get('PlanID'));
        $search = $request->get('PlanID');
        $functions = Functions::where('PlanId', '=', $search)->get();
        $remotFunctions = $this->GetRemotFunctions($search);
        $plans = PartnerShipPlans::all();
        return view('Functions.index', compact('functions', 'remotFunctions', 'plans'));
    }
    //pull functions from remote
    public function savefunctions()
    {
        $remotFunctionsArry = array();
        $plans = PartnerShipPlans::all();
        foreach ($plans as $plan) {
            $remotFunctions = $this->GetRemotFunctions($plan->id);
            foreach ($remotFunctions as $remotFunction) {
                $remotFunction->save();
            }
        }
        $remotFunctions = $remotFunctionsArry;
        $functions = Functions::all();
        return view('Functions.index', compact('functions', 'remotFunctions', 'plans'));
    }
    // get functions as json
    public function getfunctions($id)
    {
        $functions = Functions::where('PlanId', $id)->get();
        //datetables
        return DataTables()->of($functions)
            ->addIndexColumn()
            // ->addColumn('action', function ($functions) {
            //     $button = '<a href="' . route('functions.edit', $functions->id) . '" class="btn btn-primary btn-sm">Edit</a>';
            //     $button .= '&nbsp;&nbsp;';
            //     $button .= '<form action="' . route('functions.destroy', $functions->id) . '" method="POST" class="delete_form" style="display:inline">';
            //     $button .= '<input type="hidden" name="_method" value="DELETE">';
            //     $button .= csrf_field();
            //     $button .= '<button type="submit" class="btn btn-danger btn-sm">Delete</button>';
            //     $button .= '</form>';
            //     return $button;
            // })
            ->editColumn('Respondent', function ($row) {
                $audience = "";
                switch ($row->Respondent) {
                    case (1):
                        $audience = "Only HR Employees";
                        break;

                    case (2):
                        $audience = "Only Employees";
                        break;

                    case (3):
                        $audience = "Only Managers";
                        break;

                    case (4):
                        $audience = "Only HR Employees & Employees";
                        break;

                    case (5):
                        $audience = "Only Managers & Employees";
                        break;

                    case (6):
                        $audience = "Only Managers & HR Employees";
                        break;

                    case (7):
                        $audience = "All Employees";
                        break;

                    case (8):
                        $audience = "Public";
                        break;
                }
                return $audience;
            })
            ->editColumn('Status', function ($row) {

                return $row->Status ? "Active" : "Inactive";
            })
            ->addColumn('practices',function($row){
                //btn to show practices
                return '<button data-bs-toggle="modal" href="#Practice" onclick="getPractice(\''.$row->id.'\')" class="btn btn-primary btn-sm">Practices</a>';

            })
            ->rawColumns(['practices'])
            ->make(true);
    }

}
