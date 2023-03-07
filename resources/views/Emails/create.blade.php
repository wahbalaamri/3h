{{-- extends --}}
@extends('layouts.main')

{{-- content --}}
{{-- create Email --}}
@section('content')
<div class="container pt-5 mt-5">
    <div class="row">
        <div class="col-3">
            <!-- side bar menu -->
            @include('layouts.sidebar')
        </div>
        <div class="col-9">
            {{-- add emails manual --}}
            <ul>
                @if ($errors->any())
                {!! implode('', $errors->all('<li class="text text-danger">:message</li>')) !!}
                @endif
            </ul>
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Create Email (Manual)</h3>
                </div>
                <div class="card-body">

                    <form action="{{ route('emails.store') }}" method="POST" class="d-inline" id="oneByone"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="SurveyId">Survey ID</label>
                                    <select name="SurveyId" id="SurveyId"
                                        class="form-control @error('SurveyId') is-invalid @enderror" disabled>
                                        <option value="">Select Survey</option>
                                        @foreach ($surveys as $survey)
                                        <option value="{{ $survey->id }}" @if (old('SurveyId',$surveyId)==$survey->id)
                                            selected @endif>
                                            {{ $survey->SurveyTitle }}</option>
                                        @endforeach
                                    </select>
                                    {{-- validation --}}
                                    @error('SurveyId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="ClientId">Client ID</label>
                                    <select name="ClientId" id="ClientId"
                                        class="form-control @error('ClientId') is-invalid @enderror" disabled>
                                        <option value="">Select Client</option>
                                        @foreach ($clients as $client)
                                        <option value="{{ $client->id }}" @if (old('ClientId',$clientId)==$client->id)
                                            selected @endif>
                                            {{ $client->ClientName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- insert email details --}}
                        <div class="row">
                            {{-- employee email --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="Email">Email</label>
                                    <input type="text" name="Email" id="Email"
                                        class="form-control @error('Email') is-invalid @enderror"
                                        value="{{ old('Email') }}" placeholder="Email">
                                    {{-- validation --}}
                                    @error('Email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- employee type --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="EmployeeType">Employee Type</label>
                                    <select name="EmployeeType" id="EmployeeType"
                                        class="form-control @error('EmployeeType') is-invalid @enderror">
                                        <option value="">Select Employee Type</option>
                                        <option value="1" @if (old('EmployeeType')==1) selected @endif>Manager
                                        </option>
                                        <option value="2" @if (old('EmployeeType')==2) selected @endif>HR Team
                                        </option>
                                        <option value="3" @if (old('EmployeeType')==3) selected @endif>
                                            Employee</option>
                                    </select>
                                    {{-- validation --}}
                                    @error('EmployeeType')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="AddedBy" id="AddedBy"
                            value="{{ Auth::user()->user_type == 'superadmin' ? 0 : Auth::user()->company_id }}">
                        <div class="row text-end mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- add email by upload file --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Create Email (Upload File)</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('emails.saveUpload') }}" method="POST" enctype="multipart/form-data"
                        id="uploadForm" class="d-inline">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="SurveyIdU">Survey ID</label>
                                    <select name="SurveyIdU" id="SurveyIdU"
                                        class="form-control @error('SurveyIdU') is-invalid @enderror" disabled>
                                        <option value="">Select Survey</option>
                                        @foreach ($surveys as $survey)
                                        <option value="{{ $survey->id }}" @if (old('SurveyIdU',$surveyId)==$survey->id)
                                            selected @endif>
                                            {{ $survey->SurveyTitle }}</option>
                                        @endforeach
                                    </select>
                                    {{-- validation --}}
                                    @error('SurveyIdU')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="ClientIdU">Client ID</label>
                                    <select name="ClientIdU" id="ClientIdU"
                                        class="form-control @error('ClientIdU') is-invalid @enderror" disabled>
                                        <option value="">Select Client</option>
                                        @foreach ($clients as $client)
                                        <option value="{{ $client->id }}" @if (old('ClientIdU',$clientId)==$client->id)
                                            selected @endif>
                                            {{ $client->ClientName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label for="EmailFile">Upload File</label>
                                <input type="file" name="EmailFile" id="EmailFile"
                                    class="form-control @error('EmailFile') is-invalid @enderror">
                                {{-- validation --}}
                                @error('EmailFile')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <input type="hidden" name="AddedBy" id="AddedBy"
                            value="{{ Auth::user()->user_type == 'superadmin' ? 0 : Auth::user()->company_id }}">
                        <div class="row text-end mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- copy from previous survey --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Copy From Previous Survey</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('emails.copy') }}" method="POST" class="d-inline" id="CopyFrom">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="SurveyIdC">Old Survey</label>
                                    <select name="SurveyIdC" id="SurveyIdC"
                                        class="form-control @error('SurveyIdC') is-invalid @enderror">
                                        <option value="">Select Survey</option>
                                        @foreach ($surveys as $survey)
                                        @if($survey->id!=$surveyId)
                                        <option value="{{ $survey->id }}" @if (old('SurveyIdC')==$survey->id) selected
                                            @endif>
                                            {{ $survey->SurveyTitle }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    {{-- validation --}}
                                    @error('SurveyIdC')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="ClientIdC">Client ID</label>
                                    <select name="ClientIdC" id="ClientIdC"
                                        class="form-control @error('ClientIdC') is-invalid @enderror" disabled>
                                        <option value="">Select Client</option>
                                        @foreach ($clients as $client)
                                        <option value="{{ $client->id }}" @if (old('ClientIdC',$clientId)==$client->id)
                                            selected @endif>
                                            {{ $client->ClientName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="NewSurveyIdC">New Survey</label>
                                    <select name="NewSurveyIdC" id="NewSurveyIdC"
                                        class="form-control @error('NewSurveyIdC') is-invalid @enderror" disabled>
                                        <option value="">Select Survey</option>
                                        @foreach ($surveys as $survey)
                                        <option value="{{ $survey->id }}" @if (old('NewSurveyIdC',$surveyId)==$survey->
                                            id) selected @endif>
                                            {{ $survey->SurveyTitle }}</option>
                                        @endforeach
                                    </select>
                                    {{-- validation --}}
                                    @error('NewSurveyIdC')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="AddedBy" id="AddedBy"
                            value="{{ Auth::user()->user_type == 'superadmin' ? 0 : Auth::user()->company_id }}">
                        <div class="row text-end mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Copy</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    //CopyFrom from submit
    $('#CopyFrom').submit(function(){
        $("#SurveyIdC").attr('disabled', false);
        $("#NewSurveyIdC").attr('disabled', false);
        $("#ClientIdC").attr('disabled', false);
    })
    //oneByone form submit
    $('#oneByone').submit(function(){
        $("#SurveyId").attr('disabled', false);
        $("#ClientId").attr('disabled', false);
    })
    //uploadForm from submit
    $('#uploadForm').submit(function(){
        $("#SurveyIdU").attr('disabled', false);
        $("#ClientIdU").attr('disabled', false);
    })
</script>
@endsection
