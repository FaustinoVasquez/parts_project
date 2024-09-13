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
            <div class="col-md-12">
                <div class="card shadow-sm card-outline card-primary">
                    <div class="card-header ">
                        <h3 class="card-title mt-1">
                            {{ __('Step2')}}
                        </h3>
                        <div class="card-tools">
                            <b>SKU: {{$sku->ref_sku}}</b>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('steps.update', $sku) }}" enctype="multipart/form-data" id="myForm">
                            @csrf
                            @method('PATCH')
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="brand" class="col-form-label text-md-end">{{ __('Brand') }}</label>

                                    <input id="brand" type="text"
                                           class="form-control @error('brand') is-invalid @enderror" name="brand"
                                           value="{{ old('brand',$sku->brand) }}"  autocomplete="off" autofocus>

                                    @error('brand')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="model" class="col-form-label text-md-end">{{ __('Model') }}</label>

                                    <input id="model" type="text"
                                           class="form-control @error('model') is-invalid @enderror" name="model"
                                           value="{{ old('model',$sku->model) }}"  autocomplete="off" autofocus >

                                    @error('model')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <input id="part1Name" type="text"
                                           class="form-control @error('part1Name') is-invalid @enderror" name="part1Name"
                                           value="Open Cell"  autocomplete="off" autofocus readonly>
                                </div>


                                <div class="col-md-2">

                                    <input id="part1Ref1" type="text"
                                           class="form-control @error('part1Ref1') is-invalid @enderror" name="part1Ref1"
                                           value="{{ old('part1Ref1') }}"  autocomplete="off" autofocus placeholder="Ref 1">

                                    @error('part1Ref1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-2">

                                    <input id="part1Ref2" type="text"
                                           class="form-control @error('part1Ref2') is-invalid @enderror" name="part1Ref2"
                                           value="{{ old('part1Ref2') }}"  autocomplete="off" autofocus placeholder="Ref 2" >

                                    @error('part1Ref2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-2">

                                    <input id="part1Ref3" type="text"
                                           class="form-control @error('part1Ref3') is-invalid @enderror" name="part1Ref3"
                                           value="{{ old('part1Ref3') }}"  autocomplete="off" autofocus placeholder="Ref 3">

                                    @error('part1Ref3')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-2">

                                    <input id="part1Ref4" type="text"
                                           class="form-control @error('part1Ref4') is-invalid @enderror" name="part1Ref4"
                                           value="{{ old('part1Ref4') }}"  autocomplete="off" autofocus placeholder="Ref 4" >

                                    @error('part1Ref4')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-2">

                                    <input id="part1Ref5" type="text"
                                           class="form-control @error('part1Ref5') is-invalid @enderror" name="part1Ref5"
                                           value="{{ old('part1Ref5') }}"  autocomplete="off" autofocus placeholder="Ref 5" >

                                    @error('part1Ref5')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-2">

                                    <input id="part2Name" type="text"
                                           class="form-control @error('part2Name') is-invalid @enderror" name="part2Name"
                                           value="Main Board"  autocomplete="off" autofocus readonly>
                                </div>


                                <div class="col-md-2">

                                    <input id="part2Ref1" type="text"
                                           class="form-control @error('part2Ref1') is-invalid @enderror" name="part2Ref1"
                                           value="{{ old('part2Ref1') }}"  autocomplete="off" autofocus placeholder="Ref 1">

                                    @error('part2Ref1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-2">

                                    <input id="part2Ref2" type="text"
                                           class="form-control @error('part2Ref2') is-invalid @enderror" name="part2Ref2"
                                           value="{{ old('part2Ref2') }}"  autocomplete="off" autofocus placeholder="Ref 2">

                                    @error('part2Ref2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-2">

                                    <input id="part2Ref3" type="text"
                                           class="form-control @error('part2Ref3') is-invalid @enderror" name="part2Ref3"
                                           value="{{ old('part2Ref3') }}"  autocomplete="off" autofocus placeholder="Ref 3">

                                    @error('part2Ref3')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-2">

                                    <input id="part2Ref4" type="text"
                                           class="form-control @error('part2Ref4') is-invalid @enderror" name="part2Ref4"
                                           value="{{ old('part2Ref4') }}"  autocomplete="off" autofocus placeholder="Ref 4">

                                    @error('part2Ref4')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-2">

                                    <input id="part2Ref5" type="text"
                                           class="form-control @error('part2Ref5') is-invalid @enderror" name="part2Ref5"
                                           value="{{ old('part2Ref5') }}"  autocomplete="off" autofocus placeholder="Ref 5">

                                    @error('part2Ref5')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-2">

                                    <input id="part3Name" type="text"
                                           class="form-control @error('part3Name') is-invalid @enderror" name="part3Name"
                                           value="T-Con Board"  autocomplete="off" autofocus readonly>
                                </div>


                                <div class="col-md-2">

                                    <input id="part3Ref1" type="text"
                                           class="form-control @error('part3Ref1') is-invalid @enderror" name="part3Ref1"
                                           value="{{ old('part3Ref1') }}"  autocomplete="off" autofocus placeholder="Ref 1">

                                    @error('part3Ref1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-2">

                                    <input id="part3Ref2" type="text"
                                           class="form-control @error('part3Ref2') is-invalid @enderror" name="part3Ref2"
                                           value="{{ old('part3Ref2') }}"  autocomplete="off" autofocus placeholder="Ref 2">

                                    @error('part3Ref2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-2">

                                    <input id="part3Ref3" type="text"
                                           class="form-control @error('part3Ref3') is-invalid @enderror" name="part3Ref3"
                                           value="{{ old('part3Ref3') }}"  autocomplete="off" autofocus placeholder="Ref 3">

                                    @error('part3Ref3')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-2">

                                    <input id="part3Ref4" type="text"
                                           class="form-control @error('part3Ref4') is-invalid @enderror" name="part3Ref4"
                                           value="{{ old('part3Ref4') }}"  autocomplete="off" autofocus placeholder="Ref 4">

                                    @error('part3Ref4')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-2">

                                    <input id="part3Ref5" type="text"
                                           class="form-control @error('part3Ref5') is-invalid @enderror" name="part3Ref5"
                                           value="{{ old('part3Ref5') }}"  autocomplete="off" autofocus placeholder="Ref 5">

                                    @error('part3Ref5')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-2">

                                    <input id="part4Name" type="text"
                                           class="form-control @error('part4Name') is-invalid @enderror" name="part4Name"
                                           value="Power Supply"  autocomplete="off" autofocus readonly>
                                </div>


                                <div class="col-md-2">

                                    <input id="part4Ref1" type="text"
                                           class="form-control @error('part4Ref1') is-invalid @enderror" name="part4Ref1"
                                           value="{{ old('part4Ref1') }}"  autocomplete="off" autofocus placeholder="Ref 1">

                                    @error('part4Ref1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-2">

                                    <input id="part4Ref2" type="text"
                                           class="form-control @error('part4Ref2') is-invalid @enderror" name="part4Ref2"
                                           value="{{ old('part4Ref2') }}"  autocomplete="off" autofocus placeholder="Ref 2">

                                    @error('part4Ref2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-2">

                                    <input id="part4Ref3" type="text"
                                           class="form-control @error('part4Ref3') is-invalid @enderror" name="part4Ref3"
                                           value="{{ old('part4Ref3') }}"  autocomplete="off" autofocus placeholder="Ref 3">

                                    @error('part4Ref3')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-2">

                                    <input id="part4Ref4" type="text"
                                           class="form-control @error('part4Ref4') is-invalid @enderror" name="part4Ref4"
                                           value="{{ old('part4Ref4') }}"  autocomplete="off" autofocus placeholder="Ref 4">

                                    @error('part4Ref4')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-2">

                                    <input id="part4Ref5" type="text"
                                           class="form-control @error('part4Ref5') is-invalid @enderror" name="part4Ref5"
                                           value="{{ old('part4Ref5') }}"  autocomplete="off" autofocus placeholder="Ref 5">

                                    @error('part4Ref5')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-2">

                                    <input id="part5Name" type="text"
                                           class="form-control @error('part5Name') is-invalid @enderror" name="part5Name"
                                           value="WiFi Module"  autocomplete="off" autofocus readonly>
                                </div>


                                <div class="col-md-2">

                                    <input id="part5Ref1" type="text"
                                           class="form-control @error('part5Ref1') is-invalid @enderror" name="part5Ref1"
                                           value="{{ old('part5Ref1') }}"  autocomplete="off" autofocus placeholder="Ref 1">

                                    @error('part5Ref1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-2">

                                    <input id="part5Ref2" type="text"
                                           class="form-control @error('part5Ref2') is-invalid @enderror" name="part5Ref2"
                                           value="{{ old('part5Ref2') }}"  autocomplete="off" autofocus  placeholder="Ref 2">

                                    @error('part5Ref2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-2">

                                    <input id="part5Ref3" type="text"
                                           class="form-control @error('part5Ref3') is-invalid @enderror" name="part5Ref3"
                                           value="{{ old('part5Ref3') }}"  autocomplete="off" autofocus placeholder="Ref 3">

                                    @error('part5Ref3')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-2">

                                    <input id="part5Ref4" type="text"
                                           class="form-control @error('part5Ref4') is-invalid @enderror" name="part5Ref4"
                                           value="{{ old('part5Ref4') }}"  autocomplete="off" autofocus  placeholder="Ref 4">

                                    @error('part5Ref4')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-2">

                                    <input id="part5Ref5" type="text"
                                           class="form-control @error('part5Ref5') is-invalid @enderror" name="part5Ref5"
                                           value="{{ old('part5Ref5') }}"  autocomplete="off" autofocus  placeholder="Ref 5">

                                    @error('part5Ref5')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-2">

                                    <input id="part6Name" type="text"
                                           class="form-control @error('part6Name') is-invalid @enderror" name="part6Name"
                                           value="IR Sensor"  autocomplete="off" autofocus readonly>
                                </div>


                                <div class="col-md-2">

                                    <input id="part6Ref1" type="text"
                                           class="form-control @error('part6Ref1') is-invalid @enderror" name="part6Ref1"
                                           value="{{ old('part6Ref1') }}"  autocomplete="off" autofocus placeholder="Ref 1">

                                    @error('part6Ref1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-2">

                                    <input id="part6Ref2" type="text"
                                           class="form-control @error('part6Ref2') is-invalid @enderror" name="part6Ref2"
                                           value="{{ old('part6Ref2') }}"  autocomplete="off" autofocus placeholder="Ref 2">

                                    @error('part6Ref2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-2">

                                    <input id="part6Ref3" type="text"
                                           class="form-control @error('part6Ref3') is-invalid @enderror" name="part6Ref3"
                                           value="{{ old('part6Ref3') }}"  autocomplete="off" autofocus placeholder="Ref 3">

                                    @error('part6Ref3')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-2">

                                    <input id="part6Ref4" type="text"
                                           class="form-control @error('part6Ref4') is-invalid @enderror" name="part6Ref4"
                                           value="{{ old('part6Ref4') }}"  autocomplete="off" autofocus placeholder="Ref 4">

                                    @error('part6Ref4')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-2">

                                    <input id="part6Ref5" type="text"
                                           class="form-control @error('part6Ref5') is-invalid @enderror" name="part6Ref5"
                                           value="{{ old('part6Ref5') }}"  autocomplete="off" autofocus placeholder="Ref 5">

                                    @error('part6Ref5')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-2">

                                    <input id="part7Name" type="text"
                                           class="form-control @error('part7Name') is-invalid @enderror" name="part7Name"
                                           value="Button Set"  autocomplete="off" autofocus readonly>
                                </div>


                                <div class="col-md-2">

                                    <input id="part7Ref1" type="text"
                                           class="form-control @error('part7Ref1') is-invalid @enderror" name="part7Ref1"
                                           value="{{ old('part7Ref1') }}"  autocomplete="off" autofocus placeholder="Ref 1">

                                    @error('part7Ref1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-2">

                                    <input id="part7Ref2" type="text"
                                           class="form-control @error('part7Ref2') is-invalid @enderror" name="part7Ref2"
                                           value="{{ old('part7Ref2') }}"  autocomplete="off" autofocus placeholder="Ref 2">

                                    @error('part7Ref2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-2">

                                    <input id="part7Ref3" type="text"
                                           class="form-control @error('part7Ref3') is-invalid @enderror" name="part7Ref3"
                                           value="{{ old('part7Ref3') }}"  autocomplete="off" autofocus placeholder="Ref 3">

                                    @error('part7Ref3')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-2">

                                    <input id="part7Ref4" type="text"
                                           class="form-control @error('part7Ref4') is-invalid @enderror" name="part7Ref4"
                                           value="{{ old('part7Ref4') }}"  autocomplete="off" autofocus placeholder="Ref 4">

                                    @error('part7Ref4')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-2">

                                    <input id="part7Ref5" type="text"
                                           class="form-control @error('part7Ref5') is-invalid @enderror" name="part7Ref5"
                                           value="{{ old('part7Ref5') }}"  autocomplete="off" autofocus placeholder="Ref 5">

                                    @error('part7Ref5')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-2">

                                    <input id="part8Name" type="text"
                                           class="form-control @error('part8Name') is-invalid @enderror" name="part8Name"
                                           value="Bluetooth Module"  autocomplete="off" autofocus readonly>
                                </div>


                                <div class="col-md-2">

                                    <input id="part8Ref1" type="text"
                                           class="form-control @error('part8Ref1') is-invalid @enderror" name="part8Ref1"
                                           value="{{ old('part8Ref1') }}"  autocomplete="off" autofocus placeholder="Ref 1">

                                    @error('part8Ref1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-2">

                                    <input id="part8Ref2" type="text"
                                           class="form-control @error('part8Ref2') is-invalid @enderror" name="part8Ref2"
                                           value="{{ old('part8Ref2') }}"  autocomplete="off" autofocus placeholder="Ref 2">

                                    @error('part8Ref2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-2">

                                    <input id="part8Ref3" type="text"
                                           class="form-control @error('part8Ref3') is-invalid @enderror" name="part8Ref3"
                                           value="{{ old('part8Ref3') }}"  autocomplete="off" autofocus placeholder="Ref 3">

                                    @error('part8Ref3')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-2">

                                    <input id="part8Ref4" type="text"
                                           class="form-control @error('part8Ref4') is-invalid @enderror" name="part8Ref4"
                                           value="{{ old('part8Ref4') }}"  autocomplete="off" autofocus placeholder="Ref 4">

                                    @error('part8Ref4')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-2">

                                    <input id="part8Ref5" type="text"
                                           class="form-control @error('part8Ref5') is-invalid @enderror" name="part8Ref5"
                                           value="{{ old('part8Ref5') }}"  autocomplete="off" autofocus placeholder="Ref 5">

                                    @error('part8Ref5')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-block btn-primary">
                                        {{ __('Create [F12]') }}
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-block btn-danger" id="btn-remove-sku">
                                        {{ __('Cancel & remove SKU:').$sku->ref_sku }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <a href="" id="msearch"></a>
    </div>

    <div class="row">
        <div class="col-lg-12 ">
            <div class="card mb-4 shadow-sm card-outline card-primary">
                <div class="card-header ">
                    <h3 class="card-title mt-1">
                        Skus Listing
                    </h3>
                    <div class="card-tools">

                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped table-hover table-bordered nowrap" id="skusTable">
                        <thead>
                        <tr>
                            <th>Ref_Sku</th>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Version</th>
                            <th>Country Manufactured</th>
                            <th>Open Cell</th>
                            <th>Main Board</th>
                            <th>T-Con Board</th>
                            <th>Power Supply</th>
                            <th>WiFi Module</th>
                            <th>IR Sensor</th>
                            <th>Button Set</th>
                            <th>Blutooth Module</th>
                            <th>Chasis</th>
                            <th>Product Version Number</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 ">
            <div class="card mb-4 shadow-sm card-outline card-success">
                <div class="card-header ">
                    <h3 class="card-title mt-1">
                        Kits Listing
                    </h3>
                    <div class="card-tools">
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped table-hover table-bordered nowrap" id="kitsTable">
                        <thead>
                        <tr>
                            <th>Actions</th>
                            <th>KitID</th>
                            <th>brand</th>
                            <th>model</th>
                            <th>Open Cell</th>
                            <th>Main Board</th>
                            <th>T-Con Board</th>
                            <th>Power Supply</th>
                            <th>WiFi Module</th>
                            <th>IR Sensor</th>
                            <th>Button Set</th>
                            <th>Blutooth Module</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap4.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let $kitsTable
        let $skusTable;
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const headers = {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": token
        }

        $(document).ready( function () {
            $.ajaxSetup({
                headers:headers
            });

            $skusTable = $('#skusTable').DataTable({
                order: [[0, 'desc']],
                pageLength: 50,
                lengthMenu: [
                    [50,100, -1],
                    [50,100,'All']
                ],
                processing: true,
                serverSide: true,
                scrollY: "35vh",
                scrollX: true,
                scrollCollapse: true,
                stateSave: true,
                dom: '"<\'row\'<\'col-md-6\'B><\'col-md-6\'f>>" +\n' +
                    '"<\'row\'<\'col-sm-12\'tr>>" +\n' +
                    '"<\'row\'<\'col-sm-12 col-md-5\'i ><\'col-sm-12 col-md-7\'p>>"',
                buttons: {
                    dom: {
                        container: {
                            tag: 'div',
                            className: 'flexcontent'
                        },
                        buttonLiner: {
                            tag: null
                        }
                    },
                    buttons: [
                        {
                            extend: 'pageLength',
                            titleAttr: 'Show Records',
                            className: 'btn btn-secondary buttons-collection dropdown-toggle buttons-colvis',
                        }
                    ],
                },

                ajax: {
                    url:'/sku/getSkus',
                    data: function (d) {
                        d.brand = $('input[name=brand]').val();
                        d.model = $('input[name=model]').val();
                    }
                },
                columns: [
                    {data: 'ref_sku',name:'ref_sku'},
                    {data: 'brand',name:'brand'},
                    {data: 'model',name:'model'},
                    {data: 'version',name:'version'},
                    {data: 'country_manufactured',name:'country_manufactured'},
                    {data: 'Open Cell',name:'Open Cell'},
                    {data: 'Main Board',name:'Main Board'},
                    {data: 'T-Con Board',name:'T-Con Board'},
                    {data: 'Power Supply',name:'Power Supply'},
                    {data: 'WiFi Module',name:'WiFi Module'},
                    {data: 'IR Sensor',name:'IR Sensor'},
                    {data: 'Button Set',name:'Button Set'},
                    {data: 'Blutooth Module',name:'Blutooth Module'},
                    {data: 'chasis',name:'chasis'},
                    {data: 'product_version_number',name:'product_version_number'},
                ],
                columnDefs: [
                    {
                        targets: [0],
                        searchable: true,
                    }
                ],
            });



            $kitsTable = $('#kitsTable').DataTable({
                order: [[0, 'desc']],
                pageLength: 100,
                lengthMenu: [
                    [50,100, -1],
                    [50,100,'All']
                ],
                processing: true,
                serverSide: true,
                scrollY: "35vh",
                scrollX: true,
                scrollCollapse: true,
                stateSave: true,
                dom: '"<\'row\'<\'col-md-6\'B><\'col-md-6\'f>>" +\n' +
                    '"<\'row\'<\'col-sm-12\'tr>>" +\n' +
                    '"<\'row\'<\'col-sm-12 col-md-5\'i ><\'col-sm-12 col-md-7\'p>>"',
                buttons: {
                    dom: {
                        container: {
                            tag: 'div',
                            className: 'flexcontent'
                        },
                        buttonLiner: {
                            tag: null
                        }
                    },
                    buttons: [
                        {
                            extend: 'pageLength',
                            titleAttr: 'Show Records',
                            className: 'btn btn-secondary buttons-collection dropdown-toggle buttons-colvis',
                        }
                    ],
                },

                ajax: {
                    url:'/sku/getKits',
                    data: function (d) {
                        d.brand = $('input[name=brand]').val();
                        d.model = $('input[name=model]').val();
                    }
                },
                columns: [
                    {data: 'actions', name: 'actions'},
                    {data: 'KitID', name: 'KitID'},
                    {data: 'brand', name: 'brand'},
                    {data: 'model', name: 'model'},
                    {data: 'Open Cell', name: 'Open Cell'},
                    {data: 'Main Board', name: 'Main Board'},
                    {data: 'T-Con Board', name: 'T-Con Board'},
                    {data: 'Power Supply', name: 'Power Supply'},
                    {data: 'WiFi Module', name: 'WiFi Module'},
                    {data: 'IR Sensor', name: 'IR Sensor'},
                    {data: 'Button Set', name: 'Button Set'},
                    {data: 'Blutooth Module', name: 'Blutooth Module'},
                ],
                columnDefs: [
                    {
                        targets: [0],
                        searchable: true,
                    },
                ]
            });
        });

        $(document).on('click', '.add-btn', function (e) {
            e.stopPropagation();
            let tr = $(this).closest('tr');
            let rowId = tr.attr('id');
            let row = $kitsTable.row(tr).data();
            let headers =['Open Cell',
                'Main Board',
                'T-Con Board',
                'Power Supply',
                'WiFi Module',
                'IR Sensor',
                'Button Set',
                'Blutooth Module'
            ];

            headers.forEach(function (e,i){
                i+=1
                if(row[e]) {
                    let refs = row[e].split(',')
                    refs.forEach(function(r, j){
                        j+=1
                        $('#part'+i+'Ref'+j).val(r)
                    })
                }
            })
            $("html, body").animate({ scrollTop: 0 }, "slow");
        });

        async function deleteData(url){
            try {
                const response = await fetch(`${url}`,{
                    method: 'DELETE',
                    headers:headers
                })

                const data = await response.json()
                return data
            }
            catch(err) {
                console.log(err);
            }
        }

        document.getElementById('btn-remove-sku').addEventListener('click', (e)=>{
            e.preventDefault()

            Swal.fire({
                title: `Are you sure?`,
                text: `Delete those kits`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    deleteSku()
                    async function deleteSku() {
                        await deleteData(`/skus/{{$sku->ref_sku}}`).then(
                            data => {
                                if (data.success){
                                    Swal.fire(
                                        'Deleted!',
                                        data.success,
                                        'success'
                                    ).then(()=>{
                                        window.location = '/skus'
                                    });
                                }else {
                                    Swal.fire('Failed!', "elements No found").then(()=>{
                                        location.reload()
                                    });
                                }
                            }
                        )
                    }


                    {{--fetch('', {--}}
                    {{--    method: 'delete',--}}
                    {{--    --}}{{--body: JSON.stringify({sku: {{$sku->ref_sku}}}),--}}
                    {{--    headers:headers--}}
                    {{--}).then(response=>{--}}
                    {{--    console.log(response)--}}

                    {{--}).then(data =>{--}}
                    {{--    console.log(data)--}}
                    {{--    // window.location = '/skus';--}}
                    {{--}).catch(error => console.log(error))--}}
                }
            });



        })
    </script>
@stop
