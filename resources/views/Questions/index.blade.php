@extends('layouts.main')
@push('styles')
<link href="{{ asset('assets/css/questionnair.css') }}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet"
    type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet"
    type="text/css" />
@endpush
@section('content')
<div id="smartwizard">
    <ul class="nav">
        <?php $x = 1; ?>
        @foreach ($functions as $function)
        <?php $x = $loop->iteration; ?>
        <li class="nav-item">
            <a class="nav-link" href="#step-{{ $loop->iteration }}">
                <div class="num">{{ $loop->iteration }}</div>
                {{ $function->FunctionTitle }}
            </a>
        </li>
        @endforeach
        @if ($can_ansewer_to_priorities)
        <?php $x++; ?>
        <li class="nav-item">
            <a class="nav-link" href="#step-{{ $x }}">
                <div class="num">{{ $x }}</div>Priorities
            </a>
        </li>
        @endif
        {{-- <li class="nav-item">
            <a class="nav-link" href="#step-2">
                <span class="num">2</span>
                Step Title
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#step-3">
                <span class="num">3</span>
                Step Title
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="#step-4">
                <span class="num">4</span>
                Step Title
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="#step-5">
                <span class="num">5</span>
                Step Title
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="#step-6">
                <span class="num">6</span>
                Step Title
            </a>
        </li> --}}
    </ul>

    <div class="tab-content">
        <?php $i = 1; ?>
        @foreach ($functions as $function)
        <?php $i = $loop->iteration; ?>
        <div id="step-{{ $loop->iteration }}" class="tab-pane" role="tabpanel"
            aria-labelledby="step-{{ $loop->iteration }}">
            <?php $counter = 0; ?>
            <div class="alert alert-success text-center" style="font-size: 1.4rem">
                Please read the following statements and indicate your agreement and disagreement wherein 1 indicates total disagreement and 6 indicates high agreement
            </div>
            <div class="Qcontainer">
                <p style="font-size: 1.8rem; letter-spacing: 4px" class="h2 text-info text-center">1 is the lowest &
                    6 is the
                    highest
                </p>
                @foreach ($function->functionPractices as $practice)
                <?php
                            $practiceQuestion = $practice->practiceQuestions != null ? $practice->practiceQuestions : null;
                            ?>
                @if ($user_type == 3)
                @if ($practiceQuestion->Respondent == 2 ||
                $practiceQuestion->Respondent == 4 ||
                $practiceQuestion->Respondent == 5 ||
                $practiceQuestion->Respondent == 7 ||
                $practiceQuestion->Respondent == 8)
                <?php $counter++; ?>
                <p style="font-size: 1.4rem;">{{ $counter }}.
                    @if ($practiceQuestion != null)
                    {{ $practiceQuestion->Question != null ? $practiceQuestion->Question : 'No' }}
                    @endif
                </p>
                <div id="{{ $practiceQuestion->id }}" class="rb pquestions" data-QId="{{ $practiceQuestion->id }}"
                    data-answer="notset" data-type="q">
                    <div class="tab" data-value="1">
                        <div class="spot">
                            <span class="txt">1</span>
                        </div>
                    </div>
                    <div class="tab" data-value="2">
                        <div class="spot">
                            <span class="txt">2</span>
                        </div>
                    </div>
                    <div class="tab" data-value="3">
                        <div class="spot">
                            <span class="txt">3</span>
                        </div>
                    </div>
                    <div class="tab" data-value="4">
                        <div class="spot">
                            <span class="txt">4</span>
                        </div>
                    </div>
                    <div class="tab" data-value="5">
                        <div class="spot">
                            <span class="txt">5</span>
                        </div>
                    </div>
                    <div class="tab" data-value="6">
                        <div class="spot">
                            <span class="txt">6</span>
                        </div>
                    </div>
                </div>
                @endif
                @endif
                @if ($user_type == 2)
                @if ($practiceQuestion->Respondent == 1 ||
                $practiceQuestion->Respondent == 4 ||
                $practiceQuestion->Respondent == 6 ||
                $practiceQuestion->Respondent == 7 ||
                $practiceQuestion->Respondent == 8)
                <?php $counter++; ?>
                <p style="font-size: 1.4rem;">{{ $counter }}.
                    @if ($practiceQuestion != null)
                    {{ $practiceQuestion->Question != null ? $practiceQuestion->Question : 'No' }}
                    @endif
                </p>
                <div id="{{ $practiceQuestion->id }}" class="rb pquestions" data-QId="{{ $practiceQuestion->id }}"
                    data-answer="notset" data-type="q">
                    <div class="tab" data-value="1">
                        <div class="spot">
                            <span class="txt">1</span>
                        </div>
                    </div>
                    <div class="tab" data-value="2">
                        <div class="spot">
                            <span class="txt">2</span>
                        </div>
                    </div>
                    <div class="tab" data-value="3">
                        <div class="spot">
                            <span class="txt">3</span>
                        </div>
                    </div>
                    <div class="tab" data-value="4">
                        <div class="spot">
                            <span class="txt">4</span>
                        </div>
                    </div>
                    <div class="tab" data-value="5">
                        <div class="spot">
                            <span class="txt">5</span>
                        </div>
                    </div>
                    <div class="tab" data-value="6">
                        <div class="spot">
                            <span class="txt">6</span>
                        </div>
                    </div>
                </div>
                @endif
                @endif
                @if ($user_type == 1)
                @if ($practiceQuestion->Respondent == 3 ||
                $practiceQuestion->Respondent == 5 ||
                $practiceQuestion->Respondent == 6 ||
                $practiceQuestion->Respondent == 7 ||
                $practiceQuestion->Respondent == 8)
                <?php $counter++; ?>
                <p style="font-size: 1.4rem;">{{ $counter }}.
                    @if ($practiceQuestion != null)
                    {{ $practiceQuestion->Question != null ? $practiceQuestion->Question : 'No' }}
                    @endif
                </p>
                <div id="{{ $practiceQuestion->id }}" class="rb pquestions" data-QId="{{ $practiceQuestion->id }}"
                    data-answer="notset" data-type="q">
                    <div class="tab" data-value="1">
                        <div class="spot">
                            <span class="txt">1</span>
                        </div>
                    </div>
                    <div class="tab" data-value="2">
                        <div class="spot">
                            <span class="txt">2</span>
                        </div>
                    </div>
                    <div class="tab" data-value="3">
                        <div class="spot">
                            <span class="txt">3</span>
                        </div>
                    </div>
                    <div class="tab" data-value="4">
                        <div class="spot">
                            <span class="txt">4</span>
                        </div>
                    </div>
                    <div class="tab" data-value="5">
                        <div class="spot">
                            <span class="txt">5</span>
                        </div>
                    </div>
                    <div class="tab" data-value="6">
                        <div class="spot">
                            <span class="txt">6</span>
                        </div>
                    </div>
                </div>
                @endif
                @endif
                @if ($user_type == null)
                @if ($practiceQuestion->Respondent == 8)
                <?php $counter++; ?>
                <p style="font-size: 1.4rem;">{{ $counter }}.
                    @if ($practiceQuestion != null)
                    {{ $practiceQuestion->Question != null ? $practiceQuestion->Question : 'No' }}
                    @endif
                </p>
                <div id="{{ $practiceQuestion->id }}" class="rb pquestions" data-QId="{{ $practiceQuestion->id }}"
                    data-answer="notset" data-type="q">
                    <div class="tab" data-value="1">
                        <div class="spot">
                            <span class="txt">1</span>
                        </div>
                    </div>
                    <div class="tab" data-value="2">
                        <div class="spot">
                            <span class="txt">2</span>
                        </div>
                    </div>
                    <div class="tab" data-value="3">
                        <div class="spot">
                            <span class="txt">3</span>
                        </div>
                    </div>
                    <div class="tab" data-value="4">
                        <div class="spot">
                            <span class="txt">4</span>
                        </div>
                    </div>
                    <div class="tab" data-value="5">
                        <div class="spot">
                            <span class="txt">5</span>
                        </div>
                    </div>
                    <div class="tab" data-value="6">
                        <div class="spot">
                            <span class="txt">6</span>
                        </div>
                    </div>
                </div>
                @endif
                @endif
                @endforeach

                @if ($loop->iteration == count($functions))
                @if (!$can_ansewer_to_priorities)
                <div class="button-box">
                    <button class="button trigger">Submit!</button>

                </div>
                @endif
                @endif
            </div>
        </div>
        @endforeach
        @if ($can_ansewer_to_priorities)
        <?php $i = $i + 1; ?>
        <div id="step-{{ $i }}" class="tab-pane" role="tabpanel" aria-labelledby="step-{{ $i }}">
            <div class="Qcontainer">
                <?php $coun = 1; ?>
                <p style="font-size: 2.0rem; letter-spacing: 4px" class="h2 text-warning text-center">1 is Low
                    Priority and 3 is high Priority</p>
                </p>
                <p style="font-size: 0.9rem; letter-spacing: 2px" class="h2 text-info text-center">Please select
                    two high priorities, and three medium priorities, and the remaining
                    priorities are low priorities.
                </p>
                @foreach ($functions as $f)
                <p style="font-size: 1.4rem;">{{ $coun }}.
                    {{ $f->FunctionTitle }}
                </p>

                <div id="{{ $f->id }}" class="rb function" data-QId="{{ $f->id }}" data-answer="notset"
                    data-fanswer="notset" data-type="f">
                    <div class="tab" data-value="1">
                        <div class="spot">
                            <span class="txt">1</span>
                        </div>
                    </div>
                    <div class="tab" data-value="2" id="two{{ $coun }}">
                        <div class="spot">
                            <span class="txt">2</span>
                        </div>
                    </div>
                    <div class="tab" data-value="3" id="three{{ $coun }}">
                        <div class="spot">
                            <span class="txt">3</span>
                        </div>
                    </div>
                </div>
                <?php $coun++; ?>
                @endforeach
                <div class="button-box">
                    <button class="button trigger">Submit!</button>

                </div>
            </div>
        </div>
        @endif
        {{-- <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
            <div class="Qcontainer" id="step-11" style="display: none">
                test2
                <p>1. On a scale of 1 to 5 how cubic are you?</p>
                <div id="s1" class="rb">
                    <div class="tab activeTab" data-value="1">
                        <div class="spot">
                            <span class="txt">1</span>
                        </div>
                    </div>
                    <div class="tab" data-value="2">
                        <div class="spot">
                            <span class="txt">2</span>
                        </div>
                    </div>
                    <div class="tab" data-value="3">
                        <div class="spot">
                            <span class="txt">3</span>
                        </div>
                    </div>
                    <div class="tab" data-value="4">
                        <div class="spot">
                            <span class="txt">4</span>
                        </div>
                    </div>
                    <div class="tab" data-value="5">
                        <div class="spot">
                            <span class="txt">5</span>
                        </div>
                    </div>
                    <div class="tab" data-value="6">
                        <div class="spot">
                            <span class="txt">6</span>
                        </div>
                    </div>
                </div>

                <p>2. On a scale of 1 to 5 how would you rate the universe?</p>
                <div id="s2" class="rb">
                    <div class="tab" data-value="1">
                        <div class="spot">
                            <span class="txt">1</span>
                        </div>
                    </div>
                    <div class="tab activeTab" data-value="2">
                        <div class="spot">
                            <span class="txt">2</span>
                        </div>
                    </div>
                    <div class="tab" data-value="3">
                        <div class="spot">
                            <span class="txt">3</span>
                        </div>
                    </div>
                    <div class="tab" data-value="4">
                        <div class="spot">
                            <span class="txt">4</span>
                        </div>
                    </div>
                    <div class="tab" data-value="5">
                        <div class="spot">
                            <span class="txt">5</span>
                        </div>
                    </div>
                    <div class="tab" data-value="6">
                        <div class="spot">
                            <span class="txt">6</span>
                        </div>
                    </div>
                </div>

                <p>3. On a scale of 1 to 5 how much do you like stalactites?</p>
                <div id="s3" class="rb">
                    <div class="tab" data-value="1">
                        <div class="spot">
                            <span class="txt">1</span>
                        </div>
                    </div>
                    <div class="tab" data-value="2">
                        <div class="spot">
                            <span class="txt">2</span>
                        </div>
                    </div>
                    <div class="tab activeTab" data-value="3">
                        <div class="spot">
                            <span class="txt">3</span>
                        </div>
                    </div>
                    <div class="tab" data-value="4">
                        <div class="spot">
                            <span class="txt">4</span>
                        </div>
                    </div>
                    <div class="tab" data-value="5">
                        <div class="spot">
                            <span class="txt">5</span>
                        </div>
                    </div>
                    <div class="tab" data-value="6">
                        <div class="spot">
                            <span class="txt">6</span>
                        </div>
                    </div>
                </div>

                <p>4. On a scale of 1 to 5 what is your favorite color in the alphabet?</p>
                <div id="s4" class="rb">
                    <div class="tab" data-value="1">
                        <div class="spot">
                            <span class="txt">1</span>
                        </div>
                    </div>
                    <div class="tab" data-value="2">
                        <div class="spot">
                            <span class="txt">2</span>
                        </div>
                    </div>
                    <div class="tab" data-value="3">
                        <div class="spot">
                            <span class="txt">3</span>
                        </div>
                    </div>
                    <div class="tab activeTab" data-value="4">
                        <div class="spot">
                            <span class="txt">4</span>
                        </div>
                    </div>
                    <div class="tab" data-value="5">
                        <div class="spot">
                            <span class="txt">5</span>
                        </div>
                    </div>
                    <div class="tab" data-value="6">
                        <div class="spot">
                            <span class="txt">6</span>
                        </div>
                    </div>
                </div>

                <p>5. On a scale of one to shrimp, how random are you?</p>
                <div id="s5" class="rb">
                    <div class="tab" data-value="1">
                        <div class="spot">
                            <span class="txt">1</span>
                        </div>
                    </div>
                    <div class="tab" data-value="2">
                        <div class="spot">
                            <span class="txt">2</span>
                        </div>
                    </div>
                    <div class="tab" data-value="3">
                        <div class="spot">
                            <span class="txt">3</span>
                        </div>
                    </div>
                    <div class="tab" data-value="4">
                        <div class="spot">
                            <span class="txt">4</span>
                        </div>
                    </div>
                    <div class="tab activeTab" data-value="5">
                        <div class="spot">
                            <span class="txt">5</span>
                        </div>
                    </div>
                    <div class="tab" data-value="6">
                        <div class="spot">
                            <span class="txt">6</span>
                        </div>
                    </div>
                </div>

                <div class="button-box">
                    <button class="button trigger">Submit!</button>
                    <button class="button form-nav-back">back</button>
                </div>

            </div>
        </div>
        <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
            Step content
        </div>
        <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
            Step content
        </div>
        <div id="step-5" class="tab-pane" role="tabpanel" aria-labelledby="step-5">
            Step content
        </div>
        <div id="step-5" class="tab-pane" role="tabpanel" aria-labelledby="step-5">
            Step content
        </div> --}}
    </div>

    <!-- Include optional progressbar HTML -->
    <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0"
            aria-valuemax="100"></div>
    </div>
