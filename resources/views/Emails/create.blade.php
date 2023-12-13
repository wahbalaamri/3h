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
                    <h3 class="card-title">{{ __('Create Email (Manual)') }}</h3>
                </div>
                <div class="card-body">

                    <form action="{{ route('emails.store') }}" method="POST" class="d-inline" id="oneByone"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="SurveyId">{{ __('Survey') }}</label>
                                    <select name="SurveyId" id="SurveyId"
                                        class="form-control @error('SurveyId') is-invalid @enderror" disabled>
                                        <option value="">{{ __('Select Survey') }}</option>
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
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="ClientId">{{ __('Client') }}</label>
                                    <select name="ClientId" id="ClientId"
                                        class="form-control @error('ClientId') is-invalid @enderror" disabled>
                                        <option value="">{{ __('Select Client') }}</option>
                                        @foreach ($clients as $client)
                                        <option value="{{ $client->id }}" @if (old('ClientId',$clientId)==$client->id)
                                            selected @endif>
                                            {{ $client->ClientName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- select sector --}}
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="SectorId">{{ __('Sector') }}</label>
                                    <select name="SectorId" id="SectorId" onchange="setUpComapny('SectorId','CompanyId')"
                                        class="form-control @error('SectorId') is-invalid @enderror">
                                        <option value="">{{ __('Select Sector') }}</option>
                                        @foreach ($sectors as $sector)
                                        <option value="{{ $sector->id }}" @if (old('SectorId')==$sector->id) selected
                                            @endif>
                                            {{ app()->getLocale()=='ar'? $sector->sector_name_ar:$sector->sector_name_en
                                            }}</option>
                                        @endforeach
                                    </select>
                                    {{-- validation --}}
                                    @error('SectorId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- select company --}}
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="CompanyId">{{ __('Company') }}</label>
                                    <select name="CompanyId" id="CompanyId" onchange="setUpDep('CompanyId','DepartmentId')"
                                        class="form-control @error('CompanyId') is-invalid @enderror">
                                        <option value="">{{ __('Select Company') }}</option>

                                    </select>
                                    {{-- validation --}}
                                    @error('CompanyId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- select department --}}
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="DepartmentId">{{ __('Department') }}</label>
                                    <select name="DepartmentId" id="DepartmentId"
                                        class="form-control @error('DepartmentId') is-invalid @enderror">
                                        <option value="">{{ __('Select Department') }}</option>

                                    </select>
                                    {{-- validation --}}
                                    @error('DepartmentId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- insert email details --}}
                        <div class="row">
                            {{-- employee email --}}
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="Email">{{ __('Email') }}</label>
                                    <input type="text" name="Email" id="Email"
                                        class="form-control @error('Email') is-invalid @enderror"
                                        value="{{ old('Email') }}" placeholder="Email">
                                    {{-- validation --}}
                                    @error('Email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- employee Mobile --}}
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="Mobile">{{ __('Mobile') }}</label>
                                    <input type="text" name="Mobile" id="Mobile"
                                        class="form-control @error('Mobile') is-invalid @enderror"
                                        value="{{ old('Mobile') }}" placeholder="Mobile">
                                    {{-- validation --}}
                                    @error('Mobile')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- employee type --}}
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="EmployeeType">{{ __('Employee Type') }}</label>
                                    <select name="EmployeeType" id="EmployeeType"
                                        class="form-control @error('EmployeeType') is-invalid @enderror">
                                        <option value="">{{ __('Select Employee Type') }}</option>
                                        <option value="1" @if (old('EmployeeType')==1) selected @endif>{{ __('Manager') }}
                                        </option>
                                        <option value="2" @if (old('EmployeeType')==2) selected @endif>{{ __('HR Team') }}
                                        </option>
                                        <option value="3" @if (old('EmployeeType')==3) selected @endif>
                                            {{ __('Employee') }}</option>
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
                                <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- add email by upload file --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Create Email (Upload File)') }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('emails.saveUploadZ') }}" method="POST" enctype="multipart/form-data"
                        id="uploadForm" class="d-inline">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="SurveyIdU">{{ __('Survey') }}</label>
                                    <select name="SurveyIdU" id="SurveyIdU"
                                        class="form-control @error('SurveyIdU') is-invalid @enderror" disabled>
                                        <option value="">{{ __('Select Survey') }}</option>
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
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="ClientIdU">{{ __('Client') }}</label>
                                    <select name="ClientIdU" id="ClientIdU"
                                        class="form-control @error('ClientIdU') is-invalid @enderror" disabled>
                                        <option value="">{{ __('Select Client') }}</option>
                                        @foreach ($clients as $client)
                                        <option value="{{ $client->id }}" @if (old('ClientIdU',$clientId)==$client->id)
                                            selected @endif>
                                            {{ $client->ClientName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- select sector --}}
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="SectorId_up">{{ __('Sector') }}</label>
                                    <select name="SectorId_up" id="SectorId_up" onchange="setUpComapny('SectorId_up','CompanyId_up')"
                                        class="form-control @error('SectorId_up') is-invalid @enderror">
                                        <option value="">{{ __('Select Sector') }}</option>
                                        @foreach ($sectors as $sector)
                                        <option value="{{ $sector->id }}" @if (old('SectorId_up')==$sector->id) selected
                                            @endif>
                                            {{ app()->getLocale()=='ar'? $sector->sector_name_ar:$sector->sector_name_en
                                            }}</option>
                                        @endforeach
                                    </select>
                                    {{-- validation --}}
                                    @error('SectorId_up')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- select company --}}
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="CompanyId_up">{{ __('Company') }}</label>
                                    <select name="CompanyId_up" id="CompanyId_up" onchange="setUpDep('CompanyId_up','DepartmentId_up')"
                                        class="form-control @error('CompanyId_up') is-invalid @enderror">
                                        <option value="">{{ __('Select Company') }}</option>

                                    </select>
                                    {{-- validation --}}
                                    @error('CompanyId_up')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- select department --}}
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="DepartmentId_up">{{ __('Department') }}</label>
                                    <select name="DepartmentId_up" id="DepartmentId_up"
                                        class="form-control @error('DepartmentId_up') is-invalid @enderror">
                                        <option value="">{{ __('Select Department') }}</option>

                                    </select>
                                    {{-- validation --}}
                                    @error('DepartmentId_up')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label for="EmailFile">{{ __('Upload File') }}</label>
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
                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- copy from previous survey --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Copy From Previous Survey') }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('emails.copy') }}" method="POST" class="d-inline" id="CopyFrom">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="SurveyIdC">{{ __('Old Survey') }}</label>
                                    <select name="SurveyIdC" id="SurveyIdC"
                                        class="form-control @error('SurveyIdC') is-invalid @enderror">
                                        <option value="">{{ __('Select Survey') }}</option>
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
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="ClientIdC">{{ __('Client') }}</label>
                                    <select name="ClientIdC" id="ClientIdC"
                                        class="form-control @error('ClientIdC') is-invalid @enderror" disabled>
                                        <option value="">{{ __('Select Client') }}</option>
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
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="NewSurveyIdC">{{ __('New Survey') }}</label>
                                    <select name="NewSurveyIdC" id="NewSurveyIdC"
                                        class="form-control @error('NewSurveyIdC') is-invalid @enderror" disabled>
                                        <option value="">{{ __('Select Survey') }}</option>
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
                                <button type="submit" class="btn btn-primary">{{ __('Copy') }}</button>
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
    // on sector select update company select
    // $('#SectorId').change(function(){
    //     var SectorId = $(this).val();
    //     if(SectorId){
    //         $.ajax({
    //             type:"GET",
    //             url:"{{ url('companies/getForSelect') }}/"+SectorId,
    //             success:function(res){
    //                 if(res){
    //                     $("#CompanyId").empty();
    //                     $("#CompanyId").append('<option value="">{{ __("Select Company") }}</option>');
    //                     $.each(res,function(key,value){
    //                         $("#CompanyId").append('<option value="'+value.id+'">'+value.company_name_en+'</option>');
    //                     });
    //                 }else{
    //                     $("#CompanyId").empty();
    //                 }
    //             }
    //         });
    //     }else{
    //         $("#CompanyId").empty();
    //     }
    // });
    setUpComapny =(sec,comp) =>{
        var SectorId = $("#"+sec).val();
        if(SectorId){
            $.ajax({
                type:"GET",
                url:"{{ url('companies/getForSelect') }}/"+SectorId,
                success:function(res){
                    if(res){
                        $("#"+comp).empty();
                        $("#"+comp).append('<option value="">{{ __("Select Company") }}</option>');
                        $.each(res,function(key,value){
                            $("#"+comp).append('<option value="'+value.id+'">'+value.company_name_en+'</option>');
                        });
                    }else{
                        $("#"+comp).empty();
                    }
                }
            });
        }else{
            $("#"+comp).empty();
        }
    }
    // on Company select update department select
    setUpDep=(comp,dep)=>{


        var CompanyId = $("#"+comp).val();
        console.log(CompanyId);
        if(CompanyId){
            $.ajax({
                type:"GET",
                url:"{{ url('departments/getForSelect') }}/"+CompanyId,
                success:function(res){
                    if(res){
                        $("#"+dep).empty();
                        $("#"+dep).append('<option value="">{{ __("Select Department") }}</option>');
                        $.each(res,function(key,value){
                            $("#"+dep).append('<option value="'+value.id+'">'+value.dep_name_en+'</option>');
                        });
                    }else{
                        $("#"+dep).empty();
                    }
                }
            });
        }else{
            $("#DepartmentId").empty();
        }
    }
</script>
@endsection
