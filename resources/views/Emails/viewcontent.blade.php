{{-- extends --}}
@extends('layouts.main')

{{-- content --}}
{{-- Emails List --}}
@section('content')
<div class="container pt-5 mt-5">
    <div class="row">
        <div class="col-3">
            <!-- side bar menu -->
            @include('layouts.sidebar')
        </div>
        <div class="col-9">
            {{-- email contents card view --}}
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6 text-start">
                            <h3 class="card-title">Emails Content</h3>
                        </div>
                        <div class="col-6 text-end">
                            <h3 class="">
                                <a href="{{ route('emails.manage') }}" class="btn btn-primary btn-sm"
                                    style="letter-spacing: 1px;">Back</a>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{-- view email content --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                {{ $email->subject }}
                            </div>
                        </div>
                        {{-- subject_ar --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="subject_ar">Subject Arabic</label>
                                {{ $email->subject_ar }}
                            </div>
                        </div>
                        {{-- email body --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="content">Body Header</label>
                                {!! $email->body_header !!}
                            </div>
                        </div>
                        {{-- body_header_ar --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="body_header_ar">Body Header Arabic</label>
                                {!! $email->body_header_ar !!}
                            </div>
                        </div>
                        {{-- body_footer --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="body_footer">Body Footer</label>
                                {!! $email->body_footer !!}
                            </div>
                        </div>
                        {{-- body_footer_ar --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="body_footer_ar">Body Footer Arabic</label>
                                {!! $email->body_footer_ar !!}
                            </div>
                        </div>
                </div>
                <div class="row">
                    <div class="col-12 text-end">
                        <a href="{{ route('emails.SendSurvey', $email->id) }}" class="btn btn-primary btn-sm">Send</a>

                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
