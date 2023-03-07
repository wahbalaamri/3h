{{-- extends --}}
@extends('layouts.main')

{{-- content --}}
@section('content')
    {{-- container --}}
    <div class="container pt-5 mt-5">
        <div class="row">
            <div class="col-3">
                <!-- side bar menu -->
                @include('layouts.sidebar')
            </div>
            <div class="col-9">
                {{-- card to Service Requests --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="">Service Requests</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item"><span
                                    class="font-weight-bold float-start">{{ __('Plan Title') }}</span>
                                <span class="float-end">{{ $request->plan->PlanTitle }}</span>
                            </li>
                            <li class="list-group-item"><span
                                    class="font-weight-bold float-start">{{ __('Request Remarks') }}</span>
                                <span class="float-end">{!! $request->remarks !!}</span>
                            </li>
                            <li class="list-group-item text-center">
                                <span class="font-weight-bold text-center">
                                    <h4>{{ __('Service Requester Details') }}</h4>
                                </span>
                            </li>
                            <li class="list-group-item">
                                <span class="font-weight-bold float-start">{{ __('Company Name') }}</span>
                                <span class="float-end">{{ $request->company_name }}
                                </span>
                            </li>

                            {{-- <li class="list-group-item">
                                <span class="font-weight-bold float-start">{{ __('Company Email') }}</span>
                                <span class="float-end">{{ $request->company_email }}
                                </span>
                            </li> --}}
                            <li class="list-group-item">
                                <span class="font-weight-bold float-start">{{ __('Company Phone') }}</span>
                                <span class="float-end">{{ $request->company_phone }}
                                </span>
                            </li>
                            <li class="list-group-item text-center">
                                <span class="font-weight-bold text-center">
                                    <h4>{{ __('Company Focal Point Details') }}</h4>
                                </span>
                            </li>
                            <li class="list-group-item">
                                <span class="font-weight-bold float-start">{{ __('Focal Point Name') }}</span>
                                <span class="float-end">{{ $request->fp_name }}
                                </span>
                            </li>
                            <li class="list-group-item">
                                <span class="font-weight-bold float-start">{{ __('Focal Point Email') }}</span>
                                <span class="float-end">{{ $request->fp_email }}
                                </span>
                            </li>
                            {{-- <li class="list-group-item">
                                <span class="font-weight-bold float-start">{{ __('Focal Point Phone') }}</span>
                                <span class="float-end">{{ $request->fp_phone }}
                                </span>
                            </li> --}}
                            @if (count($clients)<=0)
                            <li class="list-group-item">
                                {{-- add this client --}}
                                <a href="{{ route('request-service.add_client', $request->id) }}"
                                    class="btn btn-primary btn-block">
                                    {{ __('Add Client') }}
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
