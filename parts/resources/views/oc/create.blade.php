@extends('adminlte::page')
@section('title', 'Kits Creation')

@section('content_header')
    <div class="row">
        <div class="col-md-12 d-flex">
            <h3 id="quote">Open Cell Configuration</h3>
            <button type="button" id="resetAndContinue" class="btn btn-primary ml-auto">Next Configuration</button>
        </div>
    </div>
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
            <div class="col-lg-6 ">
                <div class="card shadow-sm card-outline card-primary">
                    <div class="card-header ">
                        <h3 class="card-title mt-1 days">
                            {{ __('Open Cell Configuration')}}
                        </h3>
                        <div class="card-tools">
                            <button class="btn btn-success" id="enableUpdate" disabled>Enable For Editing</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <form name="accForm" role="form" method="POST" id="accForm" action="{{route('oc.store')}}">
                            @csrf
                            <div class="form-group row">
                                <label for="brand" class="col-sm-2 col-form-label">Brand</label>
                                <div class="col-sm-10">
                                    <select name="brand" aria-label="select brand" id="brand"
                                            class="form-control">
                                        <option value="">Brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->brand }}"
                                                {{ old('brand') ? 'selected':''}}>
                                                {{ $brand->brand }}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="model" class="col-sm-2 col-form-label">Model</label>
                                <div class="col-sm-10">
                                    <select name="model" aria-label="select model" id="model"
                                            class=" form-control modelSelect2">
                                        <option value="">Model</option>
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>

                            <hr/>

                            <table class="table table-striped table-hover table-bordered nowrap" id="openCells">
                                <thead>
                                <tr>
                                    <th>CID</th>
                                    <th>Manuf</th>
                                    <th>PN</th>
                                    <th>MITSKU</th>
                                    <th>QOH</th>
                                </tr>
                                </thead>
                            </table>

                            <hr/>

                            <div class="form-group row">
                                <label for="partNumber" class="col-sm-2 col-form-label">Part Number</label>
                                <div class="col-sm-10">
                                    <select name="partNumber" aria-label="select model" id="partNumber"
                                            class=" form-control">
                                        <option value="">PartNumber</option>
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="manufacturer" class="col-sm-2 col-form-label">Manufacturer</label>
                                <div class="col-sm-10">
                                    <input type="text" name="manufacturer" class="form-control" id="manufacturer"
                                           placeholder="Manufacturer" readonly>
                                </div>
                                <span class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                            </div>

                            <div class="form-group row">
                                <label for="mitSku" class="col-sm-2 col-form-label">MITSKU</label>
                                <div class="col-sm-10">
                                    <select name="mitSku" aria-label="select model" id="mitSku"
                                            class=" form-control ">
                                        <option value="">MITSKU</option>
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="instructions" class="col-sm-2 col-form-label">Instructions</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="instructions" id="instructions"
                                              rows="3"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="assemblyGuide" class="col-sm-2 col-form-label">Assembly Guide</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="assemblyGuide" class="custom-file-input"
                                                   id="assemblyGuide" aria-describedby="assemblyGuide">
                                            <label class="custom-file-label" for="assemblyGuide">Select file</label>
                                        </div>
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="button" id="assemblyGuideRemove">Remove</button>
                                    </div>
                                    </div>
                                    <span class="invalid-feedback" role="alert">
                                          <strong></strong>
                                    </span>
                                </div>
                            </div>

                            <div>
                                <button type="submit" id="btnOCConfig" class="btn btn-primary mb-4 btn-block">Submit
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 ">
                <div class="card shadow-sm card-outline card-primary">
                    <div class="card-header ">
                        <h3 class="card-title mt-1 days">
                            {{ __('Accessories Data')}}
                        </h3>
                        <div class="card-tools">
                            <div class="row">
                                <div class="col mt-2 text-right">
                                    <h5>Id Conf:</h5>
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" name="idOCConfig" id="idOCConfig"
                                           readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div>
                            <button type="button" id="btnOCAccessories" class="btn btn-primary mb-4" disabled>Add
                                Accessories
                            </button>
                            <table class="table table-striped table-hover table-bordered nowrap"
                                   id="OCAccessoriesTable">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Part Name</th>
                                    <th>MITSKU</th>
                                    <th>Qty Req</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('oc.shared.OCAccessoriesModal')
@endsection


@section('css')

    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.css"/>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet"/>

@stop

