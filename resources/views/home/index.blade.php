@extends('layouts.main')
@section('content')
{{-- add imager banner --}}
<div class="container-fluid">
    <div class="row main-bg">
        <div class="col-lg-6 col-md-12 col-sm-12 p-0 m-0 text-center justify-content-center align-self-center">
            <h1 class="text-white" style="font-size: 3.4rem">
                HR Diagnostic
                Solutions
            </h1>
            <span style="font-size: 2.4rem">
                Maximize your return on people investment
            </span>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12 p-0 m-0">
            <img src="{{ asset('assets/img/mainbg.png') }}" class="float-end image-2" alt="" srcset="">
        </div>
    </div>
</div>
{{-- end add imager banner --}}
{{-- add welcome paragraph --}}
<div class="container-fluid p-5">
    {{-- <div class="row"> --}}
        <div class="col-12 text-center justify-content-center align-self-center">
            <h1 class="text-center">
                Our approach
            </h1>
            {{-- <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="text-start">
                            <h1 class="text-start pb-5 mb-4">Maximize your return on people investment
                            </h1>
                            <h3 class="pl-3 pt-5">Our approach
                            </h3>
                            <ul class="list-group" style="font-size: 1.4rem">
                                <li class="list-group-item">
                                    <p class="text-lg-start">
                                        We believe that HR value is defined by the receivers(managers) and not by
                                        the giver (HR department) and thus we assess the managers' experience in
                                        handling HR activities in a way serving their business needs.</p>
                                </li>
                                <li class="list-group-item">
                                    <p class="text-lg-start">
                                        We also believe in the value of enhancing the employee experience and thus
                                        we also capture employees’ voices. </p>
                                </li>
                                <li class="list-group-item">
                                    <p class="text-lg-start">
                                        We don't believe in a one-size-fits-all approach and in "Best Practices" and
                                        thus we assess the outcome/results and identify the possible root causes
                                        which need to be validated and refined.
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="col-12 text-center justify-content-center align-self-center pt-5">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="col-12">
                        <img src="{{ asset('assets/img/approach1.png') }}" alt="" srcset="" height="80" style="">
                    </div>
                    <div class="col-12">
                        <div class="w-75 m-auto p-3">

                            <p class="">We believe that HR value is defined by the receivers(managers) and not by
                                the giver (HR department) and thus we assess the managers' experience in handling HR
                                activities in a way serving their business needs.

                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="col-12">
                        <img src="{{ asset('assets/img/approach2.png') }}" alt="" srcset="" height="80" style="">
                    </div>
                    <div class="col-12">
                        <div class="w-75 m-auto p-3">
                            <p class="text-center">We also believe in the value of enhancing the employee experience and
                                thus we also capture employees’ voices.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="col-12">
                        <img src="{{ asset('assets/img/approach3.png') }}" alt="" srcset="" height="80" style="">
                    </div>
                    <div class="col-12">
                        <div class="w-75 m-auto p-3">
                            <p class="text-center">We don't believe in a one-size-fits-all approach and in "Best
                                Practices"
                                and thus we assess the outcome/results and identify the possible root causes which need
                                to
                                be validated &refined.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--
    </div> --}}
</div>

