@extends('adminlte::page')

@section('title', 'Kits Listing')

@section('content_header')
    <h1>OCData</h1>
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
            <div class="col-lg-12 ">
                <div class="card mb-4 shadow-sm card-outline card-primary">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-row align-items-left mt-1">
                                    <div class="col-md-3">
                                       Oc Data
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-hover table-bordered nowrap hover" id="ocTable">
                            <thead>
                            <tr>
                                <th>tv_id</th>
                                <th>Brand</th>
                                <th>Model</th>
                                <th>NoOfConfigOC</th>
                                <th>ConfigOCs</th>
                                <th>BuildQty</th>
                                <th>Damage TV Qty</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <iframe id="printf" name="printf"  style="visibility: hidden;" src="about:blank"></iframe>
    @include('skus.shared.kitsModal')
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.5.0/css/select.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>


    <style>
        .verybigmodal {
            max-width: 80%;
            margin-left: 10%;
        }
        .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
            background-color: #94eed3;
        }
        input.larger {
            width: 20px;
            height: 20px;
        }

        .table-condensed{
            font-size: 25px;
        }
    </style>

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
    <script src="https://cdn.datatables.net/select/1.5.0/js/dataTables.select.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    {{--    <script src="js/jquery.dataTables.colResize.js"></script>--}}


    <script>
        let $ocTable;

        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let headers = {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": token
        }
        $(document).ready( function () {
            $.ajaxSetup({
                headers
            });

            $ocTable = $('#ocTable').DataTable({
                order: [[0, 'desc']],
                pageLength: 100,
                lengthMenu: [
                    [100,500,5000, -1],
                    [100,500,5000,'All']
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
                    },{
                        extend: 'pageLength',
                        titleAttr: 'Show Records',
                        className: 'btn btn-secondary buttons-collection dropdown-toggle buttons-colvis',
                    },{
                        text: '<i class="fas fa-plus-circle"></i> Configure OpenCell',
                        title: 'Create Kit',
                        titleAttr: 'Create New Kit',
                        className: 'btn btn-primary',
                        attr: {
                            id: 'create-kit-btn'
                        },
                        init: function (api, node, config) {
                            $(node).removeClass('btn-secondary buttons-html5')
                        },
                        action: function ( e, dt, node, config ) {
                            window.location = '/oc/create';
                        }
                    }
                    ],
                },
                ajax: {
                    url: "{{route('oc.index')}}"
                },
                columns: [
                    {data:'tv_id',name:'tv_id'},
                    {data:'Brand',name:'Brand'},
                    {data:'Model',name:'Model'},
                    {data:'NoOfConfigOC',name:'NoOfConfigOC'},
                    {data:'ConfigOCs',name:'ConfigOCs'},
                    {data:'BuildQty',name:'BuildQty'},
                    {data:'DamageTVQty',name:'DamageTVQty'},
                    {data:'actions', name: 'actions'},

                ],
                columnDefs: [
                    {
                        targets: [0],
                        searchable: true,
                        // visible: false,
                    },
                    {
                        targets: [7],
                        searchable: false,
                    },
                    {
                        targets: [3],
                        className: "text-center",
                    },
                    {
                        targets: [4],
                        render: function ( data, type, full ) {
                            return $("<div/>").html(data).text();
                        }
                    },
                ],

            });
        });


    </script>
@stop

