@extends('layouts.main')
@section('content')
<div class="container-fluid">
    {{--
    =====================================================================================================================
    --}}

    {{-- add card --}}
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card">
                {{-- card header --}}
                <div class="card-header text-center">
                    <h3>{{__('Please read the following statements and indicate your agreement')}}</h3>
                    <div class="float-end">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Language">
                            {{ ('Change Language') }}
                        </button>
                    </div>
                </div>
                {{-- card body --}}
                <div class="card-body">

                    <div class="row justify-content-center">
                        <div class="col-12">
                            <form action="{{ route('survey.generateSurveyUrl') }}" method="POST"
                                data-bs-multi-step-form>
                                @csrf
                                <div class="progressbar">
                                    <div class="progress" id="progress"></div>

                                    <div class="progress-step stpactive" data-title="Intro"></div>
                                    @foreach ($functions as $function)
                                    <div class="progress-step" data-title="{{  $function->FunctionTitle}}"></div>
                                    @endforeach
                                    {{-- <div class="progress-step" data-title="Contact"></div>
                                    <div class="progress-step" data-title="ID"></div>
                                    <div class="progress-step" data-title="Password"></div>
                                    <div class="progress-step" data-title="dddd"></div> --}}
                                </div>
                                <div class="my-wizard-continar active">
                                    <fieldset>
                                        <legend>{{ __('What is your gender?') }}</legend>
                                        <div class="container-rad">
                                            <div class="radio-tile-group">

                                                <div class="input-container">
                                                    <input id="gender" type="radio" name="gender" value="m">
                                                    <div class="radio-tile">
                                                        <i class="fa-solid fa-mars"></i>
                                                        <label for="gender">{{ __('Male') }}</label>
                                                    </div>
                                                </div>

                                                <div class="input-container">
                                                    <input id="gender" type="radio" name="gender" value="f">
                                                    <div class="radio-tile">
                                                        <i class="fa-solid fa-venus"></i>
                                                        <label for="gender">{{ __('Female') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <legend>{{ __('What is your age generation?') }}</legend>
                                        <div class="container-rad">
                                            <div class="radio-tile-group">

                                                <div class="input-container">
                                                    <input id="generation" type="radio" name="generation">
                                                    <div class="radio-tile justify-content-center text-center">
                                                        {{-- <i class="fa-regular fa-face-angry"></i> --}}
                                                        <label for="generation">Generation X <br> born 1965-1980</label>
                                                    </div>
                                                </div>

                                                <div class="input-container">
                                                    <input id="generation" type="radio" name="generation">
                                                    <div class="radio-tile justify-content-center text-center">
                                                        {{-- <i class="fa-regular fa-face-frown-open"></i> --}}
                                                        <label for="generation">Millennials <br> born 1981-1996</label>
                                                    </div>
                                                </div>

                                                <div class="input-container">
                                                    <input id="generation" type="radio" name="generation">
                                                    <div class="radio-tile justify-content-center text-center">
                                                        {{-- <i class="fa-regular fa-face-meh"></i> --}}
                                                        <label for="generation">Generation Z <br> born 1996-2012</label>
                                                    </div>
                                                </div>
                                                {{-- <div class="input-container">
                                                    <input id="generation" type="radio" name="generation">
                                                    <div class="radio-tile justify-content-center text-center"> --}}
                                                        {{-- <i class="fa-regular fa-face-smile"></i> --}}
                                                        {{-- <label for="generation">Drive</label>
                                                    </div>
                                                </div> --}}

                                                {{-- <div class="input-container">
                                                    <input id="generation" type="radio" name="generation">
                                                    <div class="radio-tile justify-content-center text-center"> --}}
                                                        {{-- <i class="fa-regular fa-face-smile-beam"></i> --}}
                                                        {{-- <label for="generation">Fly</label>
                                                    </div>
                                                </div> --}}

                                            </div>
                                        </div>
                                    </fieldset>
                                    <button type="button" class="btn btn-primary float-end" data-bs-next>{{
                                        __('Next')
                                        }}</button>
                                </div>
                                @foreach ( $functions as $function )

                                <div class="my-wizard-continar">
                                    @foreach ($function->functionPractices as $practice)

                                    <fieldset>
                                        <legend class="mb-5 pb-5 mt-5 pt-5">{{ $loop->iteration }}.@if(app()->getLocale()=='en')
                                            {{$practice->practiceQuestions->Question }}
                                                @elseif (app()->getLocale()=='ar')
                                                {{$practice->practiceQuestions->QuestionAr }}
                                                @elseif (app()->getLocale()=='in')
                                                {{$practice->practiceQuestions->QuestionIn }}
                                                @endif
                                        </legend>
                                        <div class="container-rad mb-5 pb-5 mt-5 pt-5">
                                            <div class="radio-tile-group">

                                                <div class="input-container text-center">
                                                    <input id="survey" type="radio"
                                                        name="survey-{{ $practice->practiceQuestions->id }}" value="1">
                                                    <div class="radio-tile">
                                                        <i class="fa-regular fa-face-angry"></i>
                                                        <label for="survey">{{ __('Strongly Disagree') }}</label>
                                                    </div>
                                                </div>

                                                <div class="input-container text-center">
                                                    <input id="survey" type="radio"
                                                        name="survey-{{ $practice->practiceQuestions->id }}" value="2">
                                                    <div class="radio-tile">
                                                        <i class="fa-regular fa-face-frown-open"></i>
                                                        <label for="survey">{{ __('Disagree') }}</label>
                                                    </div>
                                                </div>

                                                <div class="input-container text-center">
                                                    <input id="survey" type="radio"
                                                        name="survey-{{ $practice->practiceQuestions->id }}" value="3">
                                                    <div class="radio-tile">
                                                        <i class="fa-regular fa-face-meh"></i>
                                                        <label for="survey">{{ __('neutral') }}</label>
                                                    </div>
                                                </div>
                                                <div class="input-container text-center">
                                                    <input id="survey" type="radio"
                                                        name="survey-{{ $practice->practiceQuestions->id }}" value="4">
                                                    <div class="radio-tile">
                                                        <i class="fa-regular fa-face-smile"></i>
                                                        <label for="survey">{{ __('Agree') }}</label>
                                                    </div>
                                                </div>

                                                <div class="input-container text-center">
                                                    <input id="survey" type="radio"
                                                        name="survey-{{ $practice->practiceQuestions->id }}" value="5">
                                                    <div class="radio-tile">
                                                        <i class="fa-regular fa-face-smile-beam"></i>
                                                        <label for="survey">{{ __('Strongly Agree') }}</label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </fieldset>
                                    @endforeach
                                    @if (!$loop->last)

                                    <button type="button" class="btn btn-primary float-end" data-bs-next>{{
                                        __('Next')
                                        }}</button>
                                    @else
                                    <button type="button" class="btn btn-primary float-end" data-bs-submit>{{
                                        __('Submit')
                                        }}</button>
                                    @endif
                                    <button type="button" class="btn btn-primary float-start" data-bs-previous>{{
                                        __('Previous')
                                        }}</button>
                                </div>
                                @endforeach
                                {{-- personal details --}}
                                {{-- <div class="my-wizard-continar"> --}}
                                    {{-- collect first name and second name --}}
                                    {{--
                                    <div class="form-group col-lg-6 col-md-9 col-sm-12">
                                        <label for="first_name">{{ __('First Name:') }}</label>
                                        <input type="text" name="first_name" id="" class="form-control"
                                            placeholder="{{ __('Enter First Name') }}" aria-describedby="helpId">
                                        <small id="helpId" class="text-muted">{{ __('First Name') }}</small>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-9 col-sm-12">
                                        <label for="second_name">{{ __('Second Name:') }}</label>
                                        <input type="text" name="second_name" id="" class="form-control"
                                            placeholder="{{ __('Enter Second Name') }}" aria-describedby="helpId">
                                        <small id="helpId" class="text-muted">{{ __('Second Name') }}</small>
                                    </div> --}}


                                    {{-- next btn --}}
                                    {{-- a link with javascript void --}}

                                    {{-- <button type="button" class="btn btn-primary float-end" data-bs-next>{{
                                        __('Next')
                                        }}</button>
                                    <button type="button" class="btn btn-primary float-start" data-bs-previous>{{
                                        __('Previous')
                                        }}</button>
                                </div> --}}
                                {{-- contact details --}}
                                {{-- <div class="my-wizard-continar"> --}}
                                    {{-- email address phone and mobile --}}
                                    {{--
                                    <div class="form-group col-lg-6 col-md-9 col-sm-12">
                                        <label for="email">{{ __('Email address:') }}</label>
                                        <input type="email" name="email" id="" class="form-control"
                                            placeholder="{{ __('Enter Email Address') }}" aria-describedby="helpId">
                                        <small id="helpId" class="text-muted">{{ __('Email Address') }}</small>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-9 col-sm-12">
                                        <label for="phone">{{ __('Phone:') }}</label>
                                        <input type="text" name="phone" id="" class="form-control"
                                            placeholder="{{ __('Enter Phone Number') }}" aria-describedby="helpId">
                                        <small id="helpId" class="text-muted">{{ __('Phone Number') }}</small>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-9 col-sm-12">
                                        <label for="mobile">{{ __('Mobile:') }}</label>
                                        <input type="text" name="mobile" id="" class="form-control"
                                            placeholder="{{ __('Enter Mobile Number') }}" aria-describedby="helpId">
                                        <small id="helpId" class="text-muted">{{ __('Mobile Number') }}</small>
                                    </div>

                                    <button type="button" class="btn btn-primary float-end" data-bs-next>{{
                                        __('Next')
                                        }}</button>
                                    <button type="button" class="btn btn-primary float-start" data-bs-previous>{{
                                        __('Previous')
                                        }}</button>
                                </div> --}}
                                {{-- employee details --}}
                                {{-- <div class="my-wizard-continar">
                                    {{-- department designation role --}}

                                    {{-- <div class="form-group col-lg-6 col-md-9 col-sm-12">
                                        <label for="department">{{ __('Department:') }}</label>
                                        <input type="text" name="department" id="" class="form-control"
                                            placeholder="{{ __('Enter Department') }}" aria-describedby="helpId">
                                        <small id="helpId" class="text-muted">{{ __('Department') }}</small>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-9 col-sm-12">
                                        <label for="designation">{{ __('Designation:') }}</label>
                                        <input type="text" name="designation" id="" class="form-control"
                                            placeholder="{{ __('Enter Designation') }}" aria-describedby="helpId">
                                        <small id="helpId" class="text-muted">{{ __('Designation') }}</small>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-9 col-sm-12">
                                        <label for="role">{{ __('Role:') }}</label>
                                        <input type="text" name="role" id="" class="form-control"
                                            placeholder="{{ __('Enter Role') }}" aria-describedby="helpId">
                                        <small id="helpId" class="text-muted">{{ __('Role') }}</small>
                                    </div>

                                    <button type="button" class="btn btn-primary float-end" data-bs-next>{{
                                        __('Next')
                                        }}</button>
                                    <button type="button" class="btn btn-primary float-start" data-bs-previous>{{
                                        __('Previous')
                                        }}</button>
                                </div> --}}

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{--=====================================================================================================================--}}
<!-- Modal -->
<div class="modal fade" id="Language" tabindex="-1" aria-labelledby="LanguageLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="LanguageLabel">{{ __('Choose Your Language') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <a href="{{ route('lang.swap','en') }}" class="btn btn-lg">ُEnglish</a>
                <a href="{{ route('lang.swap','ar') }}" class="btn btn-lg">العربية</a>
                <a href="{{ route('lang.swap','in') }}" class="btn btn-lg">Hindi</a>
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    //document ready function
    $(document).ready(function () {
        if("{{ session('locale') }}" =="")
        {$('#Language').modal('show');
    }
        //next button click function
        //form
    var form = document.querySelector('[data-bs-multi-step-form]');
       //get array of divs that has my-wizard-continar class
    var divs = [...form.querySelectorAll('.my-wizard-continar')];
    var progressSteps = [...form.querySelectorAll('.progress-step')];
    var progress = document.getElementById('progress');
    //get current setp form
    currentStep = parseInt(divs.findIndex(step =>{return step.classList.contains("active")}))
    if(currentStep<0)
    {
        currentStep=0;
        divs[currentStep].classList.add("active");
    }
//next button click event listener
    //get array of links that has btn class
    form.addEventListener('click', e=>{
        var valid = true;
        let increment;
        var answers = [];
        if(e.target.matches('[data-bs-submit]'))
        {

            //get all check radion button with id survey
            var radioButtons = [...form.querySelectorAll(`input[id="survey"]`)];
            //get check one only
            var radioCheckeds =[ ...radioButtons.filter(radio=>{return radio.checked})];
            radioCheckeds.forEach(radioChecked=>{
                //get value of checked radio
                var radioValue = radioChecked.value;
                //get name of checked radio
                var radioName = radioChecked.name;
                //get id of checked radio
                var radioId = radioChecked.id;
                //get all radio buttons with same name

                //split rdioName by -
                var radioNameArray = radioName.split("-");
                //get question id
                var questionId = radioNameArray[1];
                //add questionId and radioValue to answers array
                answers.push({questionId:questionId,answer:radioValue});

            })


        }
        if(e.target.matches('[data-bs-next]'))
        {
            increment=1;

        }
        if(e.target.matches('[data-bs-previous]'))
        {

        increment=-1;
        }
        //get all inputs in current step
        //check if all inputs are filled
        if (increment==null)  return;
        var inputs = [...divs[currentStep].querySelectorAll('input')];
        if(increment>0){
        inputs.forEach(input=>{

            //check if input has value
            //check if radio button is checked
            //check if input is valid

            if(input.checkValidity() && input.value !="" )
            {
                if(input.type=="radio")
                {
                    //add radio name to array
                    var radioName = input.name;
                    //get all radio buttons with same name
                    var radioButtons = [...form.querySelectorAll(`input[name="${radioName}"]`)];
                    //check if any radio button is checked
                    var radioChecked = radioButtons.some(radio=>{return radio.checked});
                    if(!radioChecked)
                    {
                        valid=false;
                        input.classList.add("is-invalid");

                        return
                    }
                }
                input.classList.remove("is-invalid");

            }
            else
            {

                valid=false;
                input.classList.add("is-invalid");
            }
        })
    }
        if(valid)
        {
            currentStep+=increment;
            showCurrentStep();
            upDateProgress();
        }
        else{
            Swal.fire(
                        'Did you answer all questions?',
                        'Please answer all questions',
                        'error'
                    );
        }
    })
    function showCurrentStep()
    {
        divs.forEach((element,index) => {
            element.classList.toggle("active",index===currentStep)
        });

    }
    function upDateProgress()
    {

                progressSteps.forEach((progressStep, idx) => {
    if (idx < currentStep + 1) {
        setTimeout(function() {
            progressSteps[idx-1].classList.add("stpcomplete");
            progressSteps[idx-1].classList.remove("stpactive");
    }, 100);
      progressStep.classList.add("stpactive");
      progressStep.classList.remove("stpcomplete");
    } else {
      progressStep.classList.remove("stpactive");
    }
  });
  const progressActive = document.querySelectorAll(".stpactive");

  progress.style.width =
    ((progressActive.length - 1) / (progressSteps.length - 1)) * 100 + "%";
    }
    ///submit button
    });
</script>
@endsection
