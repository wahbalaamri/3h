{{-- extends --}}
@extends('layouts.main')

{{-- content --}}
{{-- surveys List --}}
@section('content')
    <div class="container pt-5 mt-5">
        <div class="row">
            <div class="col-3">
                <!-- side bar menu -->
                @include('layouts.sidebar')
            </div>
            <div class="col-9">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="card-title">{{ __('Surveys') }}</h3>
                            </div>
                            {{-- add new survey button --}}
                            <div class="col-6 text-end">
                                <a href="{{ route('surveys.create') }}" class="btn btn-primary">{{ __('Add New Survey') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>{{ __('Surveys List') }}</p>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Survey Name') }}</th>
                                    <th scope="col">{{ __('Plan') }}</th>
                                    <th scope="col">{{ __('Client Name') }}</th>
                                    <th scope="col">{{ __('Survey Type') }}</th>
                                    <th scope="col">{{ __('Survey Status') }}</th>
                                    <th scope="col">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($surveys as $survey)

                                    <tr>
                                        <td>{{ $survey->SurveyTitle }}</td>
                                        <td>{{ $survey->plan->PlanTitle }}</td>
                                        <td>
                                            {{ $survey->clients->ClientName }}
                                        </td>
                                        <td>{{ $survey->SurveyDes }}</td>
                                        <td>{{ $survey->SurveyStat }}</td>
                                        <td>
                                            <a href="{{ route('surveys.show', $survey->id) }}"
                                                class="btn btn-primary">{{ __('View') }}</a>
                                            <a href="{{ route('surveys.edit', $survey->id) }}"
                                                class="btn btn-primary">{{ __('Edit') }}</a>
                                            <form action="{{ route('surveys.destroy', $survey->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                            </form>
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
@endsection
