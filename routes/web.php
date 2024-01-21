<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\EmailsController;
use App\Http\Controllers\FunctionPracticeController;
use App\Http\Controllers\FunctionsController;
use App\Http\Controllers\Home;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PartnerShipPlansController;
use App\Http\Controllers\PracticeQuestionsController;
use App\Http\Controllers\PrioritiesAnswersController;
use App\Http\Controllers\QuestionnairController;
use App\Http\Controllers\RequestServiceController;
use App\Http\Controllers\SectorsController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\SurveyAnswersController;
use App\Http\Controllers\SurveysController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [Home::class, 'index'])->name('home.index');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/survey/{id}', [QuestionnairController::class, 'index'])->name('survey');
Route::get('/SurveyUrlForm', [QuestionnairController::class, 'generateSurveyUrlForm'])->name('survey.generateSurveyUrlForm');
Route::get('/testRadio', [QuestionnairController::class, 'testRadio'])->name('survey.testRadio');
Route::post('/GenerateSurveyURL', [QuestionnairController::class, 'generateSurveyUrl'])->name('survey.generateSurveyUrl');
Route::get('/surveyQRCode', [QuestionnairController::class, 'surveyQRCode'])->name('surveyQRCode');
Route::get('/FreeSurvey', [QuestionnairController::class, 'fressSurvey'])->name('FreeSurvey');
Route::post('/questionnair/saveAnswer', [QuestionnairController::class, 'saveAnswer'])->name('questionnair.saveAnswer');

Auth::routes();
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'role:admin']);
Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::post('/functions/change-status', [PartnerShipPlansController::class, 'changeStatus'])->middleware(['auth', 'role:admin']);
Route::resource('partner-ship-plans', PartnerShipPlansController::class)->middleware(['auth', 'role:admin']);
Route::get('/partner-ship-plans/getPlan/{id}', [PartnerShipPlansController::class, 'getPlan'])->name('partner-ship-plans.getPlan')->middleware(['auth', 'role:admin']);

Route::get('/functions/save', [FunctionsController::class, 'savefunctions'])->name('functions.save')->middleware(['auth', 'role:admin']);

Route::get('/functions/getfunctions/{id}', [FunctionsController::class, 'getfunctions'])->name('functions.getfunctions')->middleware(['auth', 'role:admin']);
Route::resource('functions', FunctionsController::class)->middleware(['auth', 'role:admin']);
Route::get('/functions/FunctionsWithPlan/{id}', [FunctionsController::class, 'FunctionsWithPlan'])->name('functions.FunctionsWithPlan')->middleware(['auth', 'role:admin']);
Route::post('/functions/search', [FunctionsController::class, 'search'])->name('functions.search')->middleware(['auth', 'role:admin']);
// Route::get('/functions/pullData', [FunctionsController::class, 'pullData'])->name('functions.pullData');

Route::get('/function-practice/getpractices/{id}', [FunctionPracticeController::class, 'getpractices'])->name('function-practice.getpractices')->middleware(['auth', 'role:admin']);
Route::get('/function-practice/save', [FunctionPracticeController::class, 'savePractices'])->name('function-practice.save')->middleware(['auth', 'role:admin']);
Route::resource('function-practice', FunctionPracticeController::class)->middleware(['auth', 'role:admin']);
Route::post('/function-practice/search', [FunctionPracticeController::class, 'search'])->name('function-practice.search')->middleware(['auth', 'role:admin']);
Route::get('/function-practice/GetFunctions/{id}', [FunctionPracticeController::class, 'GetFunctions'])->name('function-practice.GetFunctions')->middleware(['auth', 'role:admin']);

