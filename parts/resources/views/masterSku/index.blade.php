@extends('adminlte::page')

@section('title', 'Skus Master')

@section('content_header')
    <h1>Master SKU</h1>
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
                        Master SKU List
                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-hover table-bordered nowrap" id="masterSKUTable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Actions</th>
                                <th>Master SKU</th>
                                <th>SKU Compatibility</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--    <iframe id="printf" name="printf"  style="visibility: hidden;" src="about:blank"></iframe>--}}
{{--    @include('skuMaster.shared.modal')--}}
{{--    @include('skus.shared.skuModalEditForm')--}}
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.5.0/css/select.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/jquery-datatables-checkboxes@1.2.13/css/dataTables.checkboxes.min.css" rel="stylesheet">

    <style>
        .verybigmodal {
            max-width: 80%;
        }
        input[type=checkbox]{
            width: 17px;
            height: 17px;
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
    <script src="https://cdn.jsdelivr.net/npm/jquery-datatables-checkboxes@1.2.13/js/dataTables.checkboxes.min.js"></script>

    <script src="{{ asset('js/masterSku.js') }}"></script>

    <script>
        let $masterSKUTable;
        // let $skusTable;
        // let $kitsBulkTable
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        // let selBrand = '0'
        // let selModel
        // let selImages
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

            $masterSKUTable = $('#masterSKUTable').DataTable({
                order: [[0, 'desc']],
                pageLength: 100,
                lengthMenu: [
                    [100,500, -1],
                    [100,500,'All']
                ],
                processing: true,
                serverSide: true,
                scrollY: "53vh",
                // scrollX: true,
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
                    buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        title: 'Skus to Excel',
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
                        text: '<i class="fas fa-plus-circle"></i> Create SkuMaster',
                        title: 'Create SKU Master',
                        titleAttr: 'Create New SKU Master',
                        className: 'btn btn-primary',
                        attr: {
                            id: 'create-sku-master-btn'
                        },
                        init: function (api, node, config) {
                            $(node).removeClass('btn-secondary buttons-html5')
                        },
                        action: async function ( e, dt, node, config ) {
                            let data = await manageData('/master-sku/createMasterSKU')
                            window.location = 'master-sku/'+data['MasterSku']+'/edit';
                        }
                    }
                    ],
                },

                ajax: {
                    url: "{{route('master-sku.index')}}",
                },

                columnDefs: [
                    {
                        targets: [0,1,2],
                        className: "text-center",
                    },
                ],

                columns: [

                    {data: 'ref_parentid',name:'ref_parentid'},
                    {data: 'actions',name:'actions'},
                    {data: 'MasterSKU',name:'MasterSKU'},
                    {data: 'SKU Compatability',name:'SKU Compatability'},
                ]
            });
        });

        $(document).on('click', '.edit-btn', async function (e) {
            let $tr = $(this).closest('tr');
            let rowId = $tr.attr('id');
            let row = $masterSKUTable.row($tr).data();
            window.location.replace("/master-sku/"+row.MasterSKU+"/edit");
        })

    </script>
@stop


