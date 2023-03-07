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
            @if(count($partnerShipPlans)>0)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Plans</h3>
                </div>
                <div class="card-body">
                    <div class="accordion" id="accordionExample">
                        @foreach($partnerShipPlans as $partnerShipPlan)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $loop->iteration }}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $loop->iteration }}" aria-expanded="{{ $loop->iteration==1?'true':'false' }}" aria-controls="collapse{{ $loop->iteration }}">
                                    {{ $partnerShipPlan->PlanTitle }}
                                </button>
                            </h2>
                            <div id="collapse{{ $loop->iteration }}" class="accordion-collapse collapse {{ $loop->iteration==1?'show':'' }}" aria-labelledby="heading{{ $loop->iteration }}"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="list-group w-50">
                                       {{--  <div class="list-group-item" style="display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        height: 5rem;color: #eead35">
                                            <div class="h3">
                                                {{ $partnerShipPlan->PlanTitle }}
                                            </div>
                                        </div>--}}
                                        <div class="list-group-item" style="background-color: #fff; color:#eead35">
                                            <span class="font-weight-bold float-start">{{ __('Objective') }}</span>
                                            <span class="float-end">{!! $partnerShipPlan->Objective !!}</span>
                                        </div>
                                        <div class="list-group-item" style="background-color: #fff; color:#eead35"><span class="font-weight-bold float-start">{{
                                                __('Process') }}</span>
                                            <span class="float-end">{!! $partnerShipPlan->Process !!}</span>
                                        </div>
                                        <div class="list-group-item" style="display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        height: 5rem; background-color: #fff; color:#eead35"><a
                                                href="{{ route('partner-ship-plans.show', $partnerShipPlan->id) }}"
                                                class="btn btn-primary" >View More Details</a></div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        @endforeach
                    </div>

                </div>
            </div>
            @else
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Plans</h3>
                </div>
                <div class="card-body">
                    <p>Plans</p>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">No Plans</h3>
                                </div>
                                <div class="card-body">
                                    <p>No Plans</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if(count($plans)>0)
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Remote Plans (ON <a href="https://www.hrfactoryapp.com"
                            class="badge text-bg-secondary">HRFactoryApp</a> Database)</h3>
                </div>
                <div class="card-body">
                    <div class="row">

                        @foreach ($plans as $plan)
                        <div class="col-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $plan->PlanTitle }}</h3>
                                </div>
                                <div class="card-body">
                                    <p>{!! $plan->Objective !!}</p>
                                    <p>{{ $plan->Process }}</p>
                                    <p>{{ $plan->Report }}</p>
                                    <p>{{ $plan->DeliveryMode }}</p>
                                    <p>{!! $plan->Limitations !!}</p>
                                    <p>
                                        @switch($plan->Audience)
                                        @case(1)
                                        Only HR Factory App Members
                                        @break

                                        @case(2)
                                        Only HR Employees
                                        @break

                                        @case(3)
                                        Only Employees
                                        @break

                                        @case(4)
                                        Only Managers
                                        @break

                                        @case(5)
                                        Only HR Employees & Employees
                                        @break

                                        @case(6)
                                        Only Managers & Employees
                                        @break

                                        @case(7)
                                        Only Managers & HR Employees
                                        @break

                                        @case(8)
                                        Only Managers, HR Employees & Employees
                                        @break

                                        @case(9)
                                        All Employees
                                        @break

                                        @case(10)
                                        Public
                                        @break

                                        @default
                                        Default case...
                                        @endswitch
                                    </p>
                                    <p><a href="https://www.hrfactoryapp.com{{ $plan->TamplatePath }}"><span
                                                class="badge text-bg-secondary">View Tamplate</span></a></p>
                                    <p>{{ $plan->Price }} OMR</p>
                                    <p>{{ $plan->PaymentMethod }}
                                        @switch($plan->PaymentMethod)
                                        @case(1)
                                        Free
                                        @break

                                        @case(2)
                                        On Service Required Payment
                                        @break

                                        @case(3)
                                        Subscribe
                                        @break

                                        @default
                                        Default case...
                                        @endswitch
                                    </p>
                                    <p>{{ $plan->Status ? 'Active' : 'not active' }}</p>
                                    <a href="{{ route('partner-ship-plans.getPlan',$plan->id) }}"
                                        class="btn btn-primary">Download</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @endif
        </div>
    </div>
</div>
@endsection
