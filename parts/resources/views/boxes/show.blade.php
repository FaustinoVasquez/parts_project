@extends('adminlte::page')

@section('title', 'Kit Show')

@section('content_header')
    <h1>Show BOX{{$box->box_id}}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Box Details</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                    <div class="row">
                        <div class="col-12">
                            <h4>{{$kits->count()}} Related KitLCN</h4>
                            <div class="post">
                                <ul>
                                    @foreach($kits as $kit)
                                        <li><b>{{$kit}} </b></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop


