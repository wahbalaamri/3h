@extends('layouts.main')

@section('content')
{{-- container --}}
<div class="container-fluid pt-5 mt-5">
    <div class="row">
        <div class="col-2">
            <!-- side bar menu -->
            @include('layouts.sidebar')
        </div>
        <div class="col-10" id="statiscts">
            {{-- create card for over-all statisics --}}
            <div class="card mb-2">
                <div class="card-header">
                    <h3>{{ __('Over-all Statistics') }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            {{-- create card for total number of survey answers --}}
                            <div class="card mb-2 text-white bg-info">
                                <div class="card-body">
                                    <div class="text-center">
                                        <small class="">{{ __('Total Number
                                            of Targeted Employee') }}</small>
                                        <h1 >{{ $number_all_respondent }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            {{-- create card for total number of survey answers --}}
                            <div class="card mb-2 text-white @if (number_format(($number_all_respondent_answers/$number_all_respondent)*100,2)>=75)
                                bg-success
                            @elseif(number_format(($number_all_respondent_answers/$number_all_respondent)*100,2)>=45)
                                bg-warning
                                @else
                                bg-danger
                            @endif">
                                <div class="card-body">
                                    <div class="text-center">
                                        <small class="">{{ __('Total Number of Survey Answers') }}</small>
                                        <h1>{{ $number_all_respondent_answers }}</h1>
                                        <p class="mb-0 text-start"><span class="dot-label bg-secondary me-2"></span>{{
                                            __('Respons Rate') }}<span class="float-end">{{
                                                number_format(($number_all_respondent_answers/$number_all_respondent)*100,2)
                                                }}%</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            {{-- create card for total number of survey answers --}}
                            <div class="card mb-2 bg-info text-white">
                                <div class="card-body">
                                    <div class="text-center">
                                        <small class="">{{ __('Total Number
                                            of Client Sector') }}</small>
                                        <h1>{{ $sectors }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            {{-- create card for total number of survey answers --}}
                            <div class="card mb-2 text-white bg-info">
                                <div class="card-body">
                                    <div class="text-center">
                                        <small class="">{{ __('Total Number
                                            of Client Companies') }}</small>
                                        <h1>{{ $companies }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            {{-- create card for total number of survey answers --}}
                            <div class="card mb-2 text-white bg-secondary">
                                <div class="card-body">
                                    <div class="text-center">
                                        <small class="">{{ __('Total Number
                                            of Client departments') }}</small>
                                        <h1>{{ $departments }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-md-4 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center">
                                        <small class="text-muted">New users</small>
                                        <h2 class="mb-2 mt-0">2,897</h2>
                                        <div id="circle" class="mt-3 mb-3 chart-dropshadow-secondary"><canvas width="70"
                                                height="70"></canvas></div>
                                        <div class="chart-circle-value-3 text-secondary fs-20"><i
                                                class="icon icon-user-follow"></i></div>
                                        <p class="mb-0 text-start"><span
                                                class="dot-label bg-secondary me-2"></span>Monthly users <span
                                                class="float-end">60%</span></p>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
            {{-- create card for each sector statisics --}}
            <div class="card mb-2">
                <div class="card-header">
                    <h3>{{ __('Sector-wise Statistics') }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($sectors_details as $sectors_detail)
                        <div class="col-md-4 col-sm-12">
                            <div class="card mb-2 text-white @if (number_format(($sectors_detail['sector_answers']/$sectors_detail['sector_emails'])*100,2)>=75)
                                bg-success
                            @elseif(number_format(($sectors_detail['sector_answers']/$sectors_detail['sector_emails'])*100,2)>=45)
                                bg-warning
                                @else
                                bg-danger
                            @endif">
                                <div class="card-body">
                                    <small class="">{{ $sectors_detail['sector_name'] }}</small>
                                    <p class="mb-0 text-start"> {{ __('Total Number of Targeted Employee') }}
                                    <h1 class="text-center">{{ $sectors_detail['sector_emails'] }}
                                    </h1>
                                    </p>
                                    <p class="mb-0 text-start"><span class="dot-label bg-secondary me-2"></span>{{
                                        __('Total number of employees who answers survey: ') }}<span class="float-end">
                                            {{ $sectors_detail['sector_answers'] }}</span></p>
                                    <p class="mb-0 text-start"><span class="dot-label bg-secondary me-2"></span>{{
                                        __('Response rate: ') }}<span class="float-end">{{
                                            number_format(($sectors_detail['sector_answers']/$sectors_detail['sector_emails'])*100,2)
                                            }}%</span></p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- create card for each company statisics --}}
            <div class="card mb-2">
                <div class="card-header">
                    <h3>{{ __('Company-wise Statistics') }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($company_details as $company_detail)
                        @if($company_detail['company_name']!='ARA Tanzania')
                        <div class="col-md-4 col-sm-12">
                            <div class="card mb-2 @if ($company_detail['response_rate']>=70)
                                text-success
                                @elseif ($company_detail['response_rate']>=45)
                            text-warning
                            @else
                            text-danger
                            @endif">
                                <div class="card-body">
                                    <p class="mb-0 text-start"><small class="dot-label me-2">{{ __('Sector') }}</small>
                                        <small class="float-end">{{ $company_detail['sector_name'] }}</small>
                                    </p>
                                    <small class="">{{ $company_detail['company_name'] }}</small>
                                    <p class="mb-0 text-start"> {{ __('Total Number of Targeted Employee') }}
                                    <h1 class="text-center">{{ $company_detail['company_emails'] }}
                                    </h1>
                                    </p>
                                    <p class="mb-0 text-start"><span class="dot-label me-2">{{
                                            __('Total number of employees who answers survey: ') }}</span><span
                                            class="float-end">
                                            {{ $company_detail['company_answers'] }}</span></p>
                                    <p class="mb-0 text-start"><span class="dot-label me-2">{{
                                            __('Response rate: ') }}</span><span class="float-end">{{
                                            $company_detail['response_rate']}}%</span></p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
