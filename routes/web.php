<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home;
use App\Http\Controllers\UsersController;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/survey/{id}', [App\Http\Controllers\QuestionnairController::class, 'index'])->name('survey');
Route::get('/FreeSurvey', [App\Http\Controllers\QuestionnairController::class, 'fressSurvey'])->name('FreeSurvey');
Route::post('/questionnair/saveAnswer', [App\Http\Controllers\QuestionnairController::class, 'saveAnswer'])->name('questionnair.saveAnswer');

Auth::routes();
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::post('/functions/change-status', [App\Http\Controllers\PartnerShipPlansController::class,'changeStatus'])->middleware('auth');
Route::resource('partner-ship-plans', App\Http\Controllers\PartnerShipPlansController::class)->middleware('auth');
Route::get('/partner-ship-plans/getPlan/{id}', [App\Http\Controllers\PartnerShipPlansController::class, 'getPlan'])->name('partner-ship-plans.getPlan')->middleware('auth');

Route::get('/functions/save', [App\Http\Controllers\FunctionsController::class, 'savefunctions'])->name('functions.save')->middleware('auth');

Route::get('/functions/getfunctions/{id}', [App\Http\Controllers\FunctionsController::class, 'getfunctions'])->name('functions.getfunctions')->middleware('auth');
Route::resource('functions', App\Http\Controllers\FunctionsController::class)->middleware('auth');
Route::get('/functions/FunctionsWithPlan/{id}', [App\Http\Controllers\FunctionsController::class, 'FunctionsWithPlan'])->name('functions.FunctionsWithPlan')->middleware('auth');
Route::post('/functions/search', [App\Http\Controllers\FunctionsController::class, 'search'])->name('functions.search')->middleware('auth');
// Route::get('/functions/pullData', [App\Http\Controllers\FunctionsController::class, 'pullData'])->name('functions.pullData');

Route::get('/function-practice/getpractices/{id}', [App\Http\Controllers\FunctionPracticeController::class, 'getpractices'])->name('function-practice.getpractices')->middleware('auth');
Route::get('/function-practice/save', [App\Http\Controllers\FunctionPracticeController::class, 'savePractices'])->name('function-practice.save')->middleware('auth');
Route::resource('function-practice', App\Http\Controllers\FunctionPracticeController::class)->middleware('auth');
Route::post('/function-practice/search', [App\Http\Controllers\FunctionPracticeController::class, 'search'])->name('function-practice.search')->middleware('auth');
Route::get('/function-practice/GetFunctions/{id}', [App\Http\Controllers\FunctionPracticeController::class, 'GetFunctions'])->name('function-practice.GetFunctions')->middleware('auth');

Route::resource('practice-questions', App\Http\Controllers\PracticeQuestionsController::class)->middleware('auth');
Route::post('/practice-questions/search', [App\Http\Controllers\PracticeQuestionsController::class, 'search'])->name('practice-questions.search')->middleware('auth');
Route::get('/practice-questions/GetPractice/{id}', [App\Http\Controllers\PracticeQuestionsController::class, 'GetPractice'])->name('practice-questions.GetPractice')->middleware('auth');
Route::get('/practice-questions/getquestions/{id}', [App\Http\Controllers\PracticeQuestionsController::class, 'getQuestions'])->name('practice-questions.getquestions')->middleware('auth');
Route::get('/practice-questions/CreateNewQuestion/{id}', [App\Http\Controllers\PracticeQuestionsController::class, 'CreateNewQuestion'])->name('practice-questions.CreateNewQuestion')->middleware('auth');
Route::post('/practice-questions/SaveNewQuestion/{id}', [App\Http\Controllers\PracticeQuestionsController::class, 'SaveNewQuestion'])->name('practice-questions.SaveNewQuestion')->middleware('auth');
// save remote data
Route::post('/practice-questions/save/{id}', [App\Http\Controllers\PracticeQuestionsController::class, 'saveQuestions'])->name('practice-questions.save')->middleware('auth');

Route::get('/clients/getClients/{id}', [App\Http\Controllers\ClientsController::class,'getClients'])->name('clients.getClients')->middleware('auth');
Route::resource('clients', App\Http\Controllers\ClientsController::class)->middleware('auth');
Route::get('users/changePassword/{id}', [UsersController::class,'changePassword'])->name('users.changePassword')->middleware('auth');
Route::post('users/storeNewPass/{id}', [UsersController::class,'storeNewPass'])->name('users.storeNewPass')->middleware('auth');
Route::resource('users', App\Http\Controllers\UsersController::class)->middleware('auth');

