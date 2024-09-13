@extends('adminlte::page')
@section('title', 'Kits Creation')

@section('content_header')
    <h4>Open Cell Configuration: {{$ocConfig["id"]}}</h4>
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
                            <button class="btn btn-danger" id="deleteOcConf" >Delete Configuration</button>
                            <button class="btn btn-success" id="enableUpdate" >Enable For Editing</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <form name="showForm" role="form" method="POST" id="showForm" action="{{route('oc.store')}}">
                            @csrf

                            <div class="form-group row">
                                <label for="brand" class="col-sm-2 col-form-label">Brand</label>
                                <div class="col-sm-10">
                                    <input name="brand" class="form-control" id="brand" value="{{$ocConfig["Brand"]}}" readonly/>
                                    <span class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="model" class="col-sm-2 col-form-label">Model</label>
                                <div class="col-sm-10">
                                    <input name="model" class="form-control" id="model" value="{{$ocConfig["Model"]}}" readonly/>
                                    <span class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>

                            <hr/>
                            <h5>OC Details</h5>

                            <div class="form-group row">
                                <label for="partNumber" class="col-sm-2 col-form-label">Part Number</label>
                                <div class="col-sm-10">
                                <select name="partNumber" aria-label="select model" id="partNumber"
                                        class=" form-control " readonly>
                                    <option value="{{$ocConfig["OC_PartNumberID"]}}">{{$ocConfig["OC_PartNumber"]}}</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="manufacturer" class="col-sm-2 col-form-label">Manufacturer</label>
                                <div class="col-sm-10">
                                    <input name="manufacturer" class="form-control" id="manufacturer" value="{{$ocConfig["OC_Manufacturer"]}}" readonly/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="QOH" class="col-sm-2 col-form-label">QOH</label>
                                <div class="col-sm-10">
                                    <input name="QOH" class="form-control" id="QOH" value="{{$ocConfig["Qty"]}}" readonly/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mitSku" class="col-sm-2 col-form-label">MITSKU</label>
                                <div class="col-sm-10">
                                    <select name="mitSku" aria-label="select model" id="mitSku"
                                            class=" form-control " disabled>
                                        <option value="">MITSKU</option>
                                        @foreach ($mitSkus as $mitsku)
                                            <option value="{{ $mitsku->MITSKU }}"
                                                {{ old('mitSku',$mitsku->MITSKU)==$ocConfig["OC_MITSKU"] ? 'selected':''}}>
                                                {{ $mitsku->ProductSKU }}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>

                            <hr/>
                            <h5>Assembly Details</h5>
                            <div class="form-group row">
                                <label for="instructions" class="col-sm-2 col-form-label">Instructions</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="instructions" id="instructions" rows="3" disabled>{{$ocConfig["notes"]}}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="attachments" class="col-sm-2 col-form-label">Link</label>
                                <div class="col-sm-10 mt-2">
                                    <a href="{{$ocConfig["attachments"]}}">{{$ocConfig["attachments"]}}</a>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="assemblyGuide" class="col-sm-2 col-form-label">Assembly Guide</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="assemblyGuide" class="custom-file-input"
                                                   id="assemblyGuide" aria-describedby="assemblyGuide" disabled>
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
                                <button type="submit" id="btnOCUpdate" class="btn btn-primary mb-4 btn-block" disabled>Update Oc configuration
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 ">
                <div class="card shadow-sm card-outline card-primary">
                    <div class="card-header ">
                        <h3 class="card-title mt-2 days">
                            {{ __('Accessories Data')}}

                        </h3>
                        <button type="button" id="btnOCAccessories" class="btn btn-primary ml-2" disabled>Add
                            Accessories
                        </button>
                        <div class="card-tools">
                            <div class="row">
                                <div class="col mt-2 text-right">
                                    <h5>Id Conf:</h5>

                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" name="idOCConfig" id="idOCConfig" value="{{$ocConfig["id"]}}"
                                           readonly>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">

                        <div>
                            <table class="table table-striped table-hover table-bordered nowrap" id="OCAccessoriesTable">
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

@stop

@section('js')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset('js/OCShow.js')}}"></script>


    <script>
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let OcConfigId ="{{$ocConfig["id"]}}"
        let $OCAccessoriesTable
        let isDisabled = 0
        let headers = {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": token
        }

        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

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
                dom: 'rt',
                ajax: {
                    url: "/oc/accessories",
                    data: function (d) {
                        d.OcConfigId = {{$ocConfig["id"]}};
                        d.isDisabled= isDisabled
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
                ],
            })

        });


        $('#mitSku').select2({
            theme: 'bootstrap4',
        }).on('select2:select', function () {
            $('#instructions').focus()
        })

        /////// MODAL////////
        let $mitSKU = $('#aMitSKU')
        let $aPartName= $('#aPartName')
        let $aQtyRequired = $("#aQtyRequired")
        let $aNotes = $("#aNotes")

        $(document).on('click', '#btnOCAccessories', function (e) {
            $('#ocAccModal')
                .on('shown.bs.modal', function () {
                    $('#ocId').val({{$ocConfig["id"]}})
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

        $(document).on('select2:open', (e) => {
            const selectId = e.target.id;
            $(".select2-search__field[aria-controls='select2-" + selectId + "-results']").each(function (key, value,) {
                value.focus();
            });
        });

    </script>

@stop
