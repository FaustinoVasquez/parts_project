@extends('adminlte::page')

@section('title', 'Kit Show')

@section('content_header')
    <h1>Show Kit number {{$kit->KitID}}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Kit Details</h3>
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
                            <h4>Parts Related</h4>

                            @foreach($parts as $part)
                            <div class="post">
                                <div class="user-block">
                                    <img class="img-circle img-bordered-sm" src="{{asset('images/img.png')}}"
                                         alt="user image">
                                    <span class="username">
                                        <a href="#">{{$part->PartName}}</a>
                                    </span>
                                    <span class="description">{{$part->DateCreated}}</span>
                                </div>
                                <p class="text-md">Part Weight Oz:
                                    <b class="d-inline">{{$part->PartWeightOz}} </b>
                                </p>

                                <p class="text-md">Part Reference 1:
                                    <b class="d-inline">{{$part->PartRef1}}</b>
                                </p>
                                <p class="text-md">Part Reference 2:
                                    <b class="d-inline">{{$part->PartRef2 }}</b>
                                </p>
                                <p class="text-md">Part Reference 3:
                                    <b class="d-inline">{{($part->PartRef3)}}</b>
                                </p>
                                <p class="text-md">Part Reference 4:
                                    <b class="d-inline">{{($part->PartRef4)}}</b>
                                </p>
                                <p class="text-md">Part Reference 5:
                                    <b class="d-inline">{{($part->PartRef5)}}</b>
                                </p>
                                <p>
                                    <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> image</a>
                                </p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                    <h3 class="text-primary"><i class="fas fa-layer-group"></i> Kit-{{$kit->KitID}}</h3>

                    <div class="text-muted">
                        <p class="text-md">Kit Created In:
                            <b class="d-inline">{{$kit->workcenter->WorkCenterName}}</b>
                        </p>
                        <p class="text-md">LCN:
                            <b class="d-inline">{{$kit->LCN}}</b>
                        </p>
                        <p class="text-md">Brand:
                            <b class="d-inline">{{$kit->Brand}}</b>
                        </p>
                        <p class="text-md">Model:
                            <b class="d-inline">{{$kit->Model}}</b>
                        </p>
                        <p class="text-md">Category:
                            <b class="d-inline">{{$kit->category->CategoryName}}</b>
                        </p>
                        <p class="text-md">SubCategory:
                            <b class="d-inline">{{$kit->subcategory->SubCategoryName}}</b>
                        </p>
                        <p class="text-md">Serial Number:
                            <b class="d-inline">{{$kit->ProductSerialNumber}}</b>
                        </p>
                        <p class="text-md">Country Origin:
                            <b class="d-inline">{{$kit->country->CountryName}}</b>
                        </p>
                        <p class="text-md">DateManufactured:
                            <b class="d-inline">{{$kit->DateManufactured}}</b>
                        </p>
                        <p class="text-md">Estimated Retail Price:
                            <b class="d-inline">{{$kit->EstimatedRetailPrice}}</b>
                        </p>
                        <p class="text-muted">{{$kit->notes}}</p>
                        <br>
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

