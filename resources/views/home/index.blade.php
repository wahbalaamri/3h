@extends('layouts.main')
@section('content')
{{-- add imager banner --}}
<div class="container-fluid">
    <div class="row main-bg">
        <div class="col-lg-4 col-md-12 col-sm-12 p-0 m-0 d-flex">
            <img src="{{ asset('assets/img/mainbg.webp') }}" class="float-start image-2" alt="" srcset="">
        </div>
        <div class="col-lg-8 col-md-12 col-sm-12 p-0 m-0 text-center justify-content-center align-self-center">
            <h1 class="text-white" style="font-size: 3.4rem">
                {{__('Are you measuring and elevating your Employee Engagement Level in your organization')}}
            </h1>
            {{-- <span style="font-size: 2.4rem">
                Maximize your return on people investment
            </span> --}}
        </div>

    </div>
</div>
{{-- end add imager banner --}}
{{-- add welcome paragraph --}}
<div class="container-fluid p-5">
    {{-- <div class="row"> --}}
        <div class="col-12 text-center justify-content-center align-self-center d-flex">
            <h1 class="text-start" style="color: #f09e2e;
            font-size: 54px;">
                {{ __('Our Methodology:') }}
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
                <div class="col-lg-3 col-md-12 col-sm-12">
                    <div class="col-12">
                        <img src="{{ asset('assets/img/FTH.webp') }}" alt="" srcset="" height="" style="">
                    </div>
                    {{-- <div class="col-12">
                        <div class="w-75 m-auto p-3">

                            <p class="">We believe that HR value is defined by the receivers(managers) and not by
                                the giver (HR department) and thus we assess the managers' experience in handling HR
                                activities in a way serving their business needs.

                            </p>
                        </div>
                    </div> --}}
                </div>
                {{-- <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="col-12">
                        <img src="{{ asset('assets/img/approach2.png') }}" alt="" srcset="" height="80" style="">
                    </div>
                    <div class="col-12">
                        <div class="w-75 m-auto p-3">
                            <p class="text-center">We also believe in the value of enhancing the employee experience and
                                thus we also capture employees’ voices.</p>
                        </div>
                    </div>
                </div> --}}
                <div class="col-lg-9 col-md-12 col-sm-12">
                    <div class="col-12">
                        <div class="w-75 m-auto p-3">
                            <p class="text-start" style="font-size: 24px">{{__('For employees to contribute optimally, organizations need to engage the whole person’s;')}}
                            </p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-4">

                                <span class="" style="color: #f09e2e; font-size: 127px;">
                                    3H
                                </span>
                            </div>
                            <div class="col-8" style="display: grid">
                                <div class="row">
                                    <div class="col-4">
                                        <img src="{{ asset('assets/img/heart.webp') }}" alt="" srcset="" height=""
                                            style="">
                                    </div>
                                    <div class="col-4">
                                        <img src="{{ asset('assets/img/Head.webp') }}" alt="" srcset="" height=""
                                            style="">
                                    </div>
                                    <div class="col-4"><img src="{{ asset('assets/img/Hand.webp') }}" alt="" srcset=""
                                            height="" style=""></div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <span style="color: red; font-size: 38px;"> Heart</span>
                                    </div>
                                    <div class="col-4">
                                        <span style="color: red; font-size: 38px;"> Head</span>
                                    </div>
                                    <div class="col-4"><span style="color: red; font-size: 38px;"> Hand</span></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-12">
                        <div class="w-75 m-auto p-3">
                            <p class="text-start" style="font-size: 24px">{{ __('Engaging the heart is the center of employee engagement. When the heart is engaged, the mind will be stimulated to think. When the heart and mind are active, the human being must be enabled to give hand.') }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        {{--
    </div> --}}
</div>
<div class="container-fluid p-5">
    {{-- <div class="row"> --}}
        <div class="col-12 text-center justify-content-center align-self-center d-flex">
            <h1 class="text-start" style="color: #f09e2e;
            font-size: 54px;">
                {{ __('Employee Engagement:') }}
            </h1>

        </div>
        <div class="col-12 text-center justify-content-center align-self-center pt-5">
            <div class="row">
                <div class="col-lg-5 col-md-12 col-sm-12 d-flex">
                    <p class="text-start col-9 float-end" style="font-size: 24px">
                        {{ __('The emotional, mental and physical connection of employees to the organization that drives an extraordinary personal contribution that achieves a win-win situation for a better employee happiness and organizational outcome.') }} </p>
                </div>

                <div class="col-lg-4 col-md-12 col-sm-12">
                    <img src="{{ asset('assets/img/all.webp') }}" alt="" srcset="" height="" style="">
                </div>
                <div class="col-lg-3 col-md-12 col-sm-12">
                    <div class="col-lg-12 text-start d-flex">
                        <span style="font-size: 26px">
                            <b class="{{ App()->getLocale()=='ar'? 'float-end':'float-start' }}">{{ __('Heart') }}</b><br>
                            {{ __('Emotional Connection') }}
                        </span>
                    </div>
                    <div class="col-lg-12 text-start d-flex">
                        <span style="font-size: 26px">
                            <b class="{{ App()->getLocale()=='ar'? 'float-end':'float-start' }}">{{ __("Head") }}</b><br>
                            {{ __('Intellectual Stimulation') }}
                        </span>
                    </div>
                    <div class="col-lg-12 text-start d-flex">
                        <span style="font-size: 26px">
                            <b class="{{ App()->getLocale()=='ar'? 'float-end':'float-start' }}">{{ __('Hand') }}</b><br>
                            {{ __('Enablement') }}
                        </span>
                    </div>


                </div>
            </div>
        </div>
        {{--
    </div> --}}
</div>
<div class="container-fluid p-5">
    {{-- <div class="row"> --}}

        <div class="col-12 text-center justify-content-center align-self-center pt-5">
            <div class="row">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <div class="col-12">
                        <img src="{{ asset('assets/img/nabahan.webp') }}" alt="" srcset="" height="" style="">
                        <div class="row d-flex">
                            <p class="{{ App()->getLocale()=='ar'? 'text-end':'text-start' }}">
                                <span style="font-size: 36px; font-style: italic">{{ __('Contact :') }}
                                </span><br>
                                <span
                                    style="font-size: 36px;font-style: italic; font-weight: bold; color:#f09e2e; margin: 0; padding: 0;">
                                    {{ __('Nabahan Al Kharusi') }}
                                </span>
                                <br>
                                <span style="font-size: 26px; font-style: italic">{{ __('Employee EngagementExpert') }}
                                </span><br>
                                <span style="font-size: 23px; font-weight: 500">
                                    <i class="fa fa-phone"></i>
                                    +968 95327705
                                </span><br>
                                <span style="font-size: 23px;">
                                    <i class="fa fa-envelope"></i>
                                    Nabahan@extramiles-om.com
                                </span><br>
                                <hr class="w-75">
                                <span style="font-size: 21px;" class="{{ App()->getLocale()=='ar'? 'text-end':'text-start' }}">
                                    {{ __('Or Clients Happiness Champion:') }}
                                </span><br>
                                <span class="{{ App()->getLocale()=='ar'? 'text-end':'text-start' }}"
                                    style="font-size: 26px;font-style: italic; font-weight: bold; color:#f09e2e; margin: 0; padding: 0;">
                                    {{ __('Muath Al Musalmi') }}
                                </span>
                                <br>
                                <span style="font-size: 23px; font-weight: 500" class="{{ App()->getLocale()=='ar'? 'text-end':'text-start' }}">
                                    <i class="fa fa-phone"></i>
                                    +968 7917 8007
                                </span><br>
                            </p>
                        </div>
                    </div>
                    {{-- <div class="col-12">
                        <div class="w-75 m-auto p-3">

                            <p class="">We believe that HR value is defined by the receivers(managers) and not by
                                the giver (HR department) and thus we assess the managers' experience in handling HR
                                activities in a way serving their business needs.

                            </p>
                        </div>
                    </div> --}}
                </div>
                {{-- <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="col-12">
                        <img src="{{ asset('assets/img/approach2.png') }}" alt="" srcset="" height="80" style="">
                    </div>
                    <div class="col-12">
                        <div class="w-75 m-auto p-3">
                            <p class="text-center">We also believe in the value of enhancing the employee experience and
                                thus we also capture employees’ voices.</p>
                        </div>
                    </div>
                </div> --}}
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <div class="col-12 d-flex">
                        <h1 class="text-start" style="color: #f09e2e;
                        font-size: 50px; font-weight: bold; font-style: italic">
                            {{ __('Employee Engagement:') }}
                        </h1>
                    </div>
                    <div class="row pt-5">
                        <div class="col-lg-7">
                            <img src="{{ asset('assets/img/heart-indic.webp') }}" alt="">
                        </div>
                        <div class="col-lg-2 my-auto">
                            <img src="{{ asset('assets/img/heart.webp') }}" height="50" alt="">
                        </div>
                        <div class="col-lg-3 text-start my-auto">
                            <h1 style="font-size: 21px" class="{{ App()->getLocale()=='ar'? 'text-end':'text-start' }}"><b>{{ __('Heart') }}</b></h1>
                            <p style="font-size: 20px" class="{{ App()->getLocale()=='ar'? 'text-end':'text-start' }}">{{ __('80% Emotional Connection') }}
                            </p>
                        </div>
                    </div>
                    <div class="row pt-5">
                        <div class="col-lg-7">
                            <img src="{{ asset('assets/img/head-indic.webp') }}" alt="">
                        </div>
                        <div class="col-lg-2 my-auto">
                            <img src="{{ asset('assets/img/Head.webp') }}" height="50" alt="">
                        </div>
                        <div class="col-lg-3 text-start my-auto">
                            <h1 style="font-size: 21px" class="{{ App()->getLocale()=='ar'? 'text-end':'text-start' }}"><b>{{ __('Head') }}</b></h1>
                            <p style="font-size: 20px" class="{{ App()->getLocale()=='ar'? 'text-end':'text-start' }}">{{ __('55% Intellectual Stimulation') }}</p>
                        </div>
                    </div>
                    <div class="row pt-5">
                        <div class="col-lg-7">
                            <img src="{{ asset('assets/img/hand-indic.webp') }}" alt="">
                        </div>
                        <div class="col-lg-2 my-auto">
                            <img src="{{ asset('assets/img/Hand.webp') }}" height="50" alt="">
                        </div>
                        <div class="col-lg-3 text-start my-auto">
                            <h1 style="font-size: 21px" class="{{ App()->getLocale()=='ar'? 'text-end':'text-start' }}"><b>{{ __('Hand') }}</b></h1>
                            <p style="font-size: 20px" class="{{ App()->getLocale()=='ar'? 'text-end':'text-start' }}">{{ __('33% Enablement') }}</p>
                        </div>
                    </div>
                    <div class="row pt-5 {{ App()->getLocale()=='ar'? 'text-end':'text-start' }}">
                        <p>
                            <span style="font-size: 19px; font-weight: bold">{{ __('Employee Net Promotor Score (eNPS)') }}
                            </span><br>
                            <span style="font-size: 17px; ">{{ __('How likely to recommend XXX as a good place to work?') }}
                            </span><br>
                        </p>

                    </div>
                    <div class="row pt-5 text-start">
                       <img src="{{ asset('assets/img/footer.webp') }}" alt="" height="125">
                    </div>
                </div>
            </div>
        </div>
        {{--
    </div> --}}
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
