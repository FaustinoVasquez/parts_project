@extends('adminlte::page')

@section('title', 'AddInv')

@section('content_header')
    <h1>Remove Shelf Content</h1>
@stop

@section('content')

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </div>
    @endif

    @if (session('danger'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('danger') }}
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </div>
    @endif


    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card">
                <div class="card-header ">
                    <h3 class="card-title mt-1">
                        {{ __('Remove Shelf Content')}}
                    </h3>
                    <div class="card-tools">
                        <button class="btn btn-info btn-sm" id="reset">Reset</button>
                    </div>
                </div>

                <div class="card-body" id="mainForm">
                    <h3>Pasos (Steps):</h3>
                    <ul>
                        <li>
                            Escanea el código QR del SHELF .<br>
                            Scan the SHELF QR
                        </li>
                        <li>
                            Escanea el código QR de la CAJA para eliminarla del SHELF.<br>
                            Scan the BOX QR code to remove from SHELF
                        </li>
                        <li>
                            Una vez hecho esto, escanee el QR de la SHELF para eliminar las CAJAS .<br>
                            Once done, scan the SHELF Qr to delete all BOXES.
                        </li>
                    </ul>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="el" class="col-form-label text-md-end">{{ __('Scan shelf') }}</label>
                            <input id="el" type="text" class="form-control" name="el" autofocus>
                            <div class="mt-2">
                                <ul id="message"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')

@stop

@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let aux = '';
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let headers = {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": token
        }
        let shelf = {};
        let boxes = []

        async function deleteData(url) {
            try {
                const response = await fetch(`${url}`, {
                    method: 'DELETE',
                    headers: headers,
                    body: JSON.stringify({data: boxes}),
                })

                const data = await response.json()
                return data
            } catch (err) {
                console.log(err);
                addElementList(`Error: ${err}`)
            }
        }


        async function getData(value, url) {
            try {
                const response = await fetch(`${url}`, {
                    method: 'POST',
                    body: JSON.stringify({data: value}),
                    headers: headers
                })
                const data = await response.json()
                return data

            } catch (err) {
                console.log(err);
                addElementList(`Error: ${err}`)
            }
        }



        document.querySelector('input[name="el"]').addEventListener("keyup", (e) => {

            let myValue = e.target.value;

            if (e.key === "Enter") {

                getShelfData()

                async function getShelfData() {
                    if (!shelf.id)
                        await getData(myValue, '/validate/shelf').then(
                            data => {
                                if (!data.errors) {
                                    shelf = {'id': data.shelf_id, 'name': data.shelf_name}
                                    addElementList(`Removing from shelf ${data.shelf_name}`)
                                } else {
                                    addElementList(`Error: ${data.message}`)
                                }
                            }
                        );
                    else {
                        if (myValue !== shelf.name) {
                            if (!boxes.some(code => code.name === myValue)) {
                                await getData(myValue, `/validate/shelfBox/${shelf.id}`).then(
                                    data => {
                                        if(Object.keys(data).length !== 0){
                                            if (!data.errors) {
                                                boxes.push({'id':data.id,'name':data.name})
                                                addElementList(`Remove box ${data.name} from shelf ${shelf.name}`)
                                            } else {
                                                addElementList(`Error: ${data.message}`)
                                            }
                                        }else{
                                            addElementList(`Error: This Box don't belong this Shelf`)
                                        }
                                    }
                                );
                            } else {
                                addElementList(`Msg: Box already scanned.`)
                            }
                        } else {
                            if (boxes.length < 1) {
                                addElementList('Msg: Need to add BOX first.')
                            } else {

                                Swal.fire({
                                    title: `Are you sure?`,
                                    text: `Delete those box`,
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, delete it!'
                                }).then((result) => {
                                    if (result.value) {
                                        deleteData(`boxShelf/${shelf.id}`)
                                        addElementList('msg: Processing...')
                                        reloadPage()
                                    }
                                });

                                // await new Promise(r => setTimeout(r, 1000));
                                // location.reload();
                            }
                        }
                    }
                }

            }
        });

        async function reloadPage(){
            await new Promise(r => setTimeout(r, 1000));
            location.reload();
        }


        function addElementList(content) {
            const ul = document.getElementById("message");
            const li = document.createElement("li");
            li.appendChild(document.createTextNode(content));
            ul.appendChild(li);
            document.getElementById('el').value = ''
            document.getElementById('el').focus()
        }


        document.getElementById('reset').addEventListener("click", (e) => {
            location.reload();
        });


    </script>
@stop



