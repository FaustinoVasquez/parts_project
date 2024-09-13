@extends('adminlte::page')

@section('title', 'Kits Listing')

@section('content_header')
    <h1>Requirements</h1>
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
            <div class="col-lg-8 ">
                <div class="card mb-4 shadow-sm card-outline card-primary">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-row align-items-left mt-1">
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-fw fa-layer-group" style="color:blue"></i></span>
                                            </div>
                                            <input id="search_sku" type="search" class="form-control" placeholder="Filter by Sku">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="brand" aria-label="select brand" id="search_brand"
                                                class=" form-control ">
                                            <option value="0">Brand</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->Brand }}"
                                                    {{ old('brand') ? 'selected':''}}>
                                                    {{ $brand->Brand }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="model" aria-label="select model" id="search_model"
                                                class="form-control mySelect2">
                                            <option value='0'>Model</option>
                                        </select>

                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-success" id="btn-reset-form">Reset form</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-hover table-bordered nowrap hover" id="requirementsTable">
                            <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Box</th>
                                <th>Shelf</th>
                                <th>Brand</th>
                                <th>Model</th>
                                <th>Parts Qty</th>
                                <th>Url</th>
                                <th>Keywords</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 ">
                <div class="card mb-4 shadow-sm card-outline card-primary">
                    <div class="card-header ">
                        <div class="row">
                            Requirements
                        </div>
                    </div>

                    <div class="card-body">
                      Requirements
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
    <link href="https://cdn.jsdelivr.net/npm/jquery-datatables-checkboxes@1.2.13/css/dataTables.checkboxes.min.css" rel="stylesheet">

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

    <script src="https://cdn.jsdelivr.net/npm/jquery-datatables-checkboxes@1.2.13/js/dataTables.checkboxes.min.js"></script>


    {{--    <script src="js/jquery.dataTables.colResize.js"></script>--}}


    <script>
        let $requirementsTable;
        let $skusTable;
        let $skuHeaderTable
        let $kit
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let $sku
        let $sku_selected
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

            $requirementsTable = $('#requirementsTable').DataTable({
                pageLength: 100,
                lengthMenu: [
                    [100,500,5000, -1],
                    [100,500,5000,'All']
                ],
                processing: true,
                serverSide: true,
                scrollY: "53vh",
                scrollX: true,
                scrollCollapse: true,
                // stateSave: true,
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
                        text: '<i class="fas fa-plus-circle"></i> Process Req',
                        title: 'Create Req',
                        titleAttr: 'Create New Req',
                        className: 'btn btn-primary',
                        attr: {
                            id: 'create-kit-btn'
                        },
                        init: function (api, node, config) {
                            $(node).removeClass('btn-secondary buttons-html5')
                        },
                        action: function ( e, dt, node, config ) {
                            // window.location = '/kits/create';
                        }
                    }
                    ],
                },
                ajax: {
                    url: "{{route('oc.requirements.index')}}",
                    data: function (d) {
                        d.model = $('select[name=model]').val();
                    }
                },
                columns: [
                    {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                    {data: 'kitid', name: 'kitid'},
                    {data: 'boxname', name: 'boxname'},
                    {data: 'shelf_name', name: 'shelf_name'},
                    {data: 'brand', name: 'brand'},
                    {data: 'model', name: 'model'},
                    {data: 'noofparts', name: 'noofparts'},
                    {data: 'url', name: 'url'},
                    {data: 'keywords', name: 'keywords'},
                ],
                columnDefs: [
                    {
                        targets: 0,
                        checkboxes: {
                        selectRow: true,
                            className: 'larger'
                        },

                    },
                    {
                        targets: [1],
                        searchable: false,
                    },
                    {
                        targets: [7],
                        searchable: true,
                        visible: false
                    },
                    {
                        targets: [5],
                        searchable: false,
                    },
                    {
                        targets: [1,4,6],
                        className: "text-center",
                    },
                    {
                        targets: [6],
                        searchable: true,
                        exactvalue:true
                    }
                ],
                select: {
                    style: 'multi'
                },
                order: [[1, 'asc']]

            });

            // $('#search_sku').on('search keyup', function() {
            //     $requirementsTable
            //         .column(10)
            //         .search(this.value)
            //         .draw();
            // });

            {{--$(document).on('click', '.qrcode', function (e) {--}}
            {{--    e.stopPropagation();--}}
            {{--    let $tr = $(this).closest('tr');--}}
            {{--    let rowId = $tr.attr('ID');--}}
            {{--    let url = "{{route('qrcode',':id')}}"--}}
            {{--    url = url.replace(':id',rowId);--}}
            {{--    document.getElementById('printf').src = url;--}}
            {{--});--}}
            {{--$(document).on('click', '.show-btn', function (e) {--}}
            {{--    e.stopPropagation();--}}
            {{--    let $tr = $(this).closest('tr');--}}
            {{--    let rowId = $tr.attr('ID');--}}
            {{--    $(location).attr('href', 'kits/'+rowId);--}}
            {{--});--}}
            {{--$(document).on('click', '.edit-btn', function (e) {--}}
            {{--    e.stopPropagation();--}}
            {{--    let $tr = $(this).closest('tr');--}}
            {{--    let rowId = $tr.attr('ID');--}}
            {{--    $(location).attr('href', 'kits/'+rowId+'/edit');--}}
            {{--});--}}
            {{--$(document).on('click', '.del-btn', function (e) {--}}
            {{--    e.stopPropagation();--}}
            {{--    e.stopImmediatePropagation();--}}
            {{--    let $tr = $(this).closest('tr');--}}
            {{--    let rowId = $tr.attr('ID');--}}
            {{--    let url = 'kits/'+rowId;--}}
            {{--    Swal.fire({--}}
            {{--        title: 'Are you sure?',--}}
            {{--        text: "You won't be able to revert this!",--}}
            {{--        icon: 'warning',--}}
            {{--        showCancelButton: true,--}}
            {{--        confirmButtonColor: '#3085d6',--}}
            {{--        cancelButtonColor: '#d33',--}}
            {{--        confirmButtonText: 'Yes, delete it!'--}}
            {{--    }).then((result) => {--}}
            {{--        if (result.value) {--}}
            {{--            let request = $.ajax({--}}
            {{--                url: url,--}}
            {{--                type: 'delete',--}}
            {{--                dataType: 'json',--}}
            {{--            });--}}
            {{--            request.done(function (data) {--}}
            {{--                Swal.fire(--}}
            {{--                    'Deleted!',--}}
            {{--                    data.message,--}}
            {{--                    'success'--}}
            {{--                );--}}
            {{--                $requirementsTable.draw();--}}
            {{--            });--}}
            {{--            request.fail(function (jqXHR, textStatus, errorThrown) {--}}
            {{--                Swal.fire('Failed!', "There was something wrong", "warning");--}}
            {{--            });--}}
            {{--        }--}}
            {{--    });--}}
            {{--});--}}
        });

        // $(document).on('click', '.sku-btn', function (e) {
        //     e.stopPropagation();
        //     let $tr = $(this).closest('tr');
        //     $requirementsTable.$('tr.selected').removeClass('selected');
        //     $tr.addClass('selected');
        //     let rowId = $tr.attr('id');
        //     let row = $requirementsTable.row($tr).data();
        //     $kit = row['kitlcn'];
        //     $('#ajaxModalKits')
        //         .on('shown.bs.modal', function () {
        //             $(this).find(".modal-title").html("Kit: "+ rowId)
        //
        //             $(this).find(".modal-body").html(function (){
        //                 return createTables()
        //             })
        //             $(this).find(".modal-footer").html(function (){
        //                 return createButtons()
        //             })
        //
        //             showGetSkus(row['brand'],row['model'],row['ref_sku']);
        //             showGetKit(rowId)
        //
        //         }).on('hidden.bs.modal', function (e) {
        //         $(this).find(".modal-title").html('');
        //         $(this).find(".modal-body").html("");
        //         $skusTable.ajax.reload()
        //         $skusTable='';
        //         $kit = '';
        //         $requirementsTable.$('tr.selected').removeClass('selected');
        //     }).modal('show');
        //
        // });
        //
        // $(document).on('click', '#update-sku', function (e) {
        //     e.stopPropagation();
        //     fetch('/sku/kitUpdate', {
        //         method: 'POST',
        //         body: JSON.stringify({
        //             kit: $kit,
        //             sku: $sku_selected
        //         }),
        //         headers:headers
        //     }).then(response=>{
        //         return response.json()
        //     }).then(data =>{
        //         console.log(data)
        //         $requirementsTable.ajax.reload();
        //         $('#ajaxModalKits').modal('hide')
        //
        //     }).catch(error => console.log(error))
        // });
        //
        // $(document).on('click','input[type="checkbox"]', function (e){
        //
        //     let name = this.name
        //
        //     $skusTable.rows(function (idx,data, node) {
        //         return $(node).find('input[type="checkbox"][name="chkbx'+idx+'"]').prop('checked',false);
        //     })
        //
        //     $skusTable.rows(function (idx,data, node) {
        //         $(node).find('input[type="checkbox"][name="'+name+'"]').prop('checked',true).val(data.ref_sku);
        //     })
        //
        //
        //     if($sku !== this.value ){
        //         $(document).find('#update-sku').removeAttr("disabled")
        //     }else {
        //         $(document).find('#update-sku').prop("disabled",true);
        //     }
        //
        //     $sku_selected = this.value
        //
        // })
        //
        // function showGetSkus(brand,model,ref_sku){
        //     $skusTable = $('#skusTable').DataTable({
        //         pageLength: 100,
        //         lengthMenu: [
        //             [100,500, -1],
        //             [100,500,'All']
        //         ],
        //         processing: true,
        //         serverSide: true,
        //         scrollY: "53vh",
        //         scrollX: true,
        //         scrollCollapse: true,
        //         stateSave: true,
        //         dom: '"<\'row\'<\'col-md-6\'B><\'col-md-6\'f>>" +\n' +
        //             '"<\'row\'<\'col-sm-12\'tr>>" +\n' +
        //             '"<\'row\'<\'col-sm-12 col-md-5\'i ><\'col-sm-12 col-md-7\'p>>"',
        //         buttons: {
        //             dom: {
        //                 container: {
        //                     tag: 'div',
        //                     className: 'flexcontent'
        //                 },
        //                 buttonLiner: {
        //                     tag: null
        //                 }
        //             },
        //             buttons: [
        //                 {
        //                     extend: 'pageLength',
        //                     titleAttr: 'Show Records',
        //                     className: 'btn btn-secondary buttons-collection dropdown-toggle buttons-colvis',
        //                 }
        //             ],
        //         },
        //
        //         ajax: {
        //             url: "/sku/getSkuToKit",
        //             data: function (d) {
        //                 d.brand = brand;
        //                 d.model = model;
        //                 d.ref_sku = ref_sku;
        //             },
        //         },
        //         columns: [
        //             {data: 'select',name:'select'},
        //             {data: 'ref_sku',name:'ref_sku'},
        //             {data: 'brand',name:'brand'},
        //             {data: 'model',name:'model'},
        //             {data: 'version',name:'version'},
        //             {data: 'Open Cell',name:'Open Cell'},
        //             {data: 'Main Board',name:'Main Board'},
        //             {data: 'T-Con Board',name:'T-Con Board'},
        //             {data: 'Power Supply',name:'Power Supply'},
        //             {data: 'WiFi Module',name:'WiFi Module'},
        //             {data: 'IR Sensor',name:'IR Sensor'},
        //             {data: 'Button Set',name:'Button Set'},
        //             {data: 'Blutooth Module',name:'Blutooth Module'},
        //             {data: 'chasis',name:'chasis'},
        //             {data: 'product_version_number',name:'product_version_number'},
        //         ],
        //         columnDefs: [
        //
        //             {
        //                 targets: 0,
        //                 orderable: false,
        //                 searchable: false,
        //                 className: 'dt-body-center',
        //                 render: function(data, type, full, meta) {
        //                     if(data === "disable"){
        //                         return '<input type="checkbox" name="chkbx'+meta.row+'" class="larger">';
        //                     }else{
        //                         $sku = data
        //                         return '<input type="checkbox" checked name="chkbx'+meta.row+'" class="larger">';
        //                     }
        //                 },
        //             },{
        //                 targets: [3,4,5],
        //                 className: "text-center",
        //             }
        //         ],
        //         order: [[1, 'desc']],
        //     });
        // }
        // function showGetKit( rowId ) {
        //     $skuHeaderTable =$('#kitHeaderTable').DataTable({
        //         serverSide: true,
        //         scrollX: true,
        //         pageLength: 100,
        //         ajax: {
        //             url: "/sku/getKitData/",
        //             data: function (d) {
        //                 d.kit =rowId;
        //             },
        //         },
        //         dom: 'rt',
        //         columns: [
        //             {data: 'kitlcn',name:'kitlcn'},
        //             {data: 'brand',name:'brand'},
        //             {data: 'model',name:'model'},
        //             {data: 'Open Cell',name:'Open Cell'},
        //             {data: 'Main Board',name:'Main Board'},
        //             {data: 'T-Con Board',name:'T-Con Board'},
        //             {data: 'Power Supply',name:'Power Supply'},
        //             {data: 'WiFi Module',name:'WiFi Module'},
        //             {data: 'IR Sensor',name:'IR Sensor'},
        //             {data: 'Button Set',name:'Button Set'},
        //             {data: 'Blutooth Module',name:'Blutooth Module'},
        //         ]
        //     })
        //
        // }
        // function createTables(){
        //     return '<table class="table table-striped table-hover table-bordered nowrap hover" id="kitHeaderTable">' +
        //         '<thead>' +
        //         '<tr>' +
        //         '<th>Kit Lcn</th>' +
        //         '<th>Bran</th>' +
        //         '<th>Model</th>' +
        //         '<th>Open Cell</th>' +
        //         '<th>Main Board</th>' +
        //         '<th>T-Con Board</th>' +
        //         '<th>Power Supply</th>' +
        //         '<th>WiFi Module</th>' +
        //         '<th>IR Sensor</th>' +
        //         '<th>Button Set</th>' +
        //         '<th>Blutooth Module</th>' +
        //         '</tr>' +
        //         '</thead>' +
        //         '</table>'+
        //         '<br>'+
        //         '<hr>'+
        //
        //
        //         '<table class="table table-striped table-hover table-bordered nowrap hover" id="skusTable"><thead><tr>' +
        //         '<th></th>' +
        //         '<th>Ref Sku</th>' +
        //         '<th>Brand</th>' +
        //         '<th>Model</th>' +
        //         '<th>Version</th>' +
        //         '<th>Open Cell</th>' +
        //         '<th>Main Board</th>' +
        //         '<th>T-Con Board</th>' +
        //         '<th>Power Supply</th>' +
        //         '<th>WiFi Module</th>' +
        //         '<th>IR Sensor</th>' +
        //         '<th>Button Set</th> ' +
        //         '<th>Blutooth Module</th>' +
        //         '<th>Chasis</th> ' +
        //         '<th>product_version_number</th>' +
        //         '</tr> </thead></table>'
        // }
        // function createButtons(){
        //     return '<button type="button" id="update-sku" class="btn btn-primary" disabled>Save changes</button> ' +
        //         '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'
        // }
        //
        // document.getElementById('search_brand').addEventListener('change', (e)=>{
        //     e.preventDefault();
        //     let selModel = document.getElementById('search_model');
        //
        //     if (selModel.value !== '0' && selModel.value !== ''){
        //         selModel.value ='0';
        //     }
        //
        //
        //     fetch('/sku/getModels', {
        //         method: 'POST',
        //         body: JSON.stringify({text: e.target.value}),
        //         headers:headers
        //     }).then(response=>{
        //         return response.json()
        //     }).then(data =>{
        //         let options = "<option value='0'>Model</option>";
        //         for (let i in data){
        //             options += '<option value="'+data[i].model+'">'+data[i].model+'</option>';
        //         }
        //         document.getElementById('search_model').innerHTML = options
        //     }).catch(error => console.log(error))
        //
        //
        //     manage()
        // })
        //
        // function manage() {
        //     let selBrand = document.getElementById('search_brand');
        //     let selModel = document.getElementById('search_model');
        //
        //
        //     if(selBrand.value !== '0'){
        //         $requirementsTable.column(7).search(selBrand.value).draw()
        //     }
        //
        //     if (selModel.value !== '0' && selModel.value !== ''){
        //
        //         // $requirementsTable.column(7).search(selModel.value).draw()
        //
        //         // added =========
        //         $requirementsTable.ajax.reload()
        //         //--------------------
        //     }
        //
        //     if(selBrand.value === '0'){
        //         $requirementsTable.columns([7,8]).search("").draw();
        //         document.querySelectorAll('#search_model option').forEach(o =>{if (o.value !=0){ o.remove()}});
        //     }
        //
        //     if(selModel.value === '0'){
        //         $requirementsTable.columns([8]).search("").draw();
        //     }
        //
        //
        // }
        //
        // document.getElementById('btn-reset-form').addEventListener('click', (e)=>{
        //     document.getElementById('search_brand').selectedIndex = 0;
        //     document.querySelectorAll('#search_model option').forEach(o =>{if (o.value !=0){ o.remove()}});
        //     document.getElementById('search_sku').value = '';
        //     $requirementsTable.columns([7,8,10]).search("").draw();
        // });
        //
        //
        //
        // $('.mySelect2').select2({
        //     theme: 'bootstrap4',
        //     width: 'resolve'
        // }).on('select2:select', function(e) {
        //     manage()
        // });

    </script>
@stop

