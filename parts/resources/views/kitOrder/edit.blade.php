@extends('adminlte::page')

@section('title', 'Kit Orders details')

@section('content_header')
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
                            Kit Orders Details
                        </h3>
                        <div class="card-tools">
                            <b>Order Date:</b> {{date('m/d/Y H:i:s', strtotime($kitOrder->created_at))}}
                        </div>
                    </div>

                    <div class="card-body">
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="form-group row">
                                            <label for="orderNo" class="col-sm-2 col-form-label">Order#</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{$kitOrder->order_id}}" class="form-control" name="orderNo" id="orderNo" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="orderRef" class="col-sm-2 col-form-label">Reference Order #</label>
                                            <div class="col-sm-10">
                                                <input type="id" value="{{$kitOrder->reforder_id}}" class="form-control" name="orderRef" id="orderRef">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="form-group row">
                                            <label for="orderStatus" class="col-sm-2 col-form-label">Status</label>
                                            <div class="col-sm-10">
                                                <input type="text"  value="{{$kitOrder->order_status}}" class="form-control" name="orderStatus"  id="orderStatus" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="orderChannel" class="col-sm-2 col-form-label">Channel</label>
                                            <div class="col-sm-10">
                                                <select name="orderChannel" id="orderChannel"
                                                        class="form-control">
                                                        <option value="Wholesale Order">Wholesale Order</option>
                                                        <option value="Internal Order">Internal Order</option>
                                                        <option value="Manual Order">Manual Order</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                            <div class="d-flex justify-content-end">

                                <div class="form-check form-check-inline">

                                    <input class="form-check-input" type="radio" name="optionType" id="optionType1" value="sku" checked="checked">
                                    <label class="form-check-label" for="optionType1">SKU</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="optionType" id="optionType2" value="lcn">
                                    <label class="form-check-label" for="optionType2">LCN</label>
                                </div>

                                <button class="btn btn-primary" type="button" id="addOrderDetails" ><i class="fa fa-plus"></i> AddItems</button>
                            </div>

                        <form name="orderDetailsForm" role="form" method="POST" id="orderDetailsForm" action="">
                            <table class="table mt-2" id="orderDetailsTable">
                                <tr>
                                    <th scope="col">SKU/LCN</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Action</th>
                                </tr>

                            </table>
                                <input type="submit" id="submitButton" class="btn btn-primary" value="Submit Order" disabled="disabled" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('kitOrder.shared.kitOrderModal')
@stop

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
    <script src="{{ asset('js/orderDetails.js') }}"></script>

    <script>


    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let headers = {
        "Content-Type": "application/json",
        "Accept": "application/json, text-plain, */*",
        "X-Requested-With": "XMLHttpRequest",
        "X-CSRF-TOKEN": token
    }

    function checkSelectedOption() {
            const radios = document.getElementsByName("optionType");
            let selectedOption = "";
            for (let i = 0; i < radios.length; i++) {
                if (radios[i].checked) {
                    selectedOption = radios[i].value;
                    break;
                }
            }
            return selectedOption
        }

    let i=0;
    $('#addOrderDetails').click(function(){
         let res = checkSelectedOption()
             if(res==='lcn'){
                 lcn()
             }else{
                 sku()
             }
    })

    $(document).on('click','.remove-table-row',function(){
      $(this).parents('tr').remove();
    })


    document.getElementById('orderDetailsForm').addEventListener('submit',async(e)=>{
        e.preventDefault()

        const fd = new FormData(e.target);
        let formData = {};
        for (let [key, prop] of fd) {
            formData[key] = prop;
        }

        const refOrder= document.getElementById('orderRef').value
        const orderChannel = document.getElementById('orderChannel').value
        const myData  = await manageData('/kit-order/{{$kitOrder->order_id}}','PATCH', {formData,refOrder,orderChannel})


        if(myData){
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: myData.success,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace("/kit-order");
                }
            })
        }

    })



    </script>

@stop