Route::get('/emails/send-survey/{Surveyid}/{Clientid}', [App\Http\Controllers\EmailsController::class, 'sendSurveyw'])->name('emails.Ssurvey')->middleware('auth');
Route::get('/emails/send-reminder/{Surveyid}/{Clientid}', [App\Http\Controllers\EmailsController::class, 'sendReminder'])->name('emails.send-reminder')->middleware('auth');
Route::post('/emails/sendTheSurvey', [App\Http\Controllers\EmailsController::class, 'sendTheSurvey'])->name('emails.sendTheSurvey')->middleware('auth');
Route::get('/emails/manage', [App\Http\Controllers\EmailsController::class, 'manage'])->name('emails.manage')->middleware('auth');
Route::get('/emails/CreateContent', [App\Http\Controllers\EmailsController::class, 'CreateContent'])->name('emails.CreateContent')->middleware('auth');
Route::get('/emails/ViewContent/{id}', [App\Http\Controllers\EmailsController::class, 'ViewContent'])->name('emails.ViewContent')->middleware('auth');
Route::get('/emails/EditContent', [App\Http\Controllers\EmailsController::class, 'EditContent'])->name('emails.EditContent')->middleware('auth');
Route::post('/emails/StoreContent', [App\Http\Controllers\EmailsController::class, 'StoreContent'])->name('emails.StoreContent')->middleware('auth');
Route::post('/emails/UpdateContent', [App\Http\Controllers\EmailsController::class, 'UpdateContent'])->name('emails.UpdateContent')->middleware('auth');
Route::post('/emails/Delete', [App\Http\Controllers\EmailsController::class, 'Delete'])->name('emails.Delete')->middleware('auth');
Route::get('/emails/SendSurvey/{id}', [App\Http\Controllers\EmailsController::class, 'SendSurvey'])->name('emails.SendSurvey')->middleware('auth');
Route::get('/emails/CreateNewEmails/{Clientid}/{Surveyid}', [App\Http\Controllers\EmailsController::class, 'CreateNewEmails'])->name('emails.CreateNewEmails')->middleware('auth');
Route::get('/emails/getEmails/{Clientid}/{Surveyid}', [App\Http\Controllers\EmailsController::class, 'getEmails'])->name('emails.getEmails')->middleware('auth');
Route::resource('emails', App\Http\Controllers\EmailsController::class)->middleware('auth');
Route::resource('emails', App\Http\Controllers\EmailsController::class)->middleware('auth');
Route::post('/emails/search', [App\Http\Controllers\EmailsController::class, 'search'])->name('emails.search')->middleware('auth');
Route::post('/emails/saveUpload', [App\Http\Controllers\EmailsController::class, 'saveUpload'])->name('emails.saveUpload')->middleware('auth');
//post route for copy email
Route::post('/emails/copy', [App\Http\Controllers\EmailsController::class, 'copy'])->name('emails.copy')->middleware('auth');

Route::get('surveys/DownloadPriorities/{id}', [App\Http\Controllers\SurveysController::class,'DownloadPriorities'])->name('surveys.DownloadPriorities')->middleware('auth');
Route::get('surveys/DownloadSurvey/{id}', [App\Http\Controllers\SurveysController::class,'DownloadSurvey'])->name('surveys.DownloadSurvey')->middleware('auth');
Route::get('surveys/CreateNewSurvey/{id}', [App\Http\Controllers\SurveysController::class,'CreateNewSurvey'])->name('surveys.CreateNewSurvey')->middleware('auth');
Route::post('surveys/ChangeCheck', [App\Http\Controllers\SurveysController::class,'ChangeCheck'])->name('surveys.ChangeCheck')->middleware('auth');
Route::resource('surveys', App\Http\Controllers\SurveysController::class)->middleware('auth');

Route::get('survey-answers/freeSurveyResult/{id}', [App\Http\Controllers\SurveyAnswersController::class,'ShowFreeResult'])->name('survey-answers.freeSurveyResult');
Route::resource('survey-answers', App\Http\Controllers\SurveyAnswersController::class)->middleware('auth');
Route::get('/survey-answers/result/{id}', [App\Http\Controllers\SurveyAnswersController::class,'result'])->name('survey-answers.result')->middleware('auth');
// Route::get('/survey-answers/free-result/{id}', [App\Http\Controllers\SurveyAnswersController::class,'free-result'])->name('survey-answers.free-result')->middleware('auth');

Route::resource('priorities-answers', App\Http\Controllers\PrioritiesAnswersController::class)->middleware('auth');
Route::get('/service-request', [App\Http\Controllers\RequestServiceController::class,'index'])->middleware('auth')->name('service-request.index');
Route::get('/service-request/{id}', [App\Http\Controllers\RequestServiceController::class,'show'])->middleware('auth')->name('service-request.show');
Route::post('/service-request/store', [App\Http\Controllers\RequestServiceController::class,'store'])->name('service-request.store');
Route::get('/service-request/create', [App\Http\Controllers\RequestServiceController::class,'create'])->name('service-request.create');
Route::get('/service-request/add_client/{id}', [App\Http\Controllers\RequestServiceController::class,'addClient'])->name('request-service.add_client')->middleware('auth');
Route::get('/testing/migrate', function () {
    Artisan::call('migrate:fresh');
    $dd_output = Artisan::output();
    dd($dd_output);
});
Route::get('/testing/optimize', function () {
    Artisan::call('optimize');
    $dd_output = Artisan::output();
    dd($dd_output);
});

Route::get('/testing/seed', function () {
    Artisan::call('db:seed');
    $dd_output = Artisan::output();
    dd($dd_output);
});
