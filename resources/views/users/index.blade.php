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
            {{-- card to display all users --}}
            <div class="card pb-5 mb-5">
                <div class="card-header">
                    <h3 class="card-title float-start">Users</h3>
                    <a href="{{ route('users.create') }}" class="btn btn-primary float-end">Add User</a>
                </div>
                <div class="card-body">
                    @if (count($users)>0)
                    <div class="responsive-table">
                        <table class="table table-hover">
                            <thead>
                                <th>#</th>
                                <th>User Type</th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->user_type }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>

                                        <a href="{{ route('users.edit', $user->id) }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        {{-- delete user --}}
                                        {{-- <a href="#" data-toggle="modal" data-target="#deleteUser{{ $user->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteUser{{ $user->id }}" tabindex="-1"
                                            aria-labelledby --}} </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p>No users found</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- footer --}}
