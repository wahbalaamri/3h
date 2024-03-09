{{-- extends --}}
@extends('layouts.main')

{{-- content --}}
{{-- show client details --}}
@section('content')
<div class="container-fluid pt-5 mt-5">
    <div class="row">
        <div class="col-2">
            <!-- side bar menu -->
            @include('layouts.sidebar')
        </div>
        <div class="col-10">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="">
                        <h3 class="card-title {{ App()->getLocale()=='ar'? 'float-end':'float-start' }}">{{ __('Client
                            Details') }}</h3>

                        <a href="{{ route('clients.edit', $client->id) }}"
                            class="btn btn-success btn-sm {{ App()->getLocale()=='ar'? 'float-start':'float-end' }}">{{
                            __('Edit') }}</a>

                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <div class="card">
                                <img src="{{ asset('assets/img/partnership-logo.png') }}" class="card-img-top"
                                    alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $client->ClientName }}</h5>
                                    <p class="card-text"><b>{{ __('Focal Point name:') }}</b>{{ $client->CilentFPName }}
                                    </p>
                                    <p class="card-text"><b>{{ __('Focal Point Email:') }}</b>{{ $client->CilentFPEmil
                                        }}</p>
                                    <p class="card-text"><b>{{ __('Client Phone Number:') }} </b>{{ $client->ClientPhone
                                        }}</p>
                                    <button id="GetSurveys" class="btn btn-primary btn-sm">{{ __('Surveys') }}</button>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-9 col-sm-12 mt-3">
                            <div class="row">
                                {{-- create funcy card to display surveys --}}
                                <div class="col-12 mt-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">{{ __('Surveys') }}</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="table-responsive">
                                                        <table id="surveysDataTable"
                                                            class="table table table-bordered data-table">
                                                            <thead>
                                                                <tr>
                                                                    <td colspan="14" class="">
                                                                        <a href="{{ route('surveys.CreateNewSurvey',$client->id) }}"
                                                                            class="btn btn-sm btn-primary {{ App()->getLocale()=='ar'? 'float-start':'float-end' }}">{{
                                                                            __('Create New Survey') }}</a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="">#</th>
                                                                    <th scope="">{{ __('Survey Name') }}</th>
                                                                    <th scope="">{{ __('Plan') }}</th>
                                                                    <th scope="">{{ __('Survey Status') }}</th>
                                                                    <th scope="">{{ __('Survey Date') }}</th>
                                                                    <th scope="">{{ __('Open Ended Questions') }}</th>
                                                                    <th scope="">{{ __('Respondents') }}</th>
                                                                    <th scope="">{{ __('Send Survey') }}</th>
                                                                    <th scope="">{{ __('Send Remainder') }}</th>
                                                                    <th scope="">{{ __('Statistics') }}</th>
                                                                    <th scope="">{{ __('Result') }}</th>
                                                                    <th colspan="3" scope="">{{ __('Survey Actions') }}
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($client->surveys as $survey)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $survey->SurveyTitle }}</td>
                                                                    <td>{{ app()->getLocale()=='ar'?
                                                                        $survey->plan->PlanTitleAr:$survey->plan->PlanTitle
                                                                        }}</td>
                                                                    <td>
                                                                        <div class="form-check form-switch"><input
                                                                                class="form-check-input" type="checkbox"
                                                                                role="switch"
                                                                                id="flexSwitchCheckChecked{{ $survey->id }}"
                                                                                {{ $survey->SurveyStat? 'checked':'' }}
                                                                            onchange="ChangeCheck(this,'{{ $survey->id}}')" ><label class="form-check-label"
                                                                                for="flexSwitchCheckChecked{{ $survey->id }}">{{
                                                                                $survey->SurveyStat?'Active':'In-Active'
                                                                                }}</label></div>
                                                                    </td>
                                                                    <td>{{ $survey->created_at->format('d-m-Y') }}</td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="SetUpOEQ('{{ $survey->id }}')">
                                                                            {{ count($survey->OpenEndQ)==0? 'No Open Ended Questions':count($survey->OpenEndQ).' Open Ended Questions' }}
                                                                          </button>
                                                                        </td>
                                                                    <td>
                                                                        <a data-bs-toggle="modal"
                                                                            href="#RespondentEmails"
                                                                            onclick="GetRespondentsEmails('{{ $survey->id }}')"
                                                                            class="btn btn-success btn-sm"> {{
                                                                            __('Respondents') }}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="/emails/send-survey/{{ $survey->id }}/{{ $survey->ClientId }}"
                                                                            class="btn btn-success btn-sm">{{
                                                                            __('Survey') }}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="/emails/send-reminder/{{ $survey->id }}/{{ $survey->ClientId }}"
                                                                            class="btn btn-info btn-sm ">{{
                                                                            __('Reminder') }}</a>
                                                                    </td>

                                                                    <td>
                                                                        <a href="{{ route('survey-answers.statistics',  [ $survey->id,$survey->ClientId ]) }}"
                                                                            class="btn btn-secondary btn-sm">{{ __('Statistics')
                                                                            }}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('survey-answers.result',  [$survey->id,'all']) }}{{-- {{ route('survey-answers.result',  $survey->id) }} --}}"
                                                                            class="btn btn-info btn-sm">{{ __('Result')
                                                                            }}</a>
                                                                    </td>
                                                                    <td><a href="{{route('surveys.show', $survey->id)}}"
                                                                            class="edit btn btn-primary btn-sm m-1"><i
                                                                                class="fa fa-eye"></i></a></td>
                                                                    <td><a href="{{ route('surveys.edit', $survey->id)}}"
                                                                            class="edit btn btn-primary btn-sm m-1"><i
                                                                                class="fa fa-edit"></i></a></td>
                                                                    <td>
                                                                        <form
                                                                            action="{{route('surveys.destroy', $survey->id)}}"
                                                                            method="POST" class="delete_form"
                                                                            style="display:inline"><input type="hidden"
                                                                                name="_method"
                                                                                value="DELETE">@csrf<button
                                                                                type="submit"
                                                                                class="btn btn-danger btn-sm m-1"><i
                                                                                    class="fa fa-trash"></i></button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    {{-- create funcy card to sectors --}}
                                    <div class="card">
                                        {{-- header --}}
                                        <div class="card-header">
                                            <h3 class="card-title">{{ __('Sectors') }}</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="table-responsive">
                                                        <table id="sectorsDataTable"
                                                            class="table table table-bordered data-table">
                                                            <thead>
                                                                <tr>
                                                                    <td colspan="5" class="">
                                                                        <a data-bs-toggle="modal" href="#ClientSector"
                                                                            class="btn btn-sm btn-primary {{ App()->getLocale()=='ar'? 'float-start':'float-end' }}">{{
                                                                            __('Create New Sector') }}</a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="">#</th>
                                                                    <th scope="">{{ __('Sector Name') }}</th>
                                                                    <th scope="">{{ __('Sector Companies') }}</th>
                                                                    <th scope="">{{ __('Actions') }}</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Sector Companies --}}
                                <div class="col-12 mt-3" style="display: none" id="viewComp">
                                    {{-- create funcy card to sectors --}}
                                    <div class="card">
                                        {{-- header --}}
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <h4
                                                        class="card-title {{ App()->getLocale()=='ar'?'float-end':'float-start' }}">
                                                        {{ __('Sector Companies') }}</h4>
                                                </div>
                                                <div class="col-sm-6">
                                                    <button type="button"
                                                        class="btn-close {{ App()->getLocale()=='ar'?'float-start':'float-end' }}"
                                                        data-bs-dismiss="modal"
                                                        onclick="$('#viewComp').hide()"></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="Companies-data-table"
                                                    class="table table-bordered data-table">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="4"> <a href="#CreateNewCompny"
                                                                    id="CreateCompanyUrl" data-bs-toggle="modal"
                                                                    class="btn btn-sm btn-success float-end">{{ __('Add
                                                                    Company') }}</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>{{ __('#') }}</th>
                                                            <th>{{ __('Company Name') }}</th>
                                                            <th>{{ __('Departments') }}</th>
                                                            <th>{{ __('Actions') }}</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Departments --}}
                                <div class="col-12 mt-3" style="display: none" id="viewDept">
                                    {{-- create funcy card to Departments --}}
                                    <div class="card">
                                        {{-- header --}}
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <h4
                                                        class="card-title {{ App()->getLocale()=='ar'?'float-end':'float-start' }}">
                                                        {{ __('Departments') }}</h4>
                                                </div>
                                                <div class="col-sm-6">
                                                    <button type="button"
                                                        class="btn-close {{ App()->getLocale()=='ar'?'float-start':'float-end' }}"
                                                        data-bs-dismiss="modal"
                                                        onclick="$('#viewDept').hide()"></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="Departments-data-table"
                                                    class="table table-bordered data-table">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="4"> <a href="#CreateNewDepartment"
                                                                    id="CreateDeptUrl" data-bs-toggle="modal"
                                                                    class="btn btn-sm btn-success float-end">{{ __('Add
                                                                    Department') }}</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>{{ __('#') }}</th>
                                                            <th>{{ __('Department Name') }}</th>
                                                            <th>{{ __('Actions') }}</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ __('open ended Questions') }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div id="OEQuestions" class="table-responsive">
                <table id="OEQuestions-data-table" class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <td colspan="4"> <a href="#" id="CreateAddOEQUrl"
                                    class="btn btn-sm btn-success float-end">{{ __('Add Open Ended Question') }}</a>
                            </td>
                        </tr>
                        <tr>
                            <th>{{ __('#') }}</th>
                            <th>{{ __('Question in English') }}</th>
                            <th>{{ __('Question in Arabic') }}</th>
                            <th>{{ __('Question in Hindi') }}</th>
                            <th colspan="2">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

        </div>
      </div>
    </div>
  </div>
<div class="modal fade" id="RespondentEmails" aria-hidden="true" aria-labelledby="RespondentEmailsLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="RespondentEmailsLabel">{{ __('Respondent Emails') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="Emails" class="table-responsive">
                    <table id="Emails-data-table" class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <td colspan="2"> <a href="#" id="ExprotRespondents"
                                        class="btn btn-sm btn-success float-start">{{ __('Exprot Respondents') }}</a>
                                </td>
                                <td colspan="3"> <a href="#" id="CreateEmailUrl"
                                        class="btn btn-sm btn-success float-end">{{ __('Add Emails') }}</a>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('#') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Send Survey Individually') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
{{-- create modal to add create Sector --}}
<div class="modal fade" id="ClientSector" aria-hidden="true" aria-labelledby="ClientSectorLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="ClientSectorLabel">{{ __('Create Sector') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- create form to add create Sector --}}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="ClientSectorForm" class="form-horizontal" method="POST"
                                    action="{{ route('sectors.store') }}">
                                    @csrf
                                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">{{ __('Sector Name in English') }}</label>
                                                <input type="text" id="name_en" class="form-control" name="name_en"
                                                    value="{{ old('name_en') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">{{ __('Sector Name in Arabic') }}</label>
                                                <input type="text" id="name_ar" class="form-control" name="name_ar"
                                                    value="{{ old('name_ar') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-1">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-sm btn-primary">{{ __('Create
                                                    Sector') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- create modale to create New company --}}
<div class="modal fade" id="CreateNewCompny" tabindex="-1" aria-labelledby="CreateNewCompnyLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-6">
                        <h1 class="modal-title fs-5 float-end" id="CreateNewCompnyLabel">{{ __('Add New Company') }}
                        </h1>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn-close float-start" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                </div>
            </div>
            {{-- create form to add create Company --}}
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form id="CreateNewCompnyForm" method="post" action="{{ route('companies.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="sector_id" id="sector_id" value="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="company_name_en" class="form-label">{{ __('Company Name in English')
                                            }}</label>
                                        <input type="text" class="form-control" id="company_name_en"
                                            name="company_name_en" value="{{ old('company_name_en') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="company_name_ar" class="form-label">{{ __('Company Name in Arabic')
                                            }}</label>
                                        <input type="text" class="form-control" id="company_name_ar"
                                            name="company_name_ar" value="{{ old('company_name_ar') }}" required>
                                    </div>
                                </div>
                            </div>
                            {{-- submit button --}}
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- create modal to Create Department --}}
<div class="modal fade" id="CreateNewDepartment" tabindex="-1" aria-labelledby="CreateNewDepartmentLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="CreateNewDepartmentLabel">{{ __('Add New Department') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- create form to add create Department --}}
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form id="CreateNewDepartmentForm" method="post" action="{{ route('departments.store') }}">
                            @csrf
                            <input type="hidden" name="company_id" id="company_id" value="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="department_name_en" class="form-label">{{ __('Department Name in
                                            English')
                                            }}</label>
                                        <input type="text" class="form-control" id="department_name_en"
                                            name="department_name_en" value="{{ old('department_name_en') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="department_name_ar" class="form-label">{{ __('Department Name in
                                            Arabic')
                                            }}</label>
                                        <input type="text" class="form-control" id="department_name_ar"
                                            name="department_name_ar" value="{{ old('department_name_ar') }}">
                                    </div>
                                </div>
                                {{-- parent department --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="parent_department_id" class="form-label">{{ __('Parent
                                            Department')}}
                                        </label>
                                        <select class="form-control" name="parent_department_id"
                                            id="parent_department_id">
                                            <option value="">{{ __('Select') }}</option>
                                            @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">
                                                {{App()->getLocale()=='ar'?$department->dep_name_ar:
                                                $department->dep_name_en }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- submit button --}}
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
    var GetCompaniesURl='';
    $(document).ready(function() {
        // console.log("{{ route('clients.getClients',$client->id) }}");
        //surveysDataTable
        // $('#surveysDataTable').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     bDestroy: true,
        //     ajax: "{{ route('clients.getClients',$client->id) }}",
        //     columns: [
        //     {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        //     {data: 'SurveyTitle', name: 'SurveyTitle'},
        //     {data: 'PlanId', name: 'PlanId'},
        //     {data: 'SurveyStat', name: 'SurveyStat'},
        //     {data: 'created_at', name: 'created_at'},
        //     // {data: 'respondents', name: 'respondents'},
        //     {data: 'send_survey', name: 'send_survey'},
        //     // {data: 'send_reminder', name: 'send_reminder'},
        //     {data: 'survey_result',name: 'survey_result' },
        //     {data: 'action', name: 'action', orderable: false, searchable: false},
        //     ]
        // });
        $('#sectorsDataTable').DataTable({
            processing: true,
            serverSide: true,
            bDestroy: true,
            ajax: "{{ route('sectors.getClientsSectors',$client->id) }}",
            columns:
            [
                {data: 'DT_RowIndex',name: 'DT_RowIndex'},
                {data: 'SectorName',name: 'SectorName'},
                {data: 'view_companies',name: 'view_companies'},
                {data: 'action',name: 'action',orderable: false,searchable: false},
            ]
        });
        // make sectorsDataTable width 100%
        $('#surveysDataTable').css('width', '100%');
        $('#sectorsDataTable').css('width', '100%');
        // make CompaniesDataTable width 100%
        $('#Companies-data-table').css('width', '100%');
        // make Companies-data-table width 100%
        $('#Companies-data-table').css('width', '100%');
        //Companies-data-table

    });
    viewCompanies=(id)=>{
        $("#viewComp").show();
        $('#sector_id').val(id);
        $('#Companies-data-table').DataTable({
                //get data-bs-id
                processing: true,
                serverSide: true,
                bDestroy: true,
                ajax: "{{ url('companies/getClientsCompanies') }}/"+id,
                columns:
                [
                    {data: 'DT_RowIndex',name: 'DT_RowIndex'},
                    {data: 'CompanyName',name: 'CompanyName'},
                    {data: 'Departments',name: 'Departments'},
                    {data: 'action',name: 'action',orderable: false,searchable: false},
                ]
            });
    }
    ShowDeps=(id)=>{
        //toggle viewDept
        $("#company_id").val(id);
        $("#viewDept").show();
        //yajra datatable Departments-data-table
        $('#Departments-data-table').DataTable({
                //get data-bs-id
                processing: true,
                serverSide: true,
                bDestroy: true,
                ajax: "{{ url('departments/getClientsDepartments') }}/"+id,
                columns:
                [
                    {data: 'DT_RowIndex',name: 'DT_RowIndex'},
                    {data: 'DepartmentName',name: 'DepartmentName'},
                    {data: 'action',name: 'action',orderable: false,searchable: false},
                ]
            });
    }
// $("#GetSurveys").click(function(){
//     console.log("{{ $client->id }}");
//     $('#surveysDataTable').DataTable({
//         processing: true,
//         serverSide: true,
//         bDestroy: true,
//         ajax: "{{ route('clients.getClients',$client->id) }}",
//         columns: [
//             {data: 'DT_RowIndex', name: 'DT_RowIndex'},
//             {data: 'SurveyTitle', name: 'SurveyTitle'},
//             {data: 'PlanId', name: 'PlanId'},
//             {data: 'SurveyStat', name: 'SurveyStat'},
//             {data: 'created_at', name: 'created_at'},
//              {data: 'respondents', name: 'respondents'},
//             {data: 'send_survey', name: 'send_survey'},
//             {data: 'send_reminder', name: 'send_reminder'},
//                {data: 'survey_result',name: 'survey_result' },
//                {data: 'action', name: 'action', orderable: false, searchable: false},
//             ]
//         });
//         $('#surveysDataTable').css('width', '100%');
//     })
 ChangeCheck =(current,id)=>{

    //check if current checkbox checked
    if(current.checked){

        $("label[for='"+current.id+"']").html("Active");
    }
    else{
        $("label[for='"+current.id+"']").html("In-Active");
    }
    $.ajax({
        url: "{{ route('surveys.ChangeCheck') }}",
        type: "POST",
        data: {
            "_token": "{{ csrf_token() }}",
            "id": id,
        },
        success: function(response) {
            if (response.status == 200) {
                toastr.success(response.message);
                //reload datatable
                $('#surveysDataTable').DataTable().ajax.reload();
            } else {
                toastr.error(response.message);
            }
        }
    });
 }
    GetRespondentsEmails =(id)=>{
        //set create url
        $("#CreateEmailUrl").attr("href","{{ url('emails/CreateNewEmails')}}/{{ $client->id }}/"+id);
        $("#ExprotRespondents").attr("href","{{ url('emails/ExportEmails')}}/{{ $client->id }}/"+id);
        //Emails-data-table
        $('#Emails-data-table').DataTable({
            processing: true,
            serverSide: true,
            bDestroy: true,
            ajax: "{{ url('emails/getEmails')}}/{{ $client->id }}/"+id,
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'Email',
                    name: 'Email'
                },
                {
                    data: 'EmployeeType',
                    name: 'EmployeeType'
                },
                {
                    data: 'SendSurvey',
                    name: 'SendSurvey',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        $("#Emails-data-table").css('width', '100%');
    }
    SetUpOEQ=(id)=>{
        $("#CreateAddOEQUrl").attr('href',"{{ url('surveys/addNewOEQ') }}/"+id);
        //OEQuestions-data-table
        $('#OEQuestions-data-table').DataTable({
            processing: true,
            serverSide: true,
            bDestroy: true,
            ajax: "{{ url('surveys/getOEQ')}}/"+id,
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'question',
                    name: 'question'
                },
                {
                    data: 'question_ar',
                    name: 'question_ar'
                },
                {
                    data: 'question_in',
                    name: 'question_in'
                },

            ]
        });
    }

</script>
@endsection