</div>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
{{-- <script src="function.js"></script> --}}

{{-- end survey --}}
@endsection
@section('scripts')
<!-- CSS -->

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/js/jquery.smartWizard.min.js" type="text/javascript">
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- <script src="{{ asset('assets/js/jquery.smartWizard.js') }}"></script>
<script src="{{ asset('assets/js/fromwizard.js') }}"></script>
<script src="{{ asset('assets/js/jquery.accordion-wizard.min.js') }}"></script>
<script src="{{ asset('assets/js/form-wizard.js') }}"></script> --}}
<script>
    $(function() {
            // SmartWizard initialize
            $('#smartwizard').smartWizard();
        });
        $(".tab").click(function() {

            $(this).parent().attr('data-answer', $(this).attr('data-value'));

            //Spot switcher:
            $(this).parent().find(".tab").removeClass("activeTab");
            $(this).addClass("activeTab");
            if ($(this).parent().attr('data-type') == "f") {
                //data-fanswer
                $(this).parent().attr('data-fanswer', $(this).attr('data-value'));
                $(this).parent().attr('data-answer', $(this).attr('data-value'));
                functions = document.querySelectorAll('[data-type="f"]');
                threeAnswered = document.querySelectorAll('[data-fanswer="3"]');
                twoAnswered = document.querySelectorAll('[data-fanswer="2"]');
                oneAnswered =
                    document.querySelectorAll('[data-fanswer="1"]');
                if (threeAnswered.length == 2) {
                    $.each(functions, function(key, value) {
                        ele = document.getElementById(value.id);
                        if (ele.getAttribute('data-fanswer') == "3") {

                        } else {
                            $(`#three${key+1}`).css("pointer-events", "none");
                        }
                    });

                } else {
                    $.each(functions, function(key, value) {

                        $(`#three${key+1}`).css("pointer-events", "");

                    });
                }
                if (twoAnswered.length >= 3) {
                    $.each(functions, function(key, value) {
                        ele = document.getElementById(value.id);

                        if (ele.getAttribute('data-fanswer') == "2") {

                        } else {
                            $(`#two${key+1}`).css("pointer-events", "none");
                        }
                    });
                } else {
                    $.each(functions, function(key, value) {

                        $(`#two${key+1}`).css("pointer-events", "");

                    });
                }
            }
        });
        $(".trigger").click(function() {
            var cusid_ele = document.getElementsByClassName('pquestions');
            var answers = [];
            var priorities = [];
            var complete = true;

            $.each(cusid_ele, function(key, value) {
                ele = $(`#${value.id}`);
                ele = document.getElementById(value.id);
                if (ele.getAttribute('data-answer') == "notset") {
                    // toastr.error('Please answer all questions');
                    toastr.error('Please answer all questions');
                    Swal.fire(
                        'Did you answer all questions?',
                        'Please answer all questions',
                        'error'
                    );
                    complete = false;
                    return false;
                } else {
                    complete = true;
                }


                    var answer = {
                        "question_id": value.id,
                        "answer": cusid_ele[key].querySelector('.activeTab').getAttribute(
                            'data-value')
                    };
                    answers.push(answer);

            });
            var cusid_ele = document.getElementsByClassName('function');
            console.log(cusid_ele.length);
            if(cusid_ele.length>0)
            {
            $.each(cusid_ele, function(key, value) {
                ele = $(`#${value.id}`);
                ele = document.getElementById(value.id);
                if (ele.getAttribute('data-answer') == "notset") {
                    // toastr.error('Please answer all questions');
                    toastr.error('Please answer all questions');
                    Swal.fire(
                        'Did you answer all questions?',
                        'Please answer all questions',
                        'error'
                    );
                    complete = false;
                    return false;
                } else {
                    complete = true;
                }


                    priority = {
                        "function": value.id,
                        "priority": cusid_ele[key].querySelector('.activeTab').getAttribute(
                            'data-value')
                    };
                    priorities.push(priority)

            });}
            console.log(priorities);
            console.log(answers);
            var reply = [{
                "survey_id": '{{ $SurveyId }}',
                "PlanID": '{{ $plan_id }}',
                "priorities": priorities.length > 0 ? priorities : null,
                "EmailId": '{{ $email_id }}',
                "answers": answers,
            }];

            if (complete)
                $.ajax({
                    type: "POST",
                    url: "{{ route('questionnair.saveAnswer') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "reply": reply
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.msg == "success") {
                            toastr.success('Survey submitted successfully');
                            Swal.fire(
                                'Survey submitted successfully',
                                'Thank you for your time',
                                'success'
                            );
                            if(data.url=='')
                            {
                                setTimeout(function() {
                                window.location.href = "{{ url('/') }}";
                                }, 2000);
                            }
                            else
                            {
                                setTimeout(function() {
                                window.location.href = data.url;
                                }, 2000);
                            }
                        } else {
                            toastr.error('Something went wrong');
                            Swal.fire(
                                'Something went wrong',
                                'Please try again',
                                'error'
                            );
                        }
                    }
                });
            else
               console.error('not complete');

        });
        // $(".form-nav-next").click(function() {
        //     currentfunction = $(this).parent().parent().attr('id');
        //     currentfunctionele = document.getElementById(currentfunction);
        //     allfunctions = document.getElementsByClassName('Qcontainer');
        //     currentIndex = [...allfunctions].indexOf(currentfunctionele);
        //     nextIndex = currentIndex + 1;
        //     if (nextIndex < allfunctions.length) {
        //         currentfunctionele.style.display = "none";
        //         allfunctions[nextIndex].style.display = "block";
        //     }

        // });
        // $(".form-nav-back").click(function() {
        //     currentfunction = $(this).parent().parent().attr('id');
        //     currentfunctionele = document.getElementById(currentfunction);
        //     allfunctions = document.getElementsByClassName('Qcontainer');

        //     currentIndex = [...allfunctions].indexOf(currentfunctionele);
        //     nextIndex = currentIndex - 1;
        //     if (nextIndex >= 0) {
        //         currentfunctionele.style.display = "none";
        //         allfunctions[nextIndex].style.display = "block";
        //     }

        // });
</script>
@endsection
