@extends('adminlte::page')

@section('title', 'AddInv')

@section('content_header')
    <h1>Sku Report</h1>
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

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header ">
                    <h3 class="card-title mt-1 days">
                        {{ __('Sku Report (Last 7 days)')}}
                    </h3>
                </div>

                <div class="card-body">
                    <table class="table table-striped table-hover table-bordered nowrap" id="kitsTable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>TotalKits</th>
                            <th>KitsW/SKU</th>
                            <th>KitsW/NoSKU</th>
                        </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>

@stop

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
        let $kitsTable;
        let days = 7;
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let $kitsTable = $('#kitsTable').DataTable({
                order: [[0, 'desc']],
                pageLength: 100,
                lengthMenu: [
                    [100, 500, -1],
                    [100, 500, 'All']
                ],
                processing: true,
                serverSide: true,
                scrollY: "53vh",
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
                    buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        title: 'Kits to Excel',
                        titleAttr: 'Excel',
                        className: 'btn btn-success',
                        init: function (api, node, config) {
                            $(node).removeClass('btn-secondary buttons-html5 buttons-excel')
                        },
                    },
                        {
                            extend: 'pageLength',
                            titleAttr: 'Show Records',
                            className: 'btn btn-secondary buttons-collection dropdown-toggle buttons-colvis',
                        }, {
                            extend: 'collection',
                            text: 'Days',
                            className: 'btn btn-secondary buttons-collection dropdown-toggle buttons-colvis',
                            autoClose: true,
                            buttons: [
                                {
                                    text: '7',
                                    action: function (e, dt, node, config) {
                                        days = 7
                                        $('.days').text('Sku Report (Last 7 days)')
                                        $kitsTable.ajax.reload();
                                    }
                                },
                                {
                                    text: '14',
                                    action: function (e, dt, node, config) {
                                        days = 14
                                        $('.days').text('Sku Report (Last 14 days)')
                                        $kitsTable.ajax.reload();
                                    }
                                },
                                {
                                    text: '30',
                                    action: function (e, dt, node, config) {
                                        days = 30
                                        $('.days').text('Sku Report (Last 30 days)')
                                        $kitsTable.ajax.reload();
                                    }
                                },
                                {
                                    text: '60',
                                    action: function (e, dt, node, config) {
                                        days = 60
                                        $('.days').text('Sku Report (Last 60 days)')
                                        $kitsTable.ajax.reload();
                                    }
                                },
                                {
                                    text: '90',
                                    action: function (e, dt, node, config) {
                                        days = 90
                                        $('.days').text('Sku Report (Last 90 days)')
                                        $kitsTable.ajax.reload();
                                    }
                                }
                            ]
                        }

                    ],
                },

                ajax: {
                    url: "{{route('reports.skus')}}",
                    data: function (d) {
                        d.days = days;
                    },
                },
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'Brand', name: 'Brand'},
                        {data: 'Model', name: 'Model'},
                        {data: 'TotalKits', name: 'TotalKits'},
                        {data: 'KitsW/SKU', name: 'KitsW/SKU'},
                        {data: 'KitsW/NoSKU', name: 'KitsW/NoSKU'},
                    ],
            });
        });


    </script>
@stop

