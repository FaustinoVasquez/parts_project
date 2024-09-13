@extends('adminlte::page')

@section('title', 'Edit Skus Master')

@section('content_header')
    <h1>Edit SKUMaster: {{$id}}</h1>
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
            <div class="col-lg-8">
                <div class="card mb-4 shadow-sm card-outline card-primary">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-row align-items-left mt-1">
                                    <div class="col-md-2">
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
                                    <div class="col-md-2">
                                        <select name="model" aria-label="select model" id="search_model"
                                                class="form-control mySelect2">
                                            <option value='0'>Model</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-success ml-2" id="btn-reset-form">Reset form</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover table-bordered nowrap" id="skusTable">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Ref Sku</th>
                                <th>BTS Sku</th>
                                <th>Brand</th>
                                <th>Model</th>
                                <th>Kits Count</th>
                                <th>DMG Qty</th>
                                <th>Kits %</th>
                                <th>OC SKU</th>
                                <th>OC Qty</th>
                                <th>Version</th>
                                <th>Country Mfr</th>
                                <th>Open Cell</th>
                                <th>Main Board</th>
                                <th>T-Con Board</th>
                                <th>Power Supply</th>
                                <th>WiFi Module</th>
                                <th>IR Sensor</th>
                                <th>Button Set</th>
                                <th>Blutooth Module</th>
                                <th>Chasis</th>
                                <th>Product Version Number</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div id="comments" class="card mb-4 shadow-sm card-outline card-primary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12">
                                MasterSku Elements
                            </div>
                        </div>
                    </div>
                    <form id="formComments">
                        <div class="card-body">

                        </div>
                        <div class="card-footer">
                            <button type="submit" id="submit-form" class="btn btn-primary" disabled>Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.5.0/css/select.dataTables.min.css">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/jquery-datatables-checkboxes@1.2.13/css/dataTables.checkboxes.min.css"
          rel="stylesheet">

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
    <script
        src="https://cdn.jsdelivr.net/npm/jquery-datatables-checkboxes@1.2.13/js/dataTables.checkboxes.min.js"></script>

    <script src="{{ asset('js/masterSku.js') }}"></script>
    <script>
        let mSku = []
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let selBrand = '0'
        let selModel
        let headers = {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": token
        }

        $( document ).ready(function(e) {

            fetch('/master-sku/getSkusData', {
                method: 'POST',
                body: JSON.stringify({sku: '{{$id}}'}),
                headers:headers
            }).then(response=>{
                return response.json()
            }).then(data =>{
                console.log(data)
                // let options = "<option value='0'>Model</option>";
                // for (let i in data){
                //     options += '<option value="'+data[i].model+'">'+data[i].model+'</option>';
                // }
                // document.getElementById('search_model').innerHTML = options
            }).catch(error => console.log(error))

        });

        $skusTable = $('#skusTable').DataTable({
            pageLength: 100,
            lengthMenu: [
                [100, 500, 5000, -1],
                [100, 500, 5000, 'All']
            ],
            processing: true,
            serverSide: true,
            scrollY: "53vh",
            scrollX: true,
            scrollCollapse: true,
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
                    extend: 'pageLength',
                    titleAttr: 'Show Records',
                    className: 'btn btn-secondary buttons-collection dropdown-toggle buttons-colvis',
                }],
            },

            ajax: {
                url: "{{route('master-sku.getSkus')}}",
            },
            columns: [
                {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                {data: 'ref_sku', name: 'ref_sku'},
                {data: 'bts_sku', name: 'bts_sku'},
                {data: 'brand', name: 'brand'},
                {data: 'model', name: 'model'},
                {data: 'kits_count', name: 'kits_count'},
                {data: 'QtyDamageTV', name: 'QtyDamageTV'},
                {data: 'kits_percent', name: 'kits_percent'},
                {data: 'OCSKU', name: 'OCSKU'},
                {data: 'OCQty', name: 'OCQty'},
                {data: 'version', name: 'version'},
                {data: 'country_manufactured', name: 'country_manufactured'},
                {data: 'Open Cell', name: 'Open Cell'},
                {data: 'Main Board', name: 'Main Board'},
                {data: 'T-Con Board', name: 'T-Con Board'},
                {data: 'Power Supply', name: 'Power Supply'},
                {data: 'WiFi Module', name: 'WiFi Module'},
                {data: 'IR Sensor', name: 'IR Sensor'},
                {data: 'Button Set', name: 'Button Set'},
                {data: 'Blutooth Module', name: 'Blutooth Module'},
                {data: 'chasis', name: 'chasis'},
                {data: 'product_version_number', name: 'product_version_number'},
            ],
            columnDefs: [
                {
                    targets: 0,
                    checkboxes: {
                        selectRow: true,
                        className: 'larger'
                    },

                }, {
                    targets: [5],
                    searchable: false,
                }
            ],
            select: {
                style: 'multi'
            },
            order: [[1, 'asc']]
        });

        $skusTable.on('select', function (e, dt, type, indexes) {
            e.preventDefault()
            if (type === 'row') {
                const skuId = $skusTable.rows(indexes).data().pluck('ref_sku')[0]
                mSku.push(skuId);
                if(mSku.length === 1){
                    $('#search_brand').prop('disabled', true);
                    $('#search_model').prop('disabled', true);
                    $('#submit-form').prop('disabled',false)
                }

                let newRow = '<div class="form-row" id="skuRow'+skuId+'">' +

                    '<div class="col-2 mt-1">' +
                    '<label for="'+skuId + '" class="col-form-label">'+skuId+'</label>'+
                    '</div>' +
                    '<div class="col-9 mt-1">' +
                    '<input type="text" class="form-control" placeholder="Comment" name="' + skuId + '">' +
                    '</div>' +
                    // '<div class="col-1 mt-1">' +
                    // '<a href="#" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>'+
                    // '</div>' +
                    '</div>'




                $('#comments').find('.card-body').append(newRow)
            }

            // console.log(mSku)
            // console.log(dt.column(0).checkboxes.selected());

        })
        $skusTable.on('deselect', function (e, dt, type, indexes) {
            e.preventDefault()
            if (type === 'row') {
                const index = mSku.indexOf($skusTable.rows(indexes).data().pluck('ref_sku')[0]);
                if (index > -1) {
                    const remSKu=mSku[index]
                    mSku.splice(index, 1);
                    $('#comments').find('#skuRow'+remSKu).remove()

                }
            }
            console.log(mSku);

        })

        function addComments(skus) {

            $("#comments").find('.card-body').append(skus)
        }

        let formComments =  document.getElementById('formComments');

        $(document).on("keypress", "input", function (e) {
            var code = e.keyCode || e.which;
            if (code == 13) {
                e.preventDefault();
            }
        });

        document.getElementById('search_brand').addEventListener('change', (e)=>{
            e.preventDefault();
            selModel = document.getElementById('search_model');

            if (selModel.value !== '0' && selModel.value !== ''){
                $skusTable.columns([3,4]).search('').draw();
                selModel.value ='0';
            }


            fetch('/sku/getSKUModels', {
                method: 'POST',
                body: JSON.stringify({text: e.target.value}),
                headers:headers
            }).then(response=>{
                return response.json()
            }).then(data =>{
                let options = "<option value='0'>Model</option>";
                for (let i in data){
                    options += '<option value="'+data[i].model+'">'+data[i].model+'</option>';
                }
                document.getElementById('search_model').innerHTML = options
            }).catch(error => console.log(error))

            manageBrand($skusTable)
        })

        document.getElementById('btn-reset-form').addEventListener('click', (e)=>{
            document.getElementById('search_brand').selectedIndex = 0;
            document.querySelectorAll('#search_model option').forEach(o =>{if (o.value !=0){ o.remove()}});
            $skusTable.rows().deselect()
            $skusTable.columns([3,4]).search("").draw();
            mSku=[]
            $('#comments').find('.card-body').html('')
            $('#search_brand').prop('disabled', false);
            $('#search_model').prop('disabled', false);
            $('#submit-form').prop('disabled',true)
        });

        $('.mySelect2').select2({
            theme: 'bootstrap4',
            width: 'resolve'
        }).on('select2:select', function(e) {
            manageModel($skusTable)
        })

        window.onload = function (){
            $skusTable.columns().search("").draw();
        }


        document.getElementById('formComments').addEventListener('submit',async(e)=>{
            e.preventDefault()
            const fd = new FormData(e.target);
            let skuData = {};
            for (let [key, prop] of fd) {
                skuData[key] = prop;
            }
            const myData  = await manageData('/master-sku/store','POST',{'skus':skuData,'MSku':'{{$id}}'})
            console.log(myData.success)
            if(myData){
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: myData.success,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.replace("/master-sku");
                    }
                })
            }
            document.getElementById('btn-reset-form').click()

        })



    </script>
@stop

