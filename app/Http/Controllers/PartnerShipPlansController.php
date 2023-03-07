<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartnerShipPlanStoreRequest;
use App\Http\Requests\PartnerShipPlanUpdateRequest;
use App\Models\FunctionPractice;
use App\Models\Functions;
use App\Models\PartnerShipPlans;
use App\Models\PracticeQuestions;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Termwind\Components\Dd;

class PartnerShipPlansController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $partnerShipPlans = PartnerShipPlans::all();
        $plans = $this->GetRemotPlans();
        return view('PartnerShipPlans.index', compact('partnerShipPlans', 'plans'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('PartnerShipPlans.create');
    }

    /**
     * @param \App\Http\Requests\PartnerShipPlansStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PartnerShipPlanStoreRequest $request)
    {
        $partnerShipPlan = PartnerShipPlans::create($request->validated());

        return redirect()->route('PartnerShipPlan.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PartnerShipPlans $partnerShipPlan
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, PartnerShipPlans $partnerShipPlan)
    {
        return view('PartnerShipPlans.show', compact('partnerShipPlan'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PartnerShipPlans $partnerShipPlan
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, PartnerShipPlans $partnerShipPlan)
    {
        return view('PartnerShipPlans.edit', compact('PartnerShipPlan'));
    }

    /**
     * @param \App\Http\Requests\PartnerShipPlansUpdateRequest $request
     * @param \App\Models\PartnerShipPlans $partnerShipPlan
     * @return \Illuminate\Http\Response
     */
    public function update(PartnerShipPlanUpdateRequest $request, PartnerShipPlans $partnerShipPlan)
    {
        $partnerShipPlan->update($request->validated());

        return redirect()->route('PartnerShipPlan.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PartnerShipPlans $partnerShipPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PartnerShipPlans $partnerShipPlan)
    {
        $partnerShipPlan->delete();

        return redirect()->route('PartnerShipPlan.index');
    }
    public function getPlan($id)
    {
        $plans = $this->GetRemotPlans();
        foreach ($plans as $plan) {
            if ($plan->id == $id) {
                $tamplateName = $plan->PlanTitle . '-' . $plan->id;
                $url = "https://www.hrfactoryapp.com$plan->TamplatePath";
                $plan->TamplatePath = $tamplateName;
                $plan->TamplatePath = $this->DownlodTemplate($url, $tamplateName);
                $plan->save();
                // $this->storePlan($plan);

            }
        }
        $this->GetRemotFunctions($id);
        $functions = Functions::where('PlanId', $id)->get();
        foreach ($functions as $function) {
            $remoteFunctionPractices = $this->GetremoteFunctionPractices($function->id);
            $practices = FunctionPractice::where('FunctionId', $function->id)->get();
            foreach ($practices as $practice) {
                $remotePracticesQuestions = $this->GetremotePracticeQuestion($practice->id);
            }
        }

        return redirect()->route('partner-ship-plans.index');
    }
    private function GetRemotPlans()
    {
        $plans = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.hrfactoryapp.com/Admin/PlansToPartnerShips/getPlans?PartnerID=2");
        // Set so curl_exec returns the result instead of outputting it.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Get the response and close the channel.
        $response = curl_exec($ch);
        $result = json_decode($response);
        curl_close($ch);

        foreach ($result as $plan) {
            if (PartnerShipPlans::find(intval($plan->Id)) != null)
                continue;
            if ($plan->Status) {
                $remotPlans = new PartnerShipPlans();
                $remotPlans->id = $plan->Id;
                $remotPlans->PlanTitle = $plan->PlanTitle;
                $remotPlans->Objective = $plan->Objective;
                $remotPlans->Process = $plan->Process;
                $remotPlans->Report = $plan->Report;
                $remotPlans->DeliveryMode = $plan->DeliveryMode;
                $remotPlans->Limitations = $plan->Limitations;
                $remotPlans->PlanTitleAr = $plan->PlanTitleAr;
                $remotPlans->ObjectiveAr = $plan->ObjectiveAr;
                $remotPlans->ProcessAr = $plan->ProcessAr;
                $remotPlans->ReportAr = $plan->ReportAr;
                $remotPlans->DeliveryModeAr = $plan->DeliveryModeAr;
                $remotPlans->LimitationsAr = $plan->LimitationsAr;
                $remotPlans->Audience = $plan->audience;
                $remotPlans->TamplatePath = $plan->TamplatePath;
                $remotPlans->Price = $plan->Price;
                $remotPlans->PaymentMethod = $plan->PaymentMethod;
                $remotPlans->Status = $plan->Status;
                array_push($plans, $remotPlans);
            }
        }
        return $plans;
    }
    private function DownlodTemplate($url, $tamplateName)
    {
        $ext = pathinfo($url, PATHINFO_EXTENSION);
        $file = $this->get_file_contents_external($url);
        $fileName = $tamplateName . '.' . $ext;
        file_put_contents(public_path($fileName), $file);
        // Storage::disk('public')->put($fileName, $file);

        // $path = Storage::path($tamplateName . '.' . $ext);

        return $fileName;
    }
    public function get_file_contents_external($URL)
    {
        /**
         * this is a custom function came in a replace of the file_get_contents() function
         * the reason behind it is when we deployed the project on shared hosting the file_get_contents() function
         * did not work showing the error ((file_get_contents(): https:// wrapper is disabled in the server configuration by allow_url_fopen=0))
         * I doublechecked three times that it was enabled on the server and even contacted
         * the hosting provider and they confirmed that it was enabled but still the error was there
         * so I had to write this function to replace the file_get_contents() function
         *
         * this was basically done for the submission of the requests and disputes
         */
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);

        if ($contents) return $contents;
        else return FALSE;
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
                if ($function->status) {
                    $remotFunctions = new Functions();
                    $remotFunctions->id = $function->Id;
                    $remotFunctions->FunctionTitle = $function->FunctionTitle;
                    $remotFunctions->FunctionTitleAr = $function->FunctionTitleAr;
                    $remotFunctions->PlanId = $function->planId;
                    $remotFunctions->Respondent = $function->Respondent;
                    $remotFunctions->Status = $function->status;
                    $remotFunctions->save();
                }
            }
        }
        return true;
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
                if ($function->Status) {
                    $remotFunctions = new FunctionPractice();
                    $remotFunctions->id = $function->Id;
                    $remotFunctions->PracticeTitle = $function->PracticeTitle;
                    $remotFunctions->PracticeTitleAr = $function->PracticeTitleAr;
                    $remotFunctions->FunctionId = $function->FunctionId;
                    $remotFunctions->Status = $function->Status;
                    $remotFunctions->save();
                }
            }
        }
        return true;
    }
    private function GetremotePracticeQuestion($id)
    {
        $Questions = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.hrfactoryapp.com/Admin/PracticeQuestions/GetPracticeQuestions?practiceId=$id");
        // Set so curl_exec returns the result instead of outputting it.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Get the response and close the channel.
        $response = curl_exec($ch);
        $result = json_decode($response);
        curl_close($ch);
        if (is_array($result)) {
            foreach ($result as $quetion) {
                if (PracticeQuestions::find(intval($quetion->Id)) != null)
                    continue;
                // dd($quetion);
                if ($quetion->Status) {
                    $remoteQuestion = new PracticeQuestions();
                    $remoteQuestion->id = $quetion->Id;
                    $remoteQuestion->Question = $quetion->Question;
                    $remoteQuestion->QuestionAr = $quetion->QuestionAr;
                    $remoteQuestion->PracticeId = $quetion->Practice;
                    $remoteQuestion->Respondent = $quetion->Respondent;
                    $remoteQuestion->Status = $quetion->Status;
                    $remoteQuestion->save();
                }
            }
        }
        return true;
    }
    public function changeStatus(Request $request)
    {
        try {
            $plan = PartnerShipPlans::find($request->id);
            $plan->Status = !$plan->Status;
            $plan->save();
            $data = [
                'msg' => 'success',
                'label' => $plan->Status ? 'Active' : 'In-Active',
            ];
        } catch (Exception $exp) {
            $data = [
                'msg' => 'error',
                'label' => 'nothing to change',
            ];
        }
        return response()->json($data);
    }
}
