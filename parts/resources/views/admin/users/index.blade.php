@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Users Index</h1>
@stop

@section('content')

        <div class="container-fluid">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </div>
            @endif
            @if (session('info'))
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-exclamation-triangle"></i> {{ session('info') }}!</h5>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-12 my-3">
                    <div class="card mb-4 shadow-sm card-outline card-primary">
                        <div class="card-header ">
                            <h3 class="card-title mt-1">
                                Users Listing
                            </h3>
                            <div class="card-tools">

                                {{--                        @can('create',$users->first())--}}

                                <a class="btn btn-primary" href="{{ route('users.create') }}">
                                    <i class="fa fa-plus"></i> Create User
                                </a>
                                {{--                        @endcan--}}
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table table-striped table-hover table-bordered" id="usersTable">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->role}}</td>
                                        <td>{{$user->created_at}}</td>
                                        <td>
                                            <a href="{{ route('users.show',$user) }}" class="btn btn-sm btn-default"
                                               target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            {{--                                    @can('update', $user)--}}
                                            <a href="{{ route('users.edit',$user) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
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

    @section('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    @stop

    @section('js')
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
        <script>
            let $usersTable;
            $(document).ready( function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $usersTable = $('#usersTable').DataTable();
            });
        </script>
    @stop


