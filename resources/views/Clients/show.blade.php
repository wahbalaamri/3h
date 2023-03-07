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
                    <div class="row">
                        <div class="col-6">
                            <h3 class="card-title">Client Details</h3>
                        </div>
                        {{-- edit client button --}}
                        <div class="col-6 text-end">
                            <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-success">Edit</a>
                        </div>
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
                                    <p class="card-text"><b>Focal Point name: </b>{{ $client->CilentFPName }}</p>
                                    <p class="card-text"><b>Focal Point Email: </b>{{ $client->CilentFPEmil }}</p>
                                    <p class="card-text"><b>Client Phone Number: </b>{{ $client->ClientPhone }}</p>
                                    <button id="GetSurveys" class="btn btn-primary btn-sm">Surveys</button>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-9 col-sm-12">
                            <div class="table-responsive">
                                <table id="surveysDataTable" class="table table table-bordered data-table">
                                    <thead>
                                        <tr>
                                            <td colspan="8" class="text-end">
                                                <a href="{{ route('surveys.CreateNewSurvey',$client->id) }}"
                                                    class="btn btn-sm btn-primary">Create New Survey</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="">#</th>
                                            <th scope="">Survey Name</th>
                                            <th scope="">Plan</th>
                                            <th scope="">Survey Status</th>
                                            <th scope="">Survey Date</th>
                                            {{-- <th scope="">Respondents Email</th> --}}
                                            <th scope="">Send Remainder/Survey</th>
                                            {{-- <th scope="">Send Remainder</th> --}}
                                            <th scope="">View Survey Respondents/Result</th>
                                            <th scope="">Survey Actions</th>
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
<div class="modal fade" id="RespondentEmails" aria-hidden="true" aria-labelledby="RespondentEmailsLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="RespondentEmailsLabel">RespondentEmails</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="Emails" class="table-responsive">
                    <table id="Emails-data-table" class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <td colspan="4"> <a href="#" id="CreateEmailUrl"
                                        class="btn btn-sm btn-success float-end">Add Emails</a></td>
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
@endsection
@section('scripts')
<script>
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
                // {data: 'respondents', name: 'respondents'},
                {data: 'send_survey', name: 'send_survey'},
                // {data: 'send_reminder', name: 'send_reminder'},
               {data: 'survey_result',name: 'survey_result' },
                {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

 })
    //Emails-data-table


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
                // {data: 'respondents', name: 'respondents'},
                {data: 'send_survey', name: 'send_survey'},
                // {data: 'send_reminder', name: 'send_reminder'},
               {data: 'survey_result',name: 'survey_result' },
                {data: 'action', name: 'action', orderable: false, searchable: false},
                ]

            });

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
