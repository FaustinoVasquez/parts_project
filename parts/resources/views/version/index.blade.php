@extends('adminlte::page')

@section('title', 'AddInv')

@section('content_header')
    <h1>Faster Creating Kits</h1>
@stop

@section('content')

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </div>
    @endif

    @if (session('danger'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('danger') }}
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </div>
    @endif


    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card">
                <div class="card-header ">
                    <h3 class="card-title mt-1">
                        {{ __('Faster Creating Kits')}}
                    </h3>
                    <div class="card-tools">
                        LCN: {{$skus[0]->KitLCN}} &emsp;Brand: {{$skus[0]->brand}} &emsp;Model: {{$skus[0]->model}}
                    </div>
                </div>


                <div class="card-body" id="mainForm">
                    <form method="POST" action="{{ route('version.store') }}"  id="myForm">
                        @csrf
                        @foreach($skus as $sku)
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="mycheckbox{{$sku->version}}" name="Ref_Sku" value="{{$sku->ref_sku}}">
                                <label class="custom-control-label font-weight-normal" for="mycheckbox{{$sku->version}}">
                                    <ul>
                                        <li>
                                            <b>Version:</b>&emsp;{{$sku->version}}<br>
                                            <b>SKU:</b>&emsp;{{$sku->ref_sku}}<br>
                                            {!!$sku->Parts!!}
                                        </li>
                                    </ul>
                                </label>
                            </div>
                        @endforeach
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="mycheckbox0" name="Ref_Sku" value="nodata">
                            <label class="custom-control-label font-weight-normal" for="mycheckbox0">
                                <ul>
                                    <li>
                                        <b>Version: 0</b> None of the above
                                    </li>
                                </ul>
                            </label>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" name="KitLCN" value="{{$skus[0]->KitLCN}}" hidden >
                        </div>

                        <div class="row">
                            <button type="submit" class="btn btn-block btn-primary">
                                {{ __('Create SKU[F12]') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@stop

@section('css')

@stop

@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let aux='';
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let headers = {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": token
        }

        $(document).on("keypress", function (e) {
            let id = 'mycheckbox'+e.key
            document.getElementById(id).checked= true;
        });
        document.getElementById('mycheckbox1').checked= true
    </script>
@stop