Route::resource('practice-questions', PracticeQuestionsController::class)->middleware(['auth', 'role:admin']);
Route::post('/practice-questions/search', [PracticeQuestionsController::class, 'search'])->name('practice-questions.search')->middleware(['auth', 'role:admin']);
Route::get('/practice-questions/GetPractice/{id}', [PracticeQuestionsController::class, 'GetPractice'])->name('practice-questions.GetPractice')->middleware(['auth', 'role:admin']);
Route::get('/practice-questions/getquestions/{id}', [PracticeQuestionsController::class, 'getQuestions'])->name('practice-questions.getquestions')->middleware(['auth', 'role:admin']);
Route::get('/practice-questions/CreateNewQuestion/{id}', [PracticeQuestionsController::class, 'CreateNewQuestion'])->name('practice-questions.CreateNewQuestion')->middleware(['auth', 'role:admin']);
Route::post('/practice-questions/SaveNewQuestion/{id}', [PracticeQuestionsController::class, 'SaveNewQuestion'])->name('practice-questions.SaveNewQuestion')->middleware(['auth', 'role:admin']);
// save remote data
Route::post('/practice-questions/save/{id}', [PracticeQuestionsController::class, 'saveQuestions'])->name('practice-questions.save')->middleware(['auth', 'role:admin']);

Route::get('/clients/getClients/{id}', [ClientsController::class, 'getClients'])->name('clients.getClients')->middleware(['auth', 'role:admin']);
Route::resource('clients', ClientsController::class)->middleware(['auth', 'role:admin']);
Route::get('users/changePassword/{id}', [UsersController::class, 'changePassword'])->name('users.changePassword')->middleware(['auth', 'role:admin']);
Route::get('users/setupsers', [UsersController::class, 'setup_users'])->name('users.setupusers')->middleware(['auth']);
Route::post('users/storeNewPass/{id}', [UsersController::class, 'storeNewPass'])->name('users.storeNewPass')->middleware(['auth', 'role:admin']);
Route::resource('users', UsersController::class)->middleware(['auth', 'role:admin']);

Route::get('/emails/send-survey/{Surveyid}/{Clientid}', [EmailsController::class, 'sendSurveyw'])->name('emails.Ssurvey')->middleware(['auth', 'role:admin']);
Route::get('/emails/send-reminder/{Surveyid}/{Clientid}', [EmailsController::class, 'sendReminder'])->name('emails.send-reminder')->middleware(['auth', 'role:admin']);
Route::get('/emails/sendIndividual/{id}', [EmailsController::class, 'sendIndividual'])->name('emails.sendIndividual')->middleware(['auth', 'role:admin']);
Route::post('/emails/sendTheSurvey', [EmailsController::class, 'sendTheSurvey'])->name('emails.sendTheSurvey')->middleware(['auth', 'role:admin']);
Route::get('/emails/manage', [EmailsController::class, 'manage'])->name('emails.manage')->middleware(['auth', 'role:admin']);
Route::get('/emails/CreateContent', [EmailsController::class, 'CreateContent'])->name('emails.CreateContent')->middleware(['auth', 'role:admin']);
Route::get('/emails/ViewContent/{id}', [EmailsController::class, 'ViewContent'])->name('emails.ViewContent')->middleware(['auth', 'role:admin']);
Route::get('/emails/EditContent', [EmailsController::class, 'EditContent'])->name('emails.EditContent')->middleware(['auth', 'role:admin']);
Route::post('/emails/StoreContent', [EmailsController::class, 'StoreContent'])->name('emails.StoreContent')->middleware(['auth', 'role:admin']);
Route::post('/emails/UpdateContent', [EmailsController::class, 'UpdateContent'])->name('emails.UpdateContent')->middleware(['auth', 'role:admin']);
Route::post('/emails/Delete', [EmailsController::class, 'Delete'])->name('emails.Delete')->middleware(['auth', 'role:admin']);
Route::get('/emails/SendSurvey/{id}', [EmailsController::class, 'SendSurvey'])->name('emails.SendSurvey')->middleware(['auth', 'role:admin']);
Route::get('/emails/CreateNewEmails/{Clientid}/{Surveyid}', [EmailsController::class, 'CreateNewEmails'])->name('emails.CreateNewEmails')->middleware(['auth', 'role:admin']);
Route::get('/emails/getEmails/{Clientid}/{Surveyid}', [EmailsController::class, 'getEmails'])->name('emails.getEmails')->middleware(['auth', 'role:admin']);
Route::get('/emails/ExportEmails/{Clientid}/{Surveyid}', [EmailsController::class, 'ExportEmails'])->name('emails.ExportEmails')->middleware(['auth', 'role:admin']);
Route::resource('emails', EmailsController::class)->middleware(['auth', 'role:admin']);
Route::resource('emails', EmailsController::class)->middleware(['auth', 'role:admin']);
Route::post('/emails/search', [EmailsController::class, 'search'])->name('emails.search')->middleware(['auth', 'role:admin']);
Route::post('/emails/saveUpload', [EmailsController::class, 'saveUpload'])->name('emails.saveUpload')->middleware(['auth', 'role:admin']);
Route::post('/emails/saveUploadZ', [EmailsController::class, 'saveUploadZ'])->name('emails.saveUploadZ')->middleware(['auth', 'role:admin']);
//post route for copy email
Route::post('/emails/copy', [EmailsController::class, 'copy'])->name('emails.copy')->middleware(['auth', 'role:admin']);

