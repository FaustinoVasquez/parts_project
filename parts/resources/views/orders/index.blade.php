@extends('adminlte::page')

@section('title', 'Kit Orders')

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
                            <div class=" form-inline">
                                <label for="kitLcn">Scan LCN: </label>
                                <input type="text" class="form-control" name="kitLcn" id="kitLcn"/>
                            </div>
                        </h3>


                    </div>

                    <div class="card-body">



                            <table class="table table-striped table-hover table-bordered" id="kitOrdersTable">
                                <thead>
                                <tr>
                                    <th>Scanned LCN</th>
                                    <th>Order ID</th>
                                    <th>SKU/LCN</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    <div class="card-footer">
                        <button id="submit-btn" class="btn btn-primary" disabled="disabled">Save</button>
                        <button id="cancel-btn" class="btn btn-danger" >Cancel</button>
                    </div>

                </div>
                <div class="card">
                    <div class="card-body">

                <table class=" table table-striped table-hover table-bordered nowrap" id="kitOrderLCNs">
                    <thead>
                    <tr>
                        <th>OrderID</th>
                        <th>Channel</th>
                        <th>RefOrderId</th>
                        <th>OrderStatus</th>
                        <th>FullFillBy</th>
                        <th>FullFillAt</th>
                        <th>ScannedLCN</th>
                        <th>ScannedAt</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                    </div>
                </div>
            </div>
        </div>

        {{--    @include('kitOrder.shared.kitOrderModal')--}}
        @stop

        @section('css')
            <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
            <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.css">
        @stop

        @section('js')
            <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
            <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.js"></script>
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>

               window.addEventListener("beforeunload",()=>{
                   console.log("cerrando el navegador")
                   let data = $tableRef
                       .rows()
                       .data().toArray();
                   const arrayData = data.map((item)=>[item[1],item[2],item[3]])
                   if(data.length>0){
                       deleteRows(arrayData)
                       console.log('si hay datos')

                   }else{
                       console.log("No hay datos")
                   }
                   // debugger;
                   // window.open('http://ionicframework.com', '_blank')
               })

               async function deleteRows(arrayData){
                   const url ="{{route('orders.deleteAllLCN')}}"
                   const res = await deleteData(arrayData, url)
                   console.log(res)
                   return true
               }

                let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let kitOrders=[]
                let deleteBtn = ''


                let $tableLCN = $('#kitOrderLCNs').DataTable({
                    order: [[7, 'desc']],
                    pageLength: 100,
                    processing: true,
                    serverSide: true,
                    scrollY: "30vh",

                    dom: 'Brftip',
                    ajax: {
                        url: "{{route('order-Fulfillment.index')}}",
                    },
                    columns: [
                        {data: 'order_id',name:'order_id'},
                        {data: 'channel',name:'channel'},
                        {data: 'reforder_id',name:'reforder_id'},
                        {data: 'order_status',name:'order_status'},
                        {data: 'fulfill_by',name:'fulfill_by'},
                        {data: 'fulfilled_at',name:'fulfilled_at'},
                        {data: 'Scanned LCN',name:'Scanned LCN'},
                        {data: 'Scanned At',name:'Scanned At'},
                    ],

                })

                let $tableRef = $('#kitOrdersTable').DataTable({
                    pageLength: 200,
                    dom: 'Brtip',
                })
                // let tableRef = DataTable()
                let headers = {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token
                }

                const inputLCN = document.getElementById("kitLcn");

                window.onload = function () {
                    inputLCN.focus();
                }

                async function getData(value){
                    try {
                        const response = await fetch("{{route('orders.getLCN')}}", {
                            method: 'POST',
                            body:JSON.stringify({lcn: value}),
                            headers: headers
                        })
                        const data = await response.json()
                        return data
                    } catch (err) {
                        console.log("Error:",err)
                    }
                }

                async function deleteData(order, url){
                    try {
                        const response = await fetch(url, {
                            method: 'DELETE',
                            body:JSON.stringify(order),
                            headers: headers
                        })
                        const data = await response.json()
                        return data
                    } catch (err) {
                        console.log("Error:",err)
                    }
                }

                async function postData(order){
                    try {
                        const response = await fetch("{{route('orders.postLCNs')}}", {
                            method: 'POST',
                            body:JSON.stringify(order),
                            headers: headers
                        })
                        const data = await response.json()
                        return data
                    } catch (err) {
                        console.log("Error:",err)
                    }
                }

                inputLCN.addEventListener('keyup',async (e)=>{
                      e.preventDefault();
                    if (e.key === 'Enter' || e.keyCode === 13) {
                        if(!kitOrders.includes(e.target.value)){
                            const res = await getData(e.target.value)
                            if(res){
                                kitOrders.push(e.target.value)
                                console.log(kitOrders)
                                $tableRef.row.add([
                                    e.target.value,
                                    res.order_id,
                                    res.ref_sku,
                                    res.sku_optiontype,
                                   `<button class="btn btn-danger delete-btn"><i class="fas fa-trash-alt"></i></button>`,
                            ]).draw()
                                document.getElementById('submit-btn').removeAttribute("disabled");
                                $tableLCN.ajax.reload()
                            }else{
                                orderError("No Information")
                                console.log($tableRef)
                            }
                        }
                        e.target.value=''
                    }
                })


                $(document).on('click', '.delete-btn', function  (e) {
                    e.preventDefault()
                    let $tr = $(this).parents('tr');
                    let row = $tableRef.row($tr).data();
                    let lcn = row[0]
                    let url = "{{route('orders.deleteLCN')}}"
                    let order = {
                        'orderID': row[1],
                        'skuLCN': row[2],
                        'type': row[3],
                    }

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            const res = await deleteData(order,url)
                            if(res){
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                                kitOrders = kitOrders.filter(item=>item !== lcn)
                                $tableRef.row( $tr ).remove().draw()
                                $tableLCN.ajax.reload()
                                console.log(kitOrders)
                            }else{
                                Swal.fire(
                                    'Error!',
                                    'Something happen!.',
                                    'error'
                                )
                            }
                        }
                    })
                });

                $(document).on('click', '#submit-btn', async function  (e){
                    let data = $tableRef
                        .rows()
                        .data().toArray();
                    const arrayData = data.map((item)=>[item[0],item[1]])
                    const res = await postData(arrayData)
                    if(res){
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'The information has been saved',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        })
                    }

                  console.log(res)
                })

                $(document).on('click', '#cancel-btn', async function  (e){
                    let data = $tableRef
                        .rows()
                        .data().toArray();
                    const arrayData = data.map((item)=>[item[1],item[2],item[3]])
                    const url ="{{route('orders.deleteAllLCN')}}"

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            const res = await deleteData(arrayData, url)
                            if(res){
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                                if ( window.history.replaceState ) {
                                    window.history.replaceState( null, null, window.location.href );
                                }
                                window.location = window.location.href;
                            }else{
                                Swal.fire(
                                    'Error!',
                                    'Something happen!.',
                                    'error'
                                )
                            }
                        }
                    })



                        // Swal.fire({
                        //     icon: 'success',
                        //     title: 'Success',
                        //     text: 'the information has been successfully removed',
                        //     confirmButtonText: 'OK'
                        // }).then((result) => {
                        //     if (result.isConfirmed) {
                        //         if ( window.history.replaceState ) {
                        //             window.history.replaceState( null, null, window.location.href );
                        //         }
                        //         window.location = window.location.href;
                        //         // window.location.reload(true);
                        //     }
                        // })

                })





                function orderSuccess(message){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Error',
                        text: message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
                function orderError(message){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'warning',
                        title: 'Error',
                        text: message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }


            </script>

@stop

