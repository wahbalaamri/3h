@extends('layouts.main')
@section('content')
<div class="container">
    {{-- add card --}}
    <div class="row justify-content-center">
        <div class="col-lg-9 col-md-10 col-sm-12 ">
            <div class="card">
                {{-- card header --}}
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-9 col-sm-12">
                            <h3>{{__('Survey QR Code')}}</h3>
                        </div>
                        <div class="col-md-3 col-sm-12">

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#Language">
                                {{ __('Change Language') }}
                            </button>

                        </div>
                    </div>
                </div>
                {{-- card body --}}
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-10 col-sm-12 text-center">
                            {{ $data }}
                        </div>
                    </div>
                    {{-- create from that tack Email Address, Mobile & Employee ID --}}

                </div>
            </div>
        </div>
    </div>
</div>
{{--=====================================================================================================================--}}
<!-- Modal -->
<div class="modal fade" id="Language" tabindex="-1" aria-labelledby="LanguageLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="LanguageLabel">{{ __('Choose Your Language') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-row d-flex justify-content-center">
                    <div class="p-2 d-flex justify-content-center"><a href="{{ route('lang.swap','en') }}"
                            class="btn btn-sm btn-secondary">
                            <h5>ُEnglish</h5>
                            <img src="{{ asset('assets/img/UKFLag.png') }}" class="img-fluid" alt="" height="100"
                                width="100" srcset="">
                            {{-- add cdn UK flag to the button --}}
                        </a></div>
                    <div class="p-2 d-flex justify-content-center" dir="rtl"><a href="{{ route('lang.swap','ar') }}"
                            class="btn btn-sm btn-secondary">
                            <h5>العربية</h5>
                            <img src="{{ asset('assets/img/OmanFlage.png') }}" alt="" class="img-fluid" height="100"
                                width="100" srcset="">
                        </a></div>
                    <div class="p-2 d-flex justify-content-center"><a href="{{ route('lang.swap','in') }}"
                            class="btn btn-sm btn-secondary">
                            <h5>हिंदी</h5>
                            <img src="{{ asset('assets/img/IndiaFlag.png') }}" alt="" class="img-fluid" height="100"
                                width="100" srcset="">
                        </a></div>
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> --}}
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    //document ready function
    $(document).ready(function () {
        if("{{ session('locale') }}" =="")
        {$('#Language').modal('show');
    }
});
</script>
@endsection
