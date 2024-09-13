@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Users Update </h1>
@stop

@section('content')

    <div class="container">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">{{ __('Update User') }}</div>

                    <div class="card-body">


                        <form method="POST" action="{{ route('users.update',$user) }}" >
                            @method('PATCH')
                            @csrf

                            <div class="row mb-3">
                                <label for="name"
                                       class="col-form-label text-md-end">{{ __('User Name') }}</label>

                                <input id="name" type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       name="name" value="{{ old('name',$user->name) }}"
                                       autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <label for="email"
                                       class="col-form-label text-md-end">{{ __('User Email') }}</label>

                                <input id="email" type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email',$user->email) }}"
                                       autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <label for="role"
                                       class="col-form-label text-md-end">{{ __('Role') }}</label>
                                <select name="role" aria-label="select role" id="role"
                                        class="form-control @error('role') is-invalid @enderror">
                                    <option value="">-- Role --</option>
                                    <option value="admin" {{$user->role=='admin'?'selected':''}}>MI Admin</option>
                                    <option value="employee" {{$user->role=='employee'?'selected':''}}>MI Employee</option>
                                </select>

                                @error('role')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>

                            <div class="row mb-4">
                                <label for="password"
                                       class="col-form-label text-md-end">{{ __('User Password') }}</label>

                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password" value="{{ old('password') }}"
                                       autocomplete="password" autofocus>

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row mb-4">
                                <label for="password_confirmation"
                                       class="col-form-label text-md-end">{{ __('Password Confirmation') }}</label>

                                <input id="password_confirmation" type="password"
                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                       name="password_confirmation" value="{{ old('password_confirmation') }}"
                                       autocomplete="password_confirmation" autofocus>

                                {{--                                @error('password_confirmation')--}}
                                {{--                                <span class="invalid-feedback" role="alert">--}}
                                {{--                                        <strong>{{ $message }}</strong>--}}
                                {{--                                    </span>--}}
                                {{--                                @enderror--}}
                            </div>


                            <div class="row">
                                <button type="submit" class="btn btn-block btn-primary">
                                    {{ __('Update User') }}
                                </button>
                            </div>

                        </form>
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

@stop



