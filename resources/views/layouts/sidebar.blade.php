{{-- create sidebar menu --}}
@php
    $menu = [
        'Plans' => [
            'icon' => 'fa fa-list',
            'url' => route('partner-ship-plans.index'),
            'active' => 'partner-ship-plans',
        ],
        'Service Requests' => [
            'icon' => 'fa fa-list',
            'url' => route('service-request.index'),
            'active' => 'service-request.index',
        ],
        // 'Functions' => [
        //     'icon' => 'fa fa-cogs',
        //     'url' => route('functions.index'),
        //     'active' => ['functions','functions/create','functions/FunctionsWithPlan/'],
        // ],
        // 'Function Practice' => [
        //     'icon' => 'fa fa-user',
        //     'url' => route('function-practice.index'),
        //     'active' => 'function-practice',
        // ],
        // 'Questions' => [
        //     'icon' => 'fa fa-users',
        //     'url' => route('practice-questions.index'),
        //     'active' => 'practice-questions',
        // ],
        'Clients' => [
            'icon' => 'fa fa-file-users',
            'url' => route('clients.index'),
            'active' => ['clients','clients.index'],
        ],
        'Users' => [
            'icon' => 'fa fa-file-users',
            'url' => route('users.index'),
            'active' => ['users','users.index'],
        ],
        // 'Surveys' => [
        //     'icon' => 'fa fa-list',
        //     'url' => route('surveys.index'),
        //     'active' => ['surveys','surveys.index'],
        // ],
        // 'Surveys Result' => [
        //     'icon' => 'fa fa-bar-chart',
        //     'url' => route('survey-answers.index'),
        //     'active' => 'survey-answers.index',
        // ],
        // 'Respondents Email' => [
        //     'icon' => 'fa fa-email',
        //     'url' => route('emails.index'),
        //     'active' => 'emails.index',
        // ],
        // 'Manage Emails' => [
        //     'icon' => 'fa fa-list',
        //     'url' => route('emails.manage'),
        //     'active' => 'emails.manage',
        // ],

        // 'Settings' => [
        //     'icon' => 'fa fa-cogs',
        //     'url' => route('dashboard'),
        //     'active' => 'settings.index',
        // ],
    ];
@endphp

    {{-- create sidebar menu --}}
    <ul class="list-group" data-widget="tree" style="margin-top: 0.5% ; margin-bottom: 0.2%;
    position: fixed;
    z-index: 0;">
        <li class="header list-group-item text-center">MAIN NAVIGATION</li>
        @foreach ($menu as $key => $value)
            <li class="list-group-item text-start {{ Request::is($value['active']) ? 'active btn btn-primary text-white' : 'btn btn-secondary' }}">
                <a href="{{ $value['url'] }}" class="btn stretched-link">
                    <i class="{{ $value['icon'] }}"></i> <span class="m-3">{{ $key }}</span>
                </a>
            </li>
        @endforeach
    </ul>
