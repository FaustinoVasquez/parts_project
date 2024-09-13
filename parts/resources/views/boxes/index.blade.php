@extends('adminlte::page')

@section('title', 'Boxes')

@section('content_header')
    <h1>Boxes</h1>
@stop

@section('content')
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

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 my-3">
                <div class="card mb-4 shadow-sm card-outline card-info">
                    <div class="card-header ">
                        <h3 class="card-title mt-1">
                            Box Listing
                        </h3>
                        <div class="card-tools">
                            <button class="btn btn-primary" id="create_box" ><i class="fa fa-plus"></i> Create Box</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-hover table-bordered" id="boxTable">
                            <thead>
                            <tr>
                                <th>Box Id</th>
                                <th>Actions</th>
                                <th>Description</th>
                                <th># Kits</th>
                                <th>Is Active</th>
                                <th>Shelf</th>
                                <th>Shelf Scanned</th>
                                <th>Created At</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <iframe id="printf" name="printf"  style="visibility: hidden;" src="about:blank"></iframe>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.js"></script>

    <script>
        let $boxTable;
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let headers = {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": token
        }

        $(document).ready( function () {

            let $boxTable = $('#boxTable').DataTable({
                order: [[0, 'desc']],
                responsive: true,
                serverSide: true,
                scrollY: "53vh",
                fixedHeader: true,

                ajax: "{{route('boxes.index')}}",
                columns: [
                    {data: 'box_name',name: 'box_name'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false},
                    {data: 'description',name: 'description'},
                    {data: 'kits',name: 'kits'},
                    {data: 'is_active',name: 'is_active'},
                    {data: 'shelf_id',name: 'shelf_id'},
                    {data: 'shelf_scanned_date',name: 'shelf_scanned_date'},
                    {data: 'date_created',name: 'date_created'},
                ]
            });

            $(document).on('click', '.qrcode', function (e) {
                e.stopPropagation();
                let $tr = $(this).closest('tr');
                let rowId = $tr.attr('ID');
                let url = "{{route('qrcode.box',':id')}}"
                url = url.replace(':id',rowId);
                document.getElementById('printf').src = url;
            });

        });

        $(document).on('click', '.show-btn', function (e) {
            e.stopPropagation();
            let $tr = $(this).closest('tr');
            let rowId = $tr.attr('ID');
            $(location).attr('href', 'boxes/'+rowId);
        });


        document.getElementById('create_box').addEventListener('click',function (){
            fetch('boxes', {
                method: 'POST',
                headers:headers
            }).then(response=>{
                return response.json()
            }).then(data =>{
                printQr(data.box_id)
                $('#boxTable').DataTable().ajax.reload();

            }).catch(error => console.log(error))
        })
        function printQr(id) {
            let url = "{{route('qrcode.box',':id')}}"
            url = url.replace(':id',id);
            document.getElementById('printf').src = url;
        }

    </script>
@stop

