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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Practice Question</h3>
                </div>
                <div class="card-body">
                    {{-- lis all errors --}}
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{ route('practice-questions.update', $practiceQuestion->id) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="">
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                {{-- select practice --}}
                                <div class="form-group">
                                    <label for="PracticeId">Practice</label>
                                    <select name="PracticeId" id="PracticeId" class="form-control" disabled>
                                        <option value="">Select Practice</option>
                                        @foreach ($practices as $practice)
                                        <option value="{{ $practice->id }}" {{ $practiceQuestion->PracticeId ==
                                            $practice->id ? 'selected' : '' }}>{{ $practice->PracticeTitle }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                {{-- question --}}
                                <div class="form-group">
                                    <label for="Question">Question</label>
                                    <textarea name="Question" id="Question" cols="30" rows="5"
                                        class="form-control">{{ $practiceQuestion->Question }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                {{-- question arabic --}}
                                <div class="form-group">
                                    <label for="QuestionAr">Question Arabic</label>
                                    <textarea name="QuestionAr" id="QuestionAr" cols="30" rows="5"
                                        class="form-control">{{ $practiceQuestion->QuestionAr }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                {{-- select respondent --}}
                                <div class="form-group">
                                    <label for="Respondent">Respondent</label>
                                    <select name="Respondent" id="Respondent" class="form-control">
                                        <option value="">Select Respondent</option>
                                        <option value="1" @if($practiceQuestion->Respondent==1)selected @endif> Only HR Employees</option>
                                        <option value="2" @if($practiceQuestion->Respondent==2)selected @endif> Only Employees</option>
                                        <option value="3" @if($practiceQuestion->Respondent==3)selected @endif> Only Managers</option>
                                        <option value="4" @if($practiceQuestion->Respondent==4)selected @endif> Only HR Employees & Employees</option>
                                        <option value="5" @if($practiceQuestion->Respondent==5)selected @endif> Only Managers & Employees</option>
                                        <option value="6" @if($practiceQuestion->Respondent==6)selected @endif> Only Managers & HR Employees</option>
                                        <option value="7" @if($practiceQuestion->Respondent==7)selected @endif> All Employees</option>
                                        <option value="8" @if($practiceQuestion->Respondent==8)selected @endif> Public</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    {{-- status using switch--}}
                                    <div class="form-group">
                                        <label for="Status">{{ $practiceQuestion->Status==1?"Active":"In-Active"
                                            }}</label>
                                        <input type="checkbox" name="Status" id="Status" {{ $practiceQuestion->Status ==
                                        1 ?
                                        'checked' : '' }} data-bootstrap-switch data-off-color="danger"
                                        data-on-color="success">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 text-end">
                                    {{-- submit button --}}
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $("#Status").change(function(){
        if($(this).is(":checked")){
            $("label[for='Status']").html('Active')
        }else{
            $("label[for='Status']").html('In-Active')
        }

    })
    $('form').submit(function(){
        //remove disabled attribute from practiceid
        $('#PracticeId').removeAttr('disabled')
    });

</script>
@endsection
