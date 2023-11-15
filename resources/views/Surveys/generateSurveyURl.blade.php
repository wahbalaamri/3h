@extends('layouts.main')
@section('content')
<div class="container">
    {{-- add card --}}
    <div class="row justify-content-center">
        <div class="col-lg-9 col-md-10 col-sm-12">
            <div class="card">
                {{-- card header --}}
                <div class="card-header">
                    <h3>{{__('Generate Survey')}}</h3>
                </div>
                {{-- card body --}}
                <div class="card-body">
                    <div class="row justify-content-center">
                        {{-- informal alert --}}
                        <div class="col-lg-8 col-md-10 col-sm-12">
                            <div class="alert alert-info fade show" role="alert">
                                <strong>{{ __('Info') }}!</strong> {{ __('Please fill the form below to generate survey URL') }}
                                <p>
                                    <strong>{{ __('Notice') }}!</strong>
                                    {{-- your infromation will remain secure and hashed no one can read your persnoal details --}}
                                    {{ __('Your information will remain secure and private, ensuring that no one can access or read your personal details.') }}
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
                                    <small id="helpId" class="text-muted">{{ __('Email Address') }}</small>
                                </div>
                                <div class="form-group col-lg-8 col-md-9 col-sm-12">
                                    <label for="mobile">{{ __('Mobile:') }}</label>
                                    <input type="text" name="mobile" id="" class="form-control"
                                        placeholder="{{ __('Enter Mobile Number') }}" aria-describedby="helpId">
                                    <small id="helpId" class="text-muted">{{ __('Mobile Number') }}</small>
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
@endsection
