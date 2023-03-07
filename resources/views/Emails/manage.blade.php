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
                                <a href="{{ route('emails.CreateContent') }}" class="btn btn-primary btn-sm"
                                    style="letter-spacing: 1px;">New Email Content</a>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    {{-- # --}}
                                    <th>#</th>
                                    <th>Client</th>
                                    <th>Survey</th>
                                    <th>Subject</th>
                                    <th>Content</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($emails as $email)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $email->clients->ClientName }}</td>
                                    <td>{{ $email->surveys->SurveyTitle }}</td>
                                    <td>{{ $email->subject }}</td>
                                    <td>{{ $email->content }}</td>
                                    <td>
                                        {{-- view --}}
                                        <a href="{{ route('emails.ViewContent', $email->id) }}"
                                            class="btn btn-primary btn-sm">View</a>
                                        <a href="{{ route('emails.EditContent', $email->id) }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                        <a href="#{{-- {{ route('emails.DeleteContent', $email->id) }} --}}"
                                            class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
