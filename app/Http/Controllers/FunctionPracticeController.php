<?php

namespace App\Http\Controllers;

use App\Http\Requests\FunctionPracticeStoreRequest;
use App\Http\Requests\FunctionPracticeUpdateRequest;
use App\Models\FunctionPractice;
use App\Models\Functions;
use App\Models\PartnerShipPlans;
use Illuminate\Http\Request;

class FunctionPracticeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $functionPractices = FunctionPractice::all();
        $plans = PartnerShipPlans::all();
        $functions = Functions::all();
        $remoteFunctionPractices = array();
        foreach ($functions as $function) {
            $remotFunctions = $this->GetremoteFunctionPractices($function->id);
            foreach ($remotFunctions as $remotFunction) {
                array_push($remoteFunctionPractices, $remotFunction);
            }
        }
        // $remoteFunctionPractices = $remoteFunctionPractices;
        return view('FunctionPractice.index', compact('functionPractices', 'remoteFunctionPractices', 'plans'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('FunctionPractice.create');
    }

    /**
     * @param \App\Http\Requests\FunctionPracticeStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FunctionPracticeStoreRequest $request)
    {
        $functionPractice = FunctionPractice::create($request->validated());

        return redirect()->route('FunctionPractice.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FunctionPractice $functionPractice
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FunctionPractice $functionPractice)
    {
        return view('FunctionPractice.show', compact('FunctionPractice'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FunctionPractice $functionPractice
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, FunctionPractice $functionPractice)
    {
        return view('FunctionPractice.edit', compact('FunctionPractice'));
    }

    /**
     * @param \App\Http\Requests\FunctionPracticeUpdateRequest $request
     * @param \App\Models\FunctionPractice $functionPractice
     * @return \Illuminate\Http\Response
     */
    public function update(FunctionPracticeUpdateRequest $request, FunctionPractice $functionPractice)
    {
        $functionPractice->update($request->validated());

        return redirect()->route('FunctionPractice.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FunctionPractice $functionPractice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, FunctionPractice $functionPractice)
    {
        $functionPractice->delete();

        return redirect()->route('FunctionPractice.index');
    }
    //GetFunctions where plan Id
    public function GetFunctions($id)
    {
        $functions = Functions::where('PlanId', $id)->get();
        return response()->json($functions);
    }
    private function GetremoteFunctionPractices($id)
    {

        $functions = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.hrfactoryapp.com/Admin/FunctionPractices/getFunctionPractices?FunctionId=$id");
        // Set so curl_exec returns the result instead of outputting it.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Get the response and close the channel.
        $response = curl_exec($ch);
        $result = json_decode($response);
        curl_close($ch);

        if (is_array($result)) {
            foreach ($result as $function) {
                if (FunctionPractice::find(intval($function->Id)) != null)
                    continue;
                // dd($function);
                $remotFunctions = new FunctionPractice();
                $remotFunctions->id = $function->Id;
                $remotFunctions->PracticeTitle = $function->PracticeTitle;
                $remotFunctions->PracticeTitleAr = $function->PracticeTitleAr;
                $remotFunctions->FunctionId = $function->FunctionId;
                $remotFunctions->Status = $function->Status;

                array_push($functions, $remotFunctions);
            }
        }
        return $functions;
    }
    public function search(Request $request)
    {
        // Log::info($request->get('PlanID'));
        $search = $request->get('FunctionID');
        $functionPractices = FunctionPractice::where('FunctionId', '=', $search)->get();
        $remoteFunctionPractices = $this->GetremoteFunctionPractices($search);
        $plans = PartnerShipPlans::all();
        return view('FunctionPractice.index', compact('functionPractices', 'remoteFunctionPractices', 'plans'));
    }
    public function savePractices()
    {
        $functionPractices=FunctionPractice::all();
        $plans=PartnerShipPlans::all();
        $remotFunctionsArry = array();
        $functions = Functions::all();
        foreach ($functions as $function) {
            $remoteFunctionPractices = $this->GetremoteFunctionPractices($function->id);
            foreach ($remoteFunctionPractices as $remoteFunctionPractice) {
                $remoteFunctionPractice->save();
            }
        }
        $remotFunctions = $remotFunctionsArry;
        $functions = Functions::all();
        return view('FunctionPractice.index', compact('functionPractices', 'remoteFunctionPractices', 'plans'));
    }
    //getpractices
    public function getpractices($id)
    {
        $practices = FunctionPractice::where('FunctionId', $id)->get();
        //datetables
        return DataTables()->of($practices)
            ->addIndexColumn()
            // ->addColumn('action', function ($practices) {
            //     $button = '<a href="' . route('function-practice.edit', $practices->id) . '" class="btn btn-primary btn-sm">Edit</a>';
            //     $button .= '&nbsp;&nbsp;';
            //     $button .= '<form action="' . route('function-practice.destroy', $practices->id) . '" method="POST" class="delete_form" style="display:inline">';
            //     $button .= '<input type="hidden" name="_method" value="DELETE">';
            //     $button .= csrf_field();
            //     $button .= '<button type="submit" class="btn btn-danger btn-sm">Delete</button>';
            //     $button .= '</form>';
            //     return $button;
            // })
            ->editColumn('Status', function ($row) {

                return $row->Status ? "Active" : "Inactive";
            })
            ->addColumn('questions',function($row){
                $button = '<button data-bs-target="#Questions" data-bs-toggle="modal" onclick="ShowQuestion(\''.$row->id.'\')" class="btn btn-primary btn-sm">Questions</button>';
                return $button;
            })

            ->rawColumns(['questions'])
            ->make(true);
    }
}