@section('js')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset('js/OCCreate.js')}}"></script>

    <script>
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let $openCells
        let $OCAccessoriesTable
        let $componentsTable
        let OcConfigId=null
        let headers = {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": token
        }
        <?php $myVar = 'OcConfigId';?>

        $(document).ready(function () {


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $openCells = $('#openCells').DataTable({
                order: [[0, 'desc']],
                pageLength: 100,
                lengthMenu: [
                    [100, 500, -1],
                    [100, 500, 'All']
                ],
                processing: true,
                serverSide: true,
                scrollY: "20vh",
                // scrollX: true,
                scrollCollapse: true,
                stateSave: true,
                dom: 'rt',
                ajax: {
                    url: "/oc/getOCList",
                    data: function (d) {
                        d.brand = $('select[name=brand]').val();
                        d.model = $('select[name=model]').val();
                    },
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'OC_Manufacturer', name: 'OC_Manufacturer'},
                    {data: 'OC_PartNumber', name: 'OC_PartNumber'},
                    {data: 'OC_MITSKU', name: 'OC_MITSKU'},
                    {data: 'QOH', name: 'QOH'},
                ],
                columnDefs: [
                    {
                        targets: [0],
                        searchable: true,
                        // visible: false,
                    },
                ]

            })
            $OCAccessoriesTable = $('#OCAccessoriesTable').DataTable({
                order: [[0, 'desc']],
                pageLength: 100,
                lengthMenu: [
                    [100, 500, -1],
                    [100, 500, 'All']
                ],
                processing: true,
                serverSide: true,
                scrollY: "53vh",
                scrollX: true,
                scrollCollapse: true,
                stateSave: true,
                autoWidth:false,
                dom: 'rt',
                ajax: {
                    url: "/oc/accessories",
                    data: function (d) {
                        d.OcConfigId = OcConfigId;
                        d.isDisabled=1
                    },
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'part_name', name: 'part_name'},
                    {data: 'ProductSKU', name: 'ProductSKU'},
                    {data: 'qty_required', name: 'qty_required'},
                    {data: 'Notes', name: 'Notes'},
                    {data: 'actions', name: 'actions'},
                ],
                columnDefs: [
                    {
                        targets: [0],
                        searchable: true,
                        // visible: false,
                    },
                ]

            })
        });


        $('#brand').select2({
            theme: 'bootstrap4',
        }).on("change", function () {
            getModelFromBrand($(this).val());
        }).on('select2:select', function () {
            $('#model').focus()
        }).focus()

        $('#model').select2({
            theme: 'bootstrap4',
        }).on("change", function () {
            $openCells.ajax.reload()
            getPNFromModel($(this).val());
        }).on('select2:select', function () {
            $('#partNumber').focus()
        })

        $('#partNumber').select2({
            theme: 'bootstrap4',
        }).on("change", function () {
            getSKUsFromPartNumber($(this).val());
            getManufacturerFromPartNumber($(this).val());

        }).on('select2:select', function () {
            $('#mitSku').focus()
        })

        $('#mitSku').select2({
            theme: 'bootstrap4',
        }).on("change", function () {
             clearForm(4)
        }).on('select2:select', function () {
            $('#instructions').focus()
        })

        let $mitSKU = $('#aMitSKU')
        let $aPartName= $('#aPartName')
        let $aQtyRequired = $("#aQtyRequired")
        let $aNotes = $("#aNotes")

        $(document).on('click', '#btnOCAccessories', function (e) {
            $('#ocAccModal')
                .on('shown.bs.modal', function () {
                    $('#ocId').val(OcConfigId)

                    getMPartName()
                    $aPartName.select2({theme: 'bootstrap4'})
                    $mitSKU.select2({theme: 'bootstrap4'})
                    $aQtyRequired.keydown(function(e){
                        if(e.keyCode === 13) {
                            e.preventDefault();
                            $aNotes.focus()
                            return false;
                        }
                    })

                }).on('hidden.bs.modal', function () {
                $mitSKU.html('<option value="">MITSKU</option>')
                $('#accDataForm').trigger("reset");
            }).modal('show');
        })

        $aPartName.on("change", function (e) {
            getMitSKUFromPartName($(this).val());
        }).on('select2:select', function () {
            $mitSKU.focus()
        })

        $mitSKU.on('select2:select', function () {
            $aQtyRequired.focus()
        })


        $(document).on('select2:open', (e) => {
            const selectId = e.target.id;
            $(".select2-search__field[aria-controls='select2-" + selectId + "-results']").each(function (key, value,) {
                value.focus();
            });
        });

        $(document).keypress(
            function(event){
                if (event.which === '13') {
                    event.preventDefault();
                }
            });
    </script>

    <script>
        document.querySelector('.custom-file-input').addEventListener('change', function (e) {
            let name = document.getElementById("assemblyGuide").files[0].name;
            let nextSibling = e.target.nextElementSibling
            nextSibling.innerText = name
        })
        document.querySelector('#assemblyGuideRemove').addEventListener('click',(e)=> {
            const selectedFile = document.querySelector(".custom-file-input")
            selectedFile.value = ""
            selectedFile.nextElementSibling.innerText = ""
            selectedFile.nextElementSibling.innerText = "Select a file"
        })


        document.getElementById('resetAndContinue').addEventListener('click', (e) => {
            window.location.href = '/oc'; //relative to domain
        })

    </script>

@stop
