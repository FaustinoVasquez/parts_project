@extends('adminlte::page')

@section('title', 'Edit Kit Orders')

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
                            <div class="col-sm border-right">
                                <div class="form-group row">
                                    <label for="orderNo" class="col-sm-2 col-form-label">Order#</label>
                                    <div class="col-sm-10">
                                        <input type="text" value="{{$kitOrder->order_id}}" class="form-control"
                                               name="orderNo" id="orderNo" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="orderRef" class="col-sm-2 col-form-label">Reference Order #</label>
                                    <div class="col-sm-10">
                                        <input type="id" value="{{$kitOrder->reforder_id}}" class="form-control"
                                               name="orderRef" id="orderRef">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group row">
                                    <label for="orderChannel" class="col-sm-2 col-form-label">Channel</label>
                                    <div class="col-sm-10">
                                        <input type="text" value="{{$kitOrder->channel}}" class="form-control"
                                               name="orderChannel" id="orderChannel" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="orderStatus" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                        <select name="orderStatus" id="orderStatus"
                                                class="form-control" required>
                                            @foreach ($status as $state)
                                                <option value="{{ $state->id }}"
                                                    {{ $kitOrder->order_status == $state->id ? 'selected':''}}>
                                                    {{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="mt-0">

                        <div class="row">
                            <div class="col-sm border-right">
                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>Sku/LCN</th>
                                        <th>Qty</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($kitOrder->kitOrderDetails as $detail)
                                        <tr>
                                            <td>{{$detail->kit_lcn}}{{$detail->ref_sku}}</td>
                                            <td class="text-center">{{$detail->qty}}</td>
                                        </tr>

                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm">
                                <input type="text" class="form-control mb-3" name="addlcn" id="addLcn"
                                       placeholder="Scan LCN">

                                <form name="lcnForm" id="lcnForm">
                                    <div class="row">
                                        <div class="col-lg-7" id="lcn_inputs">
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <button class="btn btn-success save-order">Save Order</button>
                                        <button class="btn btn-danger save-order">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('kitOrder.shared.kitOrderModal')
        @stop

        @section('css')
            <style>
                .verybigmodal {
                    max-width: 80%;
                }

                input[type=checkbox] {
                    width: 17px;
                    height: 17px;
                }

                .linea {
                    margin: 0px 20px;
                    width: 90px;
                    border-top: 1px solid #999;
                    position: relative;
                    top: 10px;
                    float: left;
                }

                .leyenda {
                    font-weight: bold;
                    float: left;
                }
            </style>
        @stop

        @section('js')
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="{{ asset('js/orderDetails.js') }}"></script>

        <script>

            let i=0
            const lcns =[<?php echo json_encode($kitLcns); ?>][0]
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            if(lcns){
                for (let j = 0; j < lcns.length; j++) {
                    addLCNToForm(lcns[j].kit_lcn)
                }

            }
            let headers = {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": token
            }
            window.addEventListener('load', function() {
                console.log('All assets are loaded')
                document.getElementById('addLcn').focus()
            })

            $("#addLcn").on('keyup', function (e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    i++
                    addLCNToForm( e.target.value)
                    e.target.value=''
                }
            });

            function addLCNToForm($value){
                i++
                $('#lcn_inputs').append(`<div class="d-flex flex-row mt-2">
                                                <input type="text" name=lcn[${i}] class="form-control" value="${$value}">
                                                <button  type="button" class="btn btn-danger btn-sm ml-2 remove-btn-row">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                             </div>`)

            }

            $(document).on('click','.remove-btn-row',function(e){
                e.preventDefault()
                const kitLCN = $(this).prev('input[type=text]').attr('value')
                deleteLCN(kitLCN)

                $(this).closest('div').remove();
                 $("#addLcn").focus()
            })

            async function deleteLCN(lcn){
                const myData  = await manageData('/kit-nukeLCN/{{$kitOrder->order_id}}','DELETE', {lcn})
            }


            document.getElementById('lcnForm').addEventListener('submit',async(e)=>{
                e.preventDefault()

                const fd = new FormData(e.target);
                let formData = {};
                for (let [key, prop] of fd) {
                    formData[key] = prop;
                }

                const refOrder= document.getElementById('orderRef').value
                const ordStatus = document.getElementById('orderStatus').value

                const myData  = await manageData('/kit-orderLCN/{{$kitOrder->order_id}}','PATCH', {formData,refOrder,ordStatus})


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