Route::put('surveys/updateOEQ/{id}/{survey}', [SurveysController::class, 'UpdateOpenEndedQ'])->name('surveys.UpdateOpenEndedQ')->middleware(['auth', 'role:admin']);
Route::post('surveys/newOEQ/{survey}', [SurveysController::class, 'SaveOpenEndedQ'])->name('surveys.SaveOpenEndedQ')->middleware(['auth', 'role:admin']);
Route::get('surveys/EditOEQ/{id}/{survey}', [SurveysController::class, 'EditOpenEndedQ'])->name('surveys.EditOpenEndedQ')->middleware(['auth', 'role:admin']);
Route::get('surveys/addNewOEQ/{id}', [SurveysController::class, 'addOpenEndedQ'])->name('surveys.addOpenEndedQ')->middleware(['auth', 'role:admin']);
Route::get('surveys/DownloadPriorities/{id}', [SurveysController::class, 'DownloadPriorities'])->name('surveys.DownloadPriorities')->middleware(['auth', 'role:admin']);
Route::get('surveys/DownloadSurvey/{id}/{type}/{type_id?}', [SurveysController::class, 'DownloadSurvey'])->name('surveys.DownloadSurvey')->middleware(['auth', 'role:admin']);
Route::get('surveys/CreateNewSurvey/{id}', [SurveysController::class, 'CreateNewSurvey'])->name('surveys.CreateNewSurvey')->middleware(['auth', 'role:admin']);
Route::get('surveys/getOEQ/{id}', [SurveysController::class, 'getOEQ'])->name('surveys.getOEQ')->middleware(['auth', 'role:admin']);
Route::post('surveys/ChangeCheck', [SurveysController::class, 'ChangeCheck'])->name('surveys.ChangeCheck')->middleware(['auth', 'role:admin']);
Route::resource('surveys', SurveysController::class)->middleware(['auth', 'role:admin']);

Route::get('survey-answers/freeSurveyResult/{id}', [SurveyAnswersController::class, 'ShowFreeResult'])->name('survey-answers.freeSurveyResult');
Route::resource('survey-answers', SurveyAnswersController::class)->middleware(['auth', 'role:admin']);
Route::get('/survey-answers/result/{id}', [SurveyAnswersController::class, 'result'])->name('survey-answers.result')->middleware(['auth', 'role:admin']);
Route::get('/survey-answers/alzubair_result/{id}/{type}/{type_id?}', [SurveyAnswersController::class, 'alzubair_result'])->name('survey-answers.alzubair_result')->middleware(['auth', 'role:admin']);
Route::get('/survey-answers/alzubair_resultC/{id}/{type}/{type_id?}', [SurveyAnswersController::class, 'alzubair_resultC'])->name('survey-answers.alzubair_resultC')->middleware(['auth', 'role:admin']);
Route::get('/survey-answers/alzubair_resultD/{id}/{type}/{type_id?}', [SurveyAnswersController::class, 'alzubair_resultD'])->name('survey-answers.alzubair_resultD')->middleware(['auth', 'role:admin']);
Route::get('/survey-answers/statistics/{id}/{Clientid}', [SurveyAnswersController::class, 'statistics'])->name('survey-answers.statistics')->middleware(['auth', 'role:admin']);
Route::get('/statistics/{id}/{Clientid}', [StatisticsController::class, 'index'])->name('survey.statistics')->middleware(['auth', 'role:statisticsViewer']);
Route::get('/Client/AddEmail/{Clientid}/{Surveyid}', [StatisticsController::class, 'AddNewEmails'])->name('Client.AddEmail')->middleware(['auth', 'role:statisticsViewer']);
Route::get('Client/getDepForSelect/{id}',[StatisticsController::class,'GetDepForSelect'])->name('client.departmentsGetSelect')->middleware(['auth', 'role:statisticsViewer']);
Route::get('Client/getCompForSelect/{id}',[StatisticsController::class,'GetCompForSelect'])->name('client.companiesGetSelect')->middleware(['auth', 'role:statisticsViewer']);
Route::post('Client/saveEamil',[StatisticsController::class,'saveEamil'])->name('client.saveEamil')->middleware(['auth', 'role:statisticsViewer']);
Route::get('/survey-answers/resultPDF/{id}/{type}/{type_id?}', [SurveyAnswersController::class, 'resultPDF'])->name('survey-answers.resultPDF')->middleware(['auth', 'role:admin']);
Route::get('/survey-answers/SectorResult/{id}/{sctor}', [SurveyAnswersController::class, 'SectorResult'])->name('survey-answers.SectorResult')->middleware(['auth', 'role:admin']);
Route::get('/survey-answers/CompanyResult/{id}/{company}', [SurveyAnswersController::class, 'CompanyResult'])->name('survey-answers.CompanyResult')->middleware(['auth', 'role:admin']);
Route::get('/survey-answers/DepartmentResult/{id}/{dep}', [SurveyAnswersController::class, 'DepartmentResult'])->name('survey-answers.DepartmentResult')->middleware(['auth', 'role:admin']);
// Route::get('/survey-answers/free-result/{id}', [SurveyAnswersController::class,'free-result'])->name('survey-answers.free-result')->middleware(['auth', 'role:admin']);

