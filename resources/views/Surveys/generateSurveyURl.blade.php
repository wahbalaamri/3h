@extends('layouts.main')
@section('content')
<div class="container">
    {{-- add card --}}
    <div class="row justify-content-center">
        <div class="col-lg-9 col-md-10 col-sm-12">
            <div class="card">
                {{-- card header --}}
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-9 col-sm-12">
                            <h3>{{__('Generate Survey')}}</h3>
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
                        {{-- informal alert --}}
                        <div class="col-lg-8 col-md-10 col-sm-12">
                            <div class="alert alert-info fade show" role="alert">
                                <strong>{{ __('Info') }}!</strong> {{ __('Please enter either your email or phone number to take survey') }}
                                <p>
                                    <strong>{{ __('Notice') }}!</strong>
                                    {{-- your infromation will remain secure and hashed no one can read your
                                    persnoal details --}}
                                    {{ __('Your information will remain secure and private, ensuring that no one can access or identify your personal details.') }}
                                </p>

                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-10 col-sm-12">
                            <form action="{{ route('survey.generateSurveyUrl') }}" method="POST">
                                @csrf
                                @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>{{ __('Success') }}!</strong> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                @endif
                                @if (session('error'))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>{{ __('Warning') }}!</strong> {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                @endif
                                <div class="form-group col-lg-8 col-md-9 col-sm-12">
                                    <label for="email">{{ __('Email address:') }}</label>
                                    <input type="email" name="email" id="" class="form-control"
                                        placeholder="{{ __('Enter Email Address') }}" aria-describedby="helpId">
                                    <small id="helpId" class="text-muted"><b>{{ __('Hint:') }}</b>{{ __('Enter your email address') }}</small>
                                </div>
                                <div class="form-group col-lg-8 col-md-9 col-sm-12">
                                    <label for="mobile">{{ __('Mobile:') }}</label>
                                    <input type="text" name="mobile" id="" class="form-control"
                                        placeholder="{{ __('Enter Mobile Number') }}" aria-describedby="helpId">
                                    <small id="helpId" class="text-muted"><b>{{ __('Hint:') }}</b>{{ __('Mobile Number') }}</small>
                                </div>
                                {{-- <div class="form-group col-lg-8 col-md-9 col-sm-12">
                                    <label for="employee_id">{{ __('Employee ID:') }}</label>
                                    <input type="text" name="employee_id" id="" class="form-control"
                                        placeholder="{{ __('Enter Employee ID') }}" aria-describedby="helpId">
                                    <small id="helpId" class="text-muted">{{ __('Employee ID') }}</small>
                                </div> --}}
                                <div
                                    class="form-group col-lg-8 col-md-9 col-sm-12 {{ app()->getLocale()=='ar'? 'text-start':'text-end' }}">
                                    {{-- submit button --}}
                                    <button type="submit" class="btn btn-primary">{{ __('Proceed to Survey')
                                        }}</button>
                                </div>
                            </form>
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
