@extends('adminlte::page')
@section('title', 'SKUS Creation')

@section('content_header')
    <h2>SKUS Creation</h2>
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
            <div class="col-md-8">
                <div class="card shadow-sm card-outline card-primary">
                    <div class="card-header ">
                        <h3 class="card-title mt-1">
                            {{ __('Step1')}}
                        </h3>
                        <div class="card-tools">
                            <b>Press [F12] to SAVE</b>
                        </div>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('steps.store') }}" enctype="multipart/form-data" id="myForm">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="brand" class="col-form-label text-md-end">{{ __('Brand') }}</label>

                                    <input id="brand" type="text"
                                           class="form-control @error('brand') is-invalid @enderror" name="brand"
                                           value="{{ old('brand',$brand) }}"  autocomplete="off" autofocus>

                                    @error('brand')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="model" class="col-form-label text-md-end">{{ __('Model') }}</label>

                                    <input id="model" type="text"
                                           class="form-control @error('model') is-invalid @enderror" name="model"
                                           value="{{ old('model',$model) }}"  autocomplete="off" autofocus >

                                    @error('model')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="country"
                                           class="col-form-label text-md-end">{{ __('Country Origin') }}</label>

                                    <select name="country" aria-label="select country" id="country"
                                            class="form-control @error('country') is-invalid @enderror" >
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->CountryName }}"
                                                {{ old('country')==$country->CountryName ? 'selected':''}}>
                                                {{ $country->CountryName}}</option>
                                        @endforeach
                                    </select>

                                    @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="productVersion"
                                           class="col-form-label text-md-end">{{ __('Product Version Number') }}</label>

                                    <input id="productVersion" type="text"
                                           class="form-control @error('productVersion') is-invalid @enderror"
                                           name="productVersion" value="{{ old('productVersion') }}"
                                           autocomplete="off" autofocus>

                                    @error('productVersion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">

                                <div class="col-md-6">
                                    <label for="chasis" class="col-form-label text-md-end">{{ __('Chasis') }}</label>

                                    <input id="chasis" type="text"
                                           class="form-control @error('chasis') is-invalid @enderror" name="chasis"
                                           value="{{ old('chasis') }}"  autocomplete="off" autofocus>

                                    @error('chasis')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <button type="submit" class="btn btn-block btn-primary">
                                    {{ __('Create [F12]') }}
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <a href="" id="msearch"></a>
    </div>

@endsection


@section('css')
    <style>
        .modal-body{
            height: 500px;
            width: 100%;
            overflow-y: auto;
        }
    </style>


@stop

@section('js')

    <script>
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let headers = {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": token
        }


        document.querySelector('input[name="brand"]').addEventListener("keyup", (e) => {
            if (e.key === "Enter") {
                document.getElementById("Model").focus();
            }
        });

        document.querySelector('input[name="model"]').addEventListener("keyup", (e) => {
            if (e.key === "Enter") {
                document.getElementById("ProductSerialNumber").focus();
            }
        });


        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });


        window.onhelp = function() {
            return false;
        };

        window.onkeydown = evt => {
            switch (evt.keyCode) {
                //F12
                case 123:

                    document.getElementById("myForm").submit();
                    break;
                default:
                    return true;
            }
            //Returning false overrides default browser event
            return false;
        };

    </script>
@stop
