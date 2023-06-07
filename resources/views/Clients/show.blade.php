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
                            class="btn btn-success btn-sm {{ App()->getLocale()=='ar'? 'float-start':'float-end' }}">Edit</a>

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
                                                                    <td colspan="10" class="">
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
                                                                    <th scope="">{{ __('Respondents') }}</th>
                                                                    <th scope="">{{ __('Send Remainder') }}</th>
                                                                    <th scope="">{{ __('Send Survey') }}</th>
                                                                    <th scope="">{{ __('Result') }}</th>
                                                                    <th scope="">{{ __('Survey Actions') }}</th>
                                                                </tr>
                                                            </thead>
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
                                                                    <th scope="">{{ __('Sector Actions') }}</th>
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
                                                            <th>{{ __('Company Actions') }}</th>
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
                                                            <th>{{ __('Department Actions') }}</th>
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
<div class="modal fade" id="RespondentEmails" aria-hidden="true" aria-labelledby="RespondentEmailsLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered ">
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
                                <td colspan="4"> <a href="#" id="CreateEmailUrl"
                                        class="btn btn-sm btn-success float-end">{{ __('Add Emails') }}</a>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('#') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Type') }}</th>

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
                        <h1 class="modal-title fs-5 float-end" id="CreateNewCompnyLabel">{{ __('Create Company') }}
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
                                <button type="submit" class="btn btn-primary">{{ __('Create Company') }}</button>
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
                <h5 class="modal-title" id="CreateNewDepartmentLabel">{{ __('Create New Department') }}</h5>
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
                                <button type="submit" class="btn btn-primary">{{ __('Create Department') }}</button>
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
        //surveysDataTable
        $('#surveysDataTable').DataTable({
            processing: true,
            serverSide: true,
            bDestroy: true,
            ajax: "{{ route('clients.getClients',$client->id) }}",
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'SurveyTitle', name: 'SurveyTitle'},
            {data: 'PlanId', name: 'PlanId'},
            {data: 'SurveyStat', name: 'SurveyStat'},
            {data: 'created_at', name: 'created_at'},
            {data: 'respondents', name: 'respondents'},
            {data: 'send_survey', name: 'send_survey'},
        {data: 'send_reminder', name: 'send_reminder'},
               {data: 'survey_result',name: 'survey_result' },
               {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
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
$("#GetSurveys").click(function(){
    console.log("{{ $client->id }}");
    $('#surveysDataTable').DataTable({
        processing: true,
        serverSide: true,
        bDestroy: true,
        ajax: "{{ route('clients.getClients',$client->id) }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'SurveyTitle', name: 'SurveyTitle'},
            {data: 'PlanId', name: 'PlanId'},
            {data: 'SurveyStat', name: 'SurveyStat'},
            {data: 'created_at', name: 'created_at'},
             {data: 'respondents', name: 'respondents'},
            {data: 'send_survey', name: 'send_survey'},
            {data: 'send_reminder', name: 'send_reminder'},
               {data: 'survey_result',name: 'survey_result' },
               {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        $('#surveysDataTable').css('width', '100%');
    })
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
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    }

</script>
@endsection
