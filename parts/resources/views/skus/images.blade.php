@extends('adminlte::page')

@section('title', 'Sku Images')

@section('content_header')
    <h1>Images to Sku {{$sku->ref_sku}}</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            @foreach($images as $key => $image)
            <div class="col-md-3">
                <div class="card mb-3">
                    <div class="card-header">
                        <h4 class="card-text">{{$image->part_name}}</h4>
                    </div>

                    <div class="card-body">
                        <a href="{{$image->image_url}}" target="_blank"><img class="card-img-top" src="{{$image->image_url}}" alt="{{$image->part_name}}"></a>
                    </div>
                </div>
            </div>
     @endforeach
        </div>
    </div>

@endsection

@section('css')

@stop

@section('js')

@stop