{{-- end welcome paragraph --}}
{{-- add subscriptionPlans --}}
<div class="container-fluid pt-5">
    <div class="row pt-4 pb-5" style="background-color: #f8f7f5;">
        <div class="col-12 pb-4 pt-4 text-center justify-content-center align-self-center">
            <h1 class="text-center text-capitalize">
                Solution Plans
            </h1>
        </div>
        <div class="col-12">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 pr-0" style="padding-right: 0;">
                        {{-- add card --}}
                        <div class="card" style="border: none">
                            <div class="card-header border-0"
                                style="height:310px; border: none; background-color:#f8f7f5">

                            </div>
                            <div class="card-body p-0">
                                <div class="pr-2 pt-2 pb-2 p-5 text-white"
                                    style="background-color: #e4a229; border-radius: 10px 0px 0px 0px; display: flex;align-items: center;height: 2.85rem;">
                                    <img src="{{ asset('assets/img/icon/target.png') }}" height="15" alt="" srcset=""
                                        class="margin-right-15px">Objective
                                </div>
                                <div class="pr-2 pt-2 pb-2 p-5 text-white"
                                    style="background-color: #eead35;display: flex;align-items: center; height: 2.85rem;">
                                    <img src="{{ asset('assets/img/icon/process.png') }}" height="18" alt="" srcset=""
                                        class="margin-right-15px">Process
                                </div>
                                <div class="pr-2 pt-2 pb-2 p-5 text-white"
                                    style="background-color: #e4a229; height: 4rem; display: flex;align-items: center;">
                                    <img src="{{ asset('assets/img/icon/participant.png') }}" height="15" alt=""
                                        srcset="" class="margin-right-15px">Participants
                                </div>
                                <div class="pr-2 pt-2 pb-2 p-5 text-white"
                                    style="background-color: #eead35;display: flex;align-items: center;"><img
                                        src="{{ asset('assets/img/icon/reports.png') }}" height="18" alt="" srcset=""
                                        class="margin-right-15px">Report</div>
                                <div class="pr-2 pt-2 pb-2 p-5 text-white"
                                    style="background-color: #e4a229;display: flex;align-items: center;height: 4rem;">
                                    <img src="{{ asset('assets/img/icon/delverymode.png') }}" height="15" alt=""
                                        srcset="" class="margin-right-15px">Delivery Mode
                                </div>
                                <div class="pr-2 pt-2 pb-2 p-5 text-white"
                                    style="background-color: #eead35;display: flex;align-items: center;"><img
                                        src="{{ asset('assets/img/icon/limitations.png') }}" height="18" alt=""
                                        srcset="" class="margin-right-15px">Limitations</div>

                                <div class="pr-2 pt-2 pb-2 p-5 text-white"
                                    style="background-color: #e4a229; border-radius: 0px 0px 0px 5px;display: flex;align-items: center;">
                                    <img src="{{ asset('assets/img/icon/price.png') }}" height="18" alt="" srcset=""
                                        class="margin-right-15px">Price
                                </div>

                            </div>
                        </div>
                        {{-- end card --}}
                    </div>
                    @foreach($plans as $plan)

                    <div class="col-lg-3 col-md-3 col-sm-3 pl-0" style="{{ $loop->index==0?'padding-left: 0;':'' }}">
                        {{-- add card --}}
                        <div class="card" style="border: none">
                            <div class="card-header border-0"
                                style="height:310px; background-color: #ffffff; border-radius: 5px 5px 0px 0px; -webkit-box-shadow: 0px -10px 0px 0px rgba(0,0,0,0.66);
                                -moz-box-shadow: 0px -10px 0px 0px @if($loop->index==0) #fdc56f @elseif($loop->index==1) #e3a129 @else #eb6323 @endif;
                                box-shadow: 0px -10px 0px 0px @if($loop->index==0) #fdc56f @elseif($loop->index==1) #e3a129 @else #eb6323 @endif;;">
                                <div
                                    class="text-center justify-content-center align-self-center @if($loop->index==0) pt-4 @endif">

                                    <h1
                                        style="color: @if($loop->index==0) #fdc56f @elseif($loop->index==1) #e3a129 @else #eb6323 @endif;">
                                        Plan 0{{ $loop->iteration }}</h1>
                                    <h2 style="color: #231f20;margin-top: 10px !important;">
                                        {{ $plan->PlanTitle }}
                                    </h2>
                                    @if($loop->index==0)
                                    <?php $color='#fdc56f'; ?>
                                    @elseif($loop->index==1)
                                    <?php $color='#e3a129'; ?>
                                    @else
                                    <?php $color='#eb6323'; ?>
                                    @endif
                                    @if($plan->PaymentMethod==1)
                                    <a class="btn btn-lg text-white pt-2 pb-2 p-5 mt-2" href="{{ route('FreeSurvey') }}"
                                        style="background-color: {{ $color }}; font-size: 1.3rem;margin-top: 4.8rem !important;"><b>Get
                                            Started</b></a>
                                    {{-- @elseif($loop->index==1)
                                    <button class="btn btn-lg text-white pt-2 pb-2 p-5 mt-2" data-bs-toggle="modal"
                                        onclick="RenderModal('{{ $plan->id }}', 'Request Plan 2 Service')"
                                        data-bs-target="#requestservice"
                                        style="background-color: #e3a129; font-size: 1.3rem; margin-top: 3.9rem!important"><b>Request
                                            Service</b></button> --}}
                                    @else
                                    <button class="btn btn-lg text-white pt-2 pb-2 p-5 mt-2" data-bs-toggle="modal"
                                        onclick="RenderModal('{{ $plan->id }}', 'Request Plan Service')"
                                        data-bs-target="#requestservice"
                                        style="background-color:  {{ $color }}; font-size: 1.3rem;margin-top: 3.9rem !important;"><b>Request
                                            Service</b></button>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="pr-2 pt-2 pb-2 p-5 text-black text-center"
                                    style="background-color: #f7f7f7; height: 2.85rem;">
                                    <button type="button" class="btn btn-sm p-0 m-0" data-toggle="popover"
                                        title="Objectives" data-popover-content="#Objectives{{$loop->iteration}}"><img
                                            src="{{ asset('assets/img/target.png') }}" height="19" alt=""
                                            srcset=""></button>

                                </div>
                                <div id="Objectives{{$loop->iteration}}" style="display:none;">
                                    <div class="popover-body">

                                        {!! $plan->Objective !!}
                                    </div>
                                </div>
                                <div class="pr-2 pt-2 pb-2 p-5 text-black text-center"
                                    style="background-color: #ffffff; height: 2.85rem;">
                                    <button type="button" class="btn btn-sm p-0 m-0" data-toggle="popover"
                                        title="Process" data-popover-content="#Process{{$loop->iteration}}"><img
                                            src="{{ asset('assets/img/process.png') }}" height="19" alt=""
                                            srcset=""></button>


                                </div>
                                <div id="Process{{$loop->iteration}}" style="display:none;">
                                    <div class="popover-body">

                                        {!! $plan->Process !!}
                                    </div>
                                </div>
                                <div class="pr-2 pt-2 pb-2 p-5 text-black text-center"
                                    style="background-color: #f7f7f7;height: 4rem;">

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
                                </div>
                                <div class="pr-2 pt-2 pb-2 p-5 text-black text-center"
                                    style="background-color: #ffffff;">
                                    <a href="{{ asset($plan->TamplatePath ) }}" download=""><i
                                            class="fa-solid fa-download"></i></a>
                                </div>
                                <div class="pr-2 pt-2 pb-2 p-5 text-black text-center"
                                    style="background-color: #f7f7f7; height: 4rem;">
                                    {{ $plan->DeliveryMode }}</div>
                                <div class="pr-2 pt-2 pb-2 p-5 text-black text-center"
                                    style="background-color: #ffffff;">
                                    <button type="button" class="btn btn-sm p-0 m-0" data-toggle="popover"
                                        title="Limitations" data-popover-content="#Limitations{{$loop->iteration}}">
                                        <img src="{{ asset('assets/img/limitations.png') }}" height="19" alt=""
                                            srcset=""></button>
                                </div>
                                <div id="Limitations{{$loop->iteration}}" style="display:none;">
                                    <div class="popover-body">

                                        {!! !str_contains($plan->Limitations,'Nil')?$plan->Limitations:"Nil"!!}
                                    </div>
                                </div>
                                <div class="pr-2 pt-2 pb-2 p-5 text-black text-center"
                                    style="background-color: #f7f7f7;">
                                    @if ($plan->PaymentMethod==1)
                                    Free
                                    @else
                                    Based on agreed scope
                                    @endif</div>

                            </div>
                        </div>
                        {{-- end card --}}
                    </div>
                    @endforeach


                </div>
            </div>
            {{-- <div class="container">
                <div class="row justify-content-center p-4">


                    @foreach ($plans as $plan)
                    <div class="col-lg-4 col-md-6 sm-mb-30px wow fadeInUp padding-bottom-42px"
                        style="visibility: visible; animation-name: fadeInUp;">
                        <div class="blog-item thum-hover background-white hvr-float hvr-sh2 "
                            style="border-radius: 23px;">
                            <div class="position-relative">
                                <div class="date z-index-101 padding-10px image-builder text-center h2">
                                    {{ $plan->PlanTitle }}
                                </div>

                            </div>
                            <div class="blog-item padding-lr-30px text-center h4">

                                <div class="text-center padding-lr-30px padding-bottom-42px height-200 cms"
                                    data-contentid="11">
                                </div>
                                <div class="text-center blog-item padding-bottom-22px">
                                    {!! $plan->Objective !!}
                                </div>
                                <div class="text-center blog-item padding-bottom-22px">
                                    {!! $plan->Process !!}
                                </div>
                                <div class="padding-bottom-22px">
                                    {!! $plan->Report !!}
                                </div>
                                <div class="padding-bottom-22px">
                                    {!! $plan->DeliveryMode !!}
                                </div>
                                <div class="padding-bottom-22px">
                                    {!! $plan->Limitations !!}
                                </div>
                                <div class="padding-bottom-22px">
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
                                </div>
                                <div class="padding-bottom-22px">
                                    {{ $plan->TamplatePath }}
                                </div>
                                <div class="padding-bottom-22px">

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
                                </div>
                                @if ($plan->PaymentMethod != 1)
                                <div class="padding-bottom-22px">
                                    {{ $plan->Price }}
                                </div>
                                @endif

                                @if ($plan->PaymentMethod != 1)
                                <div class="padding-bottom-22px">
                                    <a href="#" class="btn btn-primary btn-block">{{ __('Strat Free Survey') }}</a>
                                </div>
                                @else
                                <div class="padding-bottom-22px">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#requestservice"
                                        onclick="RenderModal('{{ $plan->id }}','{{ $plan->PlanTitle }}')"
                                        class="btn btn-primary btn-block">{{ __('Request This Service') }}</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div> --}}
        </div>
    </div>
</div>
<div class="container-fluid p-5">
    <div class="row justify-content-center">
        <div class="col-6">
            <h1 class="pt-3 pb-3 text-center text-capitalize">People management framework<sup class="h5">TM</sup></h1>
            <video id="myVid" src="{{ asset('assets/video/Laptop.mp4') }}" autoplay="true" muted="muted">

            </video>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="requestservice" tabindex="-1" aria-labelledby="requestserviceLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="requestserviceLabel">Request service</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('service-request.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="plan_id" id="plan_id" value="">
                        {{-- Company Name --}}
                        <div class="form-group  col-md-6">
                            <label for="name">{{ __('Company Name') }}</label>
                            <input type="text" name="company_name"
                                class="form-control @error('company_name') is-invalid @enderror" id="company_name"
                                placeholder="Enter Company Name">
                            @error('company_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        {{-- company_phone --}}
                        <div class="form-group col-md-6">
                            <label for="name">{{ __('Company Phone') }}</label>
                            <input type="text" name="company_phone"
                                class="form-control @error('company_phone') is-invalid @enderror" id="company_phone"
                                placeholder="Enter Company Phone">
                            @error('company_phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>


                        {{-- fp_name --}}
                        <div class="form-group col-md-6">
                            <label for="name">{{ __('Focal Point Name') }}</label>
                            <input type="text" name="fp_name"
                                class="form-control @error('fp_name') is-invalid @enderror" id="fp_name"
                                placeholder="Enter Focal Point Name">
                            @error('fp_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        {{-- fp_email --}}
                        <div class="form-group  col-md-8">
                            <label for="name">{{ __('Focal Point Email') }}</label>
                            <input type="email" name="fp_email"
                                class="form-control @error('fp_email') is-invalid @enderror" id="fp_email"
                                placeholder="Enter Focal Point Email">
                            @error('fp_email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        {{-- remarks --}}
                        <div class="form-group  col-md-12">
                            <label for="name">{{ __('Remarks') }}</label>
                            <textarea name="remarks" id="remarks" cols="30" rows="10"
                                class="form-control @error('remarks') is-invalid @enderror"></textarea>
                            @error('remarks')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
{{-- scripts --}}
@section('scripts')
<script>
    $(function () {
  $('[data-toggle="popover"]').popover({
    html : true,

        content: function() {
            var content = $(this).attr("data-popover-content");
            return $(content).children(".popover-body").html();
        }
  });

});
function SetUpthis(controle){
    console.log(controle);
    // console.log(controle.attr('data-bs-content'));
}
    $(document).ready(function() {
            // if error is found
            if ($('.is-invalid').length > 0) {
                $('#requestservice').modal('show');
            }
            abcsd(2);
        });



        function RenderModal(id, title) {
            $('#requestserviceLabel').text(title);
            $('#plan_id').val(id);
            //
        }
        //js function
        function abcsd(id) {
            window.addEventListener('load', videoScroll);
            window.addEventListener('scroll', videoScroll);

            videoScroll();

        }
        function videoScroll() {
            var windowHeight = window.innerHeight;
                                var thisVideoEl = document.getElementById('myVid');
                                    videoHeight = thisVideoEl.clientHeight,
                                    videoClientRect = thisVideoEl.getBoundingClientRect().top;

                                if ( videoClientRect <= ( (windowHeight) - (videoHeight*.5) ) && videoClientRect >= ( 0 - ( videoHeight*.5 ) ) ) {
                                    thisVideoEl.play();
                                } else {
                                    thisVideoEl.pause();
                                }
                    }
</script>
@endsection
