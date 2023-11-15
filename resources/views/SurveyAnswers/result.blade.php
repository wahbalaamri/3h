{{-- extends --}}
@extends('layouts.main')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/CircularProgress.css') }}">
@endpush
{{-- content --}}
@section('content')
{{-- container --}}
<div class="container-fluid pt-5 mt-5">
    <div class="row">
        <div class="col-2">
            <!-- side bar menu -->
            @include('layouts.sidebar')
        </div>
        <div class="col-10" id="finalResult">

            {{-- card for sector , company and department selection --}}
            <div class="card shadow p-3 mb-5 bg-white rounded">
                {{-- card header --}}
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>{{ __('Final Result') }}</h5>
                    {{-- <a href="{{ route('home') }}" class="btn btn-sm btn-primary">Back</a> --}}
                </div>
                {{-- card body --}}
                <div class="card-body">
                    @if ($not_home)
                    <div class="row">
                        <a href="{{ route('survey-answers.result',$survey_id) }}" class="btn btn-primary"
                            id="GetSector">{{ __('Back To Organizational View')}}</a>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label for="sector">{{ __('Sector') }}</label>
                                <select class="form-control" id="sector" name="sector">
                                    <option value="">{{ __('Select Sector') }}</option>
                                    @foreach ($sectors as $sector)
                                    <option value="{{ $sector->id }}">{{
                                        App()->getLocale()=='en'?$sector->sector_name_en:$sector->sector_name_ar }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- button to fetch data --}}
                            <div class="form-group mt-2" id="GetSectorData" style="display: none">
                                <a href="" class="btn btn-primary" id="GetSector">{{ __('Get Result For This Sector')
                                    }}</a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12" id="companyDiv" style="display: none">
                            <div class="form-group">
                                <label for="company">{{ __('Company') }}</label>
                                <select class="form-control" id="company" name="company">
                                    <option value="">{{ __('Select Company') }}</option>
                                </select>
                            </div>
                            {{-- button to fetch data --}}
                            <div class="form-group mt-2" id="GetCompData" style="display: none">
                                <a href="" class="btn btn-primary" id="GetCompany">{{ __('Get Result For This Company')
                                    }}</a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12" id="departmentDiv" style="display: none">
                            <div class="form-group">
                                <label for="Department">{{ __('Department') }}</label>
                                <select class="form-control" id="Department" name="Department">
                                    <option value="">{{ __('Select Department') }}</option>
                                </select>
                            </div>
                            {{-- button to fetch data --}}
                            <div class="form-group mt-2" id="GetDepData" style="display: none">
                                <a href="" class="btn btn-primary" id="GetDep">{{ __('Get Result For This Department')
                                    }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--card for dashboard result--}}
            <div class="card shadow p-3 mb-5 bg-white rounded">
                {{-- header --}}
                <div class="card-header">
                    <h2 class="card-title">
                        {{-- color text orange with later spacing 1 --}}
                        <span class="text-orange space-x-6">
                            {{ __('Dashboard-')}}{{ $term }}
                        </span>
                    </h2>
                </div>
                {{-- body --}}
                <div class="card-body">
                    {{-- row with three columns idintical --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-light p-3 mb-3 rounded">
                                {{-- header with blue background --}}
                                <div class="card-header bg-info">
                                    {{-- centerlize items --}}
                                    <div class="d-flex justify-content-center align-items-center">
                                        <h3 class="card-title text-white text-center pt-4 pb-4">{{
                                            __('Employee Engagement Index') }}</h3>
                                    </div>
                                </div>
                                {{-- body --}}
                                <div class="card-body">
                                    <div class="row d-flex justify-content-center align-items-center text-center">
                                        <div class="col-12">
                                            <div class="speedometer
                                            @if ($EE_Index<=25)
                                            speed-1
                                            @elseif($EE_Index<=50)
                                            speed-2
                                            @elseif($EE_Index<=65)
                                            speed-3
                                            @elseif($EE_Index<=80)
                                            speed-4
                                            @else
                                            speed-5
                                            @endif
                                            ">
                                                <div class="pointer"></div>
                                            </div>
                                            <h3 class="caption">{{ $EE_Index }}%</h3>
                                        </div>
                                        <div class="col-12 mt-5">
                                            <div class="row">
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="custom-progress mb-3">
                                                        <div class="custom-progress-bar bg-success @if ($EE_Index_Engaged <=0)
                                                        text-danger
                                                    @endif" style="height:{{ $EE_Index_Engaged }}%">
                                                            <span>{{ $EE_Index_Engaged }}%</span>
                                                        </div>
                                                    </div>
                                                    <span class="caption h6">{{ __('Engaged') }}</span>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="custom-progress mb-3">
                                                        <div class="custom-progress-bar bg-warning @if ($EE_Index_Nuetral<=0) text-danger @endif"
                                                            style="height:{{ $EE_Index_Nuetral }}%">
                                                            <span>{{ $EE_Index_Nuetral }}%</span>
                                                        </div>
                                                    </div>
                                                    <span class="caption h6">{{ __('Nuetral') }}</span>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="custom-progress mb-3">
                                                        <div class="custom-progress-bar bg-danger @if ($EE_Index_Actively_Disengaged<=0)
                                                        text-danger
                                                    @endif" style="height:{{ $EE_Index_Actively_Disengaged }}%">
                                                            <span>{{ $EE_Index_Actively_Disengaged
                                                                }}%</span>
                                                        </div>
                                                    </div>
                                                    <span class="caption h6">{{ __('Actively Disengaged') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light p-3 mb-3 rounded">
                                {{-- header with blue background --}}
                                <div class="card-header bg-info">
                                    {{-- centerlize items --}}
                                    <div class="d-flex justify-content-center align-items-center">
                                        <h3 class="card-title text-white text-center pt-4 pb-4">{{
                                            __('Employee Engagement Drivers') }}</h3>
                                    </div>
                                </div>
                                {{-- body --}}
                                <div class="card-body">
                                    <div class="row d-flex justify-content-center align-items-center text-center">
                                        @foreach ($overall_per_fun as $fun)
                                        <div class="col-12">
                                            <div class="caption">
                                                <h3 class="h3">{{ $fun['fun_title'] }}</h3>
                                                {{-- <h5 class="h6">({{ $fun['fun_des'] }})</h5> --}}
                                            </div>
                                            <div class="speedometer
                                            @if ($fun['fun_perc']<=25)
                                            speed-1
                                            @elseif($fun['fun_perc']<=50)
                                            speed-2
                                            @elseif($fun['fun_perc']<=65)
                                            speed-3
                                            @elseif($fun['fun_perc']<=85)
                                            speed-4
                                            @else
                                            speed-5
                                            @endif
                                            ">
                                                <div class="pointer"></div>
                                            </div>
                                            <h3 class="caption">{{ $fun['fun_perc'] }}%</h3>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light p-3 mb-3 rounded">
                                {{-- header with blue background --}}
                                <div class="card-header bg-info">
                                    {{-- centerlize items --}}
                                    <div class="d-flex justify-content-center align-items-center">
                                        <h3 class="card-title text-white text-center pt-2 pb-2">{{
                                            __('Employee Net Promotor Score (eNPS)') }}</h3>
                                    </div>
                                </div>
                                {{-- body --}}
                                <div class="card-body">
                                    <div class="row d-flex justify-content-center align-items-center text-center">
                                        <div class="col-12">
                                            <div class="speedometer
                                            @if ($eNPS<=25)
                                            speed-1
                                            @elseif($eNPS<=50)
                                            speed-2
                                            @elseif($eNPS<=65)
                                            speed-3
                                            @elseif($eNPS<=85)
                                            speed-4
                                            @else
                                            speed-5
                                            @endif
                                            ">
                                                <div class="pointer"></div>
                                            </div>
                                            <h3 class="caption">{{ $eNPS }}%</h3>
                                        </div>
                                        <div class="col-12 mt-5">
                                            <div class="row">
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="custom-progress mb-3">
                                                        <div class="custom-progress-bar bg-success @if ($eNPS_Promotors<=0)
                                                            text-danger
                                                        @endif" style="height:{{ $eNPS_Promotors }}%">
                                                            <span>{{ $eNPS_Promotors }}%</span>
                                                        </div>
                                                    </div>
                                                    <span class="caption h6">{{ __('Promotors')}}</span>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="custom-progress mb-3">
                                                        <div class="custom-progress-bar bg-warning @if ($eNPS_Passives<=0)
                                                        text-danger
                                                    @endif" style="height:{{ $eNPS_Passives }}%">
                                                            <span>{{ $eNPS_Passives }}%</span>
                                                        </div>
                                                    </div>
                                                    <span class="caption h6 pt-3">{{ __('Passives') }}</span>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="custom-progress mb-3">
                                                        <div class="custom-progress-bar bg-danger @if ($eNPS_Detractors<=0)
                                                        text-danger
                                                    @endif" style="height:{{ $eNPS_Detractors }}%">
                                                            <span>{{ $eNPS_Detractors }}%</span>
                                                        </div>
                                                    </div>
                                                    <span class="caption h6 pt-3">{{ __('Detractors')
                                                        }}</span>
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
            {{-- card for Engagement Drivers Result-Organizational Wide --}}
            <div class="card shadow p-3 mb-5 bg-white rounded">
                {{-- header --}}
                <div class="card-header d-flex align-items-center">
                    <h2 class="h4 text-orange">{{ __('Engagement Drivers Result - ')}}{{ $term }}</h2>
                </div>
                {{-- body --}}
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 pt-5 pb-5 bg-info shadow p-3 rounded">
                            <h3 class="text-white">{{ __('Engagement Drivers') }}</h3>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ( $overall_per_fun as $fun_result)

                        <div class="col-md-4 col-sm-12">
                            <div class="card-header d-flex align-items-center pt-3 text-center">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="caption">
                                                    <h3 class="h3">{{ $fun_result['fun_title'] }}</h3>
                                                    {{-- <h5 class="h5">({{ $fun_result['fun_des'] }})</h5> --}}
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="speedometer
                                            @if ($fun_result['fun_perc']<=25)
                                            speed-1
                                            @elseif($fun_result['fun_perc']<=50)
                                            speed-2
                                            @elseif($fun_result['fun_perc']<=65)
                                            speed-3
                                            @elseif($fun_result['fun_perc']<=85)
                                            speed-4
                                            @else
                                            speed-5
                                            @endif
                                            ">
                                                    <div class="pointer"></div>
                                                </div>
                                                <h3 class="caption">{{ $fun_result['fun_perc'] }}%</h3>
                                            </div>
                                            @foreach ($overall_per_practice as $practice)
                                            @if ($practice['FunctionId']==$fun_result['fun_id'])

                                            <div class="col-12 pt-2 pb-2 text-center mb-2 rounded
                                            @if ($practice['practice_perc']<=54)
                                                bg-danger text-white
                                            @elseif($practice['practice_perc']<=74)
                                                bg-warning
                                                @else
                                                bg-success text-white
                                            @endif
                                            ">
                                                {{ $practice['PracticeTitle'] }} {{-- -- {{ $practice['practice_perc']
                                                }} --}}
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- card for Top and Bottom Scores-Organizational Wide --}}
            <div class="card shadow p-3 mb-5 bg-white rounded">
                {{-- header --}}
                <div class="card-header d-flex align-items-center">
                    <h2 class="h4 text-orange">{{ __('Top and Bottom Scores - ')}}{{ $term }}.
                    </h2>
                </div>
                {{-- body --}}

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            {{-- card --}}
                            <div class="card p-3 mb-5 rounded">
                                {{-- header --}}
                                <div class="card-header d-flex align-items-center bg-info">
                                    <h3 class="h3 text-white">{{ __('Key Strengths') }}</h3>
                                </div>
                                {{-- body --}}
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($highest_practices as $parctice)

                                        <div class="col-12">
                                            <span class="caption"> {{ $parctice['PracticeTitle']
                                                }}</span>
                                            <div class="progress" role="progressbar" aria-label="Warning example"
                                                aria-valuenow="{{  $parctice['practice_perc'] }}" aria-valuemin="0"
                                                aria-valuemax="100" style="height: 20px">
                                                <div class="progress-bar
                                                @if ($parctice['practice_perc']>=75)
                                                text-bg-success
                                                @elseif ($parctice['practice_perc']>=55)
                                                text-bg-warning
                                                @else
                                                text-bg-danger
                                                @endif
                                                "
                                                    style="width: {{  $parctice['practice_perc'] }}% ; font-size: 0.9rem;">
                                                    {{
                                                    $parctice['practice_perc'] }}%</div>
                                            </div>

                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            {{-- card --}}
                            <div class="card p-3 mb-5 rounded">
                                {{-- header --}}
                                <div class="card-header d-flex align-items-center bg-info">
                                    <h3 class="h3 text-white">{{ __('Key Improvement Areas') }}</h3>
                                </div>
                                {{-- body --}}
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($lowest_practices as $parctice)

                                        <div class="col-12">
                                            <span class="caption"> {{ $parctice['PracticeTitle']
                                                }}</span>
                                            <div class="progress" role="progressbar" aria-label="Warning example"
                                                aria-valuenow="{{  $parctice['practice_perc'] }}" aria-valuemin="0"
                                                aria-valuemax="100" style="height: 20px">
                                                <div class="progress-bar
                                                @if ($parctice['practice_perc']>=75)
                                                text-bg-success
                                                @elseif ($parctice['practice_perc']>=55)
                                                text-bg-warning
                                                @else
                                                text-bg-danger
                                                @endif
                                                "
                                                    style="width: {{  $parctice['practice_perc'] }}% ; font-size: 0.9rem;">
                                                    {{
                                                    $parctice['practice_perc'] }}%</div>
                                            </div>

                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            {{--
                            ===========================================================================
                            --}}
                        </div>
                    </div>
                </div>
            </div>
            @if(!$isDep)
            {{-- card for Heat Map-Engagement Drivers Result across Sectors --}}
            <div class="card shadow p-3 mb-5 bg-white rounded">
                {{-- header --}}
                <div class="card-header d-flex align-items-center">
                    <h2 class="h4 text-orange">{{ __('Heat Map - Engagement Drivers Result across ') }}{{ $term1 }}</h2>
                </div>
                {{-- body --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-active table-bordered" aria-colspan="2">
                            <thead>
                                <tr class="text-center">
                                    <th class="bg-info">{{ __($term2) }}</th>
                                    <th class="bg-info">{{
                                        App()->getLocale()=='ar'?$driver_functions[0]->FunctionTitleAr:$driver_functions[0]->FunctionTitle
                                        }}</th>
                                    <th class="bg-info">{{
                                        App()->getLocale()=='ar'?$driver_functions[1]->FunctionTitleAr:$driver_functions[1]->FunctionTitle
                                        }}</th>
                                    <th class="bg-info">{{
                                        App()->getLocale()=='ar'?$driver_functions[2]->FunctionTitleAr:$driver_functions[2]->FunctionTitle
                                        }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $result_per_sector as $Sect_data)
                                <tr>
                                    <td class="text-center bg-info">{{ $Sect_data['sector_name'] }}</td>

                                    @foreach ($Sect_data['functions'] as $sect_fun)
                                    @if($sect_fun['fun_id']==$driver_functions[0]->id)
                                    <td class="text-center
                                    @if ($sect_fun['sect_perc']>=75)
                                        bg-success
                                        @elseif ($sect_fun['sect_perc']>=55)
                                        bg-warning
                                    @else
                                    bg-danger
                                    @endif">
                                        {{ $sect_fun['sect_perc'] }}%
                                    </td>
                                    @break
                                    @endif
                                    @endforeach
                                    @foreach ($Sect_data['functions'] as $sect_fun)
                                    @if($sect_fun['fun_id']==$driver_functions[1]->id)
                                    <td class="text-center
                                    @if ($sect_fun['sect_perc']>=75)
                                        bg-success
                                        @elseif ($sect_fun['sect_perc']>=55)
                                        bg-warning
                                    @else
                                    bg-danger
                                    @endif">
                                        {{ $sect_fun['sect_perc'] }}%
                                    </td>
                                    @break
                                    @endif
                                    @endforeach
                                    @foreach ($Sect_data['functions'] as $sect_fun)
                                    @if($sect_fun['fun_id']==$driver_functions[2]->id)
                                    <td class="text-center
                                    @if ($sect_fun['sect_perc']>=75)
                                        bg-success
                                        @elseif ($sect_fun['sect_perc']>=55)
                                        bg-warning
                                    @else
                                    bg-danger
                                    @endif">
                                        {{ $sect_fun['sect_perc'] }}%
                                    </td>
                                    @break
                                    @endif
                                    @endforeach

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
            <div class="row text-start">
                <div class="col-4 p-3 ">

                    <a href="{{ route('surveys.DownloadSurvey',$id) }}" class="btn btn-success mt-3" style="border-radius: 10px;
            -webkit-box-shadow: 5px 5px 20px 5px #ababab;
            box-shadow: 5px 5px 20px 5px #ababab;">{{ __('Download Survey Answers') }}</a>
                </div>
                <div class="col-4 p-3 ">

                    <a href="{{ route('survey-answers.resultPDF',$id) }}" class="btn btn-success mt-3" style="border-radius: 10px;
            -webkit-box-shadow: 5px 5px 20px 5px #ababab;
            box-shadow: 5px 5px 20px 5px #ababab;">{{ __('Download Survey Result PDF') }}</a>
                </div>
            </div>
        </div>
        {{-- =============================================================== --}}
    </div>
</div>
@endsection
@section('scripts')
<script>
    var survey_id="{{ $survey_id }}"
    $("#sector").change(function(){
if($("#sector").val()!='')
{
    $.ajax({
                type:"GET",
                url:"{{ url('companies/getForSelect') }}/"+$("#sector").val(),
                success:function(res){
                    if(res){
                        $("#company").empty();
                        $("#company").append('<option value="">{{ __("Select Company") }}</option>');
                        $.each(res,function(key,value){
                            $("#company").append('<option value="'+value.id+'">'+value.company_name_en+'</option>');
                        });
                    }else{
                        $("#company").empty();
                    }
                }
            });
    // GetSectorData companyDiv
    $('#companyDiv').show();
    $('#GetSectorData').show();
    //set href for GetSector
    $('#GetSector').attr('href','{{ url("/survey-answers/SectorResult/") }}/'+survey_id+'/'+$("#sector").val());
}
else{
    $('#GetSectorData').hide();
    $('#companyDiv').hide();
    $('#GetCompData').hide();
    $('#departmentDiv').hide();
    $('#GetDepData').hide();
}
});
    $("#company").change(function(){
if($("#company").val()!='')
{
    $.ajax({
                type:"GET",
                url:"{{ url('departments/getForSelect') }}/"+$("#company").val(),
                success:function(res){
                    if(res){
                        $("#Department").empty();
                        $("#Department").append('<option value="">{{ __("Select Department") }}</option>');
                        $.each(res,function(key,value){
                            $("#Department").append('<option value="'+value.id+'">'+value.dep_name_en+'</option>');
                        });
                    }else{
                        $("#Department").empty();
                    }
                }
            });

    // GetSectorData companyDiv

    $('#departmentDiv').show();
    $('#GetCompData').show();
    //set href for GetCompany
    $('#GetCompany').attr('href','{{ url("/survey-answers/CompanyResult/") }}/'+survey_id+'/'+$("#company").val());
}else{
    $('#GetCompData').hide();
    $('#departmentDiv').hide();
    $('#GetDepData').hide();
}
});
$("#Department").change(function(){
    if($("#Department").val()!='')
{
    $('#GetDepData').show();
    //set href for GetDep
    $('#GetDep').attr('href','{{ url("/survey-answers/DepartmentResult/") }}/'+survey_id+'/'+$("#Department").val());
}
else{
    $('#GetDepData').hide();
}
});
</script>
@endsection
