@extends('adminlte::page')

@section('title', 'Skus Listing')

@section('content_header')
    <h1>Skus</h1>
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
                        <form>
                            <div class="form-row align-items-center">
                                <div class="col-sm-3 my-1">
                                    <select name="brand" aria-label="select brand" id="myBrand"
                                            class=" form-control ">
                                        <option value="0">Brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->Brand }}"
                                                {{ old('brand') ? 'selected':''}}>
                                                {{ $brand->Brand }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3 my-1">
                                    <select name="model" aria-label="select model" id="myModel"
                                            class="form-control mySelect2">
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-hover table-bordered nowrap" id="skusTable">
                            <thead>
                            <tr>
                                <th>Ref_SKU</th>
                                <th>Brand</th>
                                <th>Model</th>
                                <th>Version</th>
                                <th>Product Version Number</th>
                                <th>Open Cell</th>
                                <th>Main Board</th>
                                <th>T-Con Board</th>
                                <th>Power Supply</th>
                                <th>WiFi Module</th>
                                <th>IR Sensor</th>
                                <th>Button Set</th>
                                <th>Blutooth Module</th>
                                <th>Country Manufactured</th>
                                <th>Chasis</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 ">
                <div class="card mb-4 shadow-sm card-outline card-success">
                    <div class="card-header ">
                        <h3 class="card-title mt-1">
                            Kits Listing
                        </h3>
                        <div class="card-tools">
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-hover table-bordered nowrap" id="kitsTable">
                            <thead>
                            <tr>
                                <th>KitID</th>
                                <th>Brand</th>
                                <th>Model</th>
                                <th>Open Cell</th>
                                <th>Main Board</th>
                                <th>T-Con Board</th>
                                <th>Power Supply</th>
                                <th>WiFi Module</th>
                                <th>IR Sensor</th>
                                <th>Button Set</th>
                                <th>Blutooth Module</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <iframe id="printf" name="printf"  style="visibility: hidden;" src="about:blank"></iframe>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap4.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let $skusTable;
        let $kitsTable;
        let brand,create_sku_btn;
        let model;
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

            $skusTable = $('#skusTable').DataTable({
                pageLength: 100,
                lengthMenu: [
                    [100,500, -1],
                    [100,500,'All']
                ],
                processing: true,
                serverSide: true,
                scrollY: "53vh",
                scrollX: true,
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
                    },
                        {
                            extend: 'pageLength',
                            titleAttr: 'Show Records',
                            className: 'btn btn-secondary buttons-collection dropdown-toggle buttons-colvis',
                        },{
                            text: '<i class="fas fa-bolt"></i> Add SKU',
                            title: 'Create New Sku',
                            titleAttr: 'Create New Sku',
                            className: 'btn btn-primary',
                            attr: {
                                id: 'create-sku-btn'
                            },
                            init: function (api, node, config) {
                                $(node).removeClass('btn-secondary buttons-html5')
                                this.disable();
                            },
                            action: function ( e, dt, node, config ) {
                                brand =$('select[name=brand]').val();
                                model =$('select[name=model]').val();

                                // model =$('#myModel').find(':selected');
                                window.location = '/sku/steps/create/'+brand+'/'+model;
                            },
                        }
                    ],
                },

                ajax: {
                    url: "{{route('skus.create')}}",
                    data: function (d) {
                        d.brand = $('select[name=brand]').val();
                        d.model = $('select[name=model]').val();
                    }
                },


                columns: [
                    {data: 'ref_sku',name:'ref_sku'},
                    {data: 'brand',name:'brand'},
                    {data: 'model',name:'model'},
                    {data: 'version',name:'version'},
                    {data: 'country_manufactured',name:'country_manufactured'},
                    {data: 'Open Cell',name:'Open Cell'},
                    {data: 'Main Board',name:'Main Board'},
                    {data: 'T-Con Board',name:'T-Con Board'},
                    {data: 'Power Supply',name:'Power Supply'},
                    {data: 'WiFi Module',name:'WiFi Module'},
                    {data: 'IR Sensor',name:'IR Sensor'},
                    {data: 'Button Set',name:'Button Set'},
                    {data: 'Blutooth Module',name:'Blutooth Module'},
                    {data: 'chasis',name:'chasis'},
                    {data: 'product_version_number',name:'product_version_number'},
                ],
            });

            $kitsTable = $('#kitsTable').DataTable({
                order: [[0, 'desc']],
                pageLength: 100,
                lengthMenu: [
                    [50,100, -1],
                    [50,100,'All']
                ],
                processing: true,
                serverSide: true,
                scrollY: "35vh",

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
                    buttons: [
                        {
                            extend: 'pageLength',
                            titleAttr: 'Show Records',
                            className: 'btn btn-secondary buttons-collection dropdown-toggle buttons-colvis',
                        }
                    ],
                },


                ajax: {
                    url:'/sku/getKitsWSku',
                    data: function (d) {
                        d.brand = $('select[name=brand]').val();
                        d.model = $('select[name=model]').val();
                        // console.log(d.model)
                    }
                },
                columns: [
                    {data: 'KitID', name: 'KitID'},
                    {data: 'brand', name: 'brand'},
                    {data: 'model', name: 'model'},
                    {data: 'Open Cell', name: 'Open Cell'},
                    {data: 'Main Board', name: 'Main Board'},
                    {data: 'T-Con Board', name: 'T-Con Board'},
                    {data: 'Power Supply', name: 'Power Supply'},
                    {data: 'WiFi Module', name: 'WiFi Module'},
                    {data: 'IR Sensor', name: 'IR Sensor'},
                    {data: 'Button Set', name: 'Button Set'},
                    {data: 'Blutooth Module', name: 'Blutooth Module'},
                ],
                columnDefs: [
                    {
                        targets: [0],
                        searchable: true,
                    },
                ]
            });
        });


        document.getElementById('myBrand').addEventListener('change', (e)=>{
            fetch('/sku/getModels', {
                method: 'POST',
                body: JSON.stringify({text: e.target.value}),
                headers:headers
            }).then(response=>{
                return response.json()
            }).then(data =>{
                let options = "<option value='0'>Model</option>";
                for (let i in data){
                    options += '<option value="'+data[i].model+'">'+data[i].skucountpendingkits+'</option>';
                }
                document.getElementById('myModel').innerHTML = options
            }).catch(error => console.log(error))
            manage()
        })

        function manage() {
            let bt = document.getElementById('create-sku-btn');
            let selBrand = document.getElementById('myBrand');
            let selModel = document.getElementById('myModel');
            if(selBrand.value !== '0' && selModel.value !== '0'&& selModel.value !== ''){
                bt.classList.remove('disabled');
                bt.disabled = false;
            }else{
                bt.disabled = true;

            }
            $skusTable.ajax.reload();
            $kitsTable.ajax.reload();
        }

        //  Hisense 58R6E3

        $('.mySelect2').select2({
            theme: 'bootstrap4',
        }).on('select2:select', function(e) {
            manage()
        });


    </script>
@stop
{{--element, firstmodel--}}