Route::resource('priorities-answers', PrioritiesAnswersController::class)->middleware(['auth', 'role:admin']);
Route::get('/service-request', [RequestServiceController::class, 'index'])->middleware(['auth', 'role:admin'])->name('service-request.index');
Route::get('/service-request/{id}', [RequestServiceController::class, 'show'])->middleware(['auth', 'role:admin'])->name('service-request.show');
Route::post('/service-request/store', [RequestServiceController::class, 'store'])->name('service-request.store');
Route::get('/service-request/create', [RequestServiceController::class, 'create'])->name('service-request.create');
Route::get('/service-request/add_client/{id}', [RequestServiceController::class, 'addClient'])->name('request-service.add_client')->middleware(['auth', 'role:admin']);
Route::get('sectors/getClientsSectors/{id}', [SectorsController::class, 'getClientsSectors'])->name('sectors.getClientsSectors');
Route::resource('sectors', SectorsController::class);
//companies.getClientsCompanies
Route::get('companies/getClientsCompanies/{id}', [CompaniesController::class, 'getClientsCompanies'])->name('companies.getClientsCompanies');
Route::resource('companies',CompaniesController::class);
Route::resource('departments',DepartmentsController::class);
Route::POST('/getCompanies/{id}',[CompaniesController::class,'GetCompanies'])->name('getCompanies');
Route::POST('/getDeps/{id}',[CompaniesController::class,'GetDeps'])->name('getDeps');
Route::get('departments/getClientsDepartments/{id}',[DepartmentsController::class,'getClientsDepartments'])->name('departments.getClientsDepartments');
Route::get('departments/getForSelect/{id}',[DepartmentsController::class,'GetForSelect'])->name('departments.getSelect')->middleware(['auth', 'role:admin']);
Route::get('companies/getForSelect/{id}',[CompaniesController::class,'GetForSelect'])->name('companies.getSelect')->middleware(['auth', 'role:admin']);
// route to change language
Route::get('lang/{locale}', function () {

    session()->put('locale', request()->locale);
    return redirect()->back();
})->name('lang.swap');
// Route::get('/testing/migrate', function () {
//     Artisan::call('migrate:fresh --seed');
//     $dd_output = Artisan::output();
//     dd($dd_output);
// });
Route::get('/testing/optimize', function () {
    Artisan::call('optimize');
    $dd_output = Artisan::output();
    dd($dd_output);
});

// Route::get('/testing/seed', function () {
//     Artisan::call('db:seed');
//     $dd_output = Artisan::output();
//     dd($dd_output);
// });
