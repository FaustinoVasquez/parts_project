@extends('adminlte::page')

@section('title', 'Shelves')

@section('content_header')
    <h1>Shelves</h1>
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
                <div class="card mb-4 shadow-sm card-outline card-success">
                    <div class="card-header ">
                        <h3 class="card-title mt-1">
                            Shelves Listing
                        </h3>
                        <div class="card-tools">
{{--                            <button class="btn btn-success" id="create_shelf" ><i class="fa fa-plus"></i> Create Shelf</button>--}}
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-hover table-bordered" id="shelfTable">
                            <thead>
                            <tr>
                                <th>Shelf ID</th>
                                <th>Shelf ID Old</th>
                                <th>Actions</th>
                                <th>Boxes</th>
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
        let $shelfTable;

        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let headers = {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": token
        }
        $(document).ready( function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let $shelfTable = $('#shelfTable').DataTable({
                responsive: true,
                serverSide: true,
                scrollY: "53vh",
                scrollX: false,

                ajax: "{{route('shelves.index')}}",
                columns: [
                    {data: 'shelf_name_new',name: 'shelf_name_new'},
                    {data: 'shelf_name',name: 'shelf_name'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false},
                    {data: 'boxes',name: 'boxes' , orderable: false, searchable: false},
                    {data: 'created_at',name: 'created_at'},
                ]
            });


            $(document).on('click', '.qrcode', function (e) {
                e.stopPropagation();
                let $tr = $(this).closest('tr');
                let rowId = $tr.attr('ID');
                let url = "{{route('qrcode.shelf',':id')}}"
                url = url.replace(':id',rowId);
                document.getElementById('printf').src = url;
            });

            $(document).on('click', '.show-btn', function (e) {
                e.stopPropagation();
                let $tr = $(this).closest('tr');
                let rowId = $tr.attr('ID');
                $(location).attr('href', 'shelves/'+rowId);
            });

            // $(document).on('click', '.show-btn', function (e) {
            //     e.stopPropagation();
            //     let $tr = $(this).closest('tr');
            //     let rowId = $tr.attr('ID');
            //     $(location).attr('href', 'shelf/'+rowId);
            // });
            //
            // $(document).on('click', '.edit-btn', function (e) {
            //     e.stopPropagation();
            //     let $tr = $(this).closest('tr');
            //     let rowId = $tr.attr('ID');
            //     $(location).attr('href', 'shelf/'+rowId+'/edit');
            // });

        });

        {{--document.getElementById('create_shelf').addEventListener('click',function (){--}}
        {{--    fetch('shelves', {--}}
        {{--        method: 'POST',--}}
        {{--        headers:headers--}}
        {{--    }).then(response=>{--}}
        {{--        return response.json()--}}
        {{--    }).then(data =>{--}}
        {{--        printQr(data.shelf_id)--}}
        {{--        $('#shelfTable').DataTable().ajax.reload();--}}

        {{--    }).catch(error => console.log(error))--}}
        {{--})--}}
        {{--function printQr(id) {--}}
        {{--    let url = "{{route('qrcode.shelf',':id')}}"--}}
        {{--    url = url.replace(':id',id);--}}
        {{--    document.getElementById('printf').src = url;--}}
        {{--}--}}


    </script>
@stop

