@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1></h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-outline card-primary">
                <div class="card-header border-0">
                    <h3 class="card-title">Qty Processed per Day per User (Today)</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-tool btn-sm">
                            <i class="fas fa-bars"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Qty Captured</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($perday as $day)
                            <tr>
                                <td>
                                    {{$day->name}}
                                </td>
                                <td>
                                    {{$day->QtyCaptured}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-lg-6">
            <div class="card card-outline card-success">
                <div class="card-header border-0">
                    <h3 class="card-title">Quantity Processed per Day per User (Last 7 Days)</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-tool btn-sm">
                            <i class="fas fa-bars"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Qty Captured</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($perweek as $day)
                            <tr>
                                <td>
                                    {{$day->name}}
                                </td>
                                <td>
                                    {{$day->QtyCaptured}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-lg-6">
            <div class="card card-outline card-info">
                <div class="card-header border-0">
                    <h3 class="card-title">Quantity Processed per Day per User (Last 30 Days)</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-tool btn-sm">
                            <i class="fas fa-bars"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Qty Captured</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($permonth as $day)
                            <tr>
                                <td>
                                    {{$day->name}}
                                </td>
                                <td>
                                    {{$day->QtyCaptured}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-outline card-warning">
                <div class="card-header border-0">
                    <h3 class="card-title">Quantity Processed per Day per User (Lifetime)</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-tool btn-sm">
                            <i class="fas fa-bars"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Qty Captured</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($lifetime as $day)
                            <tr>
                                <td>
                                    {{$day->name}}
                                </td>
                                <td>
                                    {{$day->QtyCaptured}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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

