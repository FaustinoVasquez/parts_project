@extends('adminlte::page')

@section('title', 'Box to Shelf')

@section('content_header')
    <h1>Add Box to Shelf</h1>
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

            <div class="card card-outline card-primary">
                <div class="card-header ">
                    <h3 class="card-title mt-1">
                        {{ __('Add Box to Shelf ') }}
                    </h3>
                    <div class="card-tools">
                        <button class="btn btn-info btn-sm" id="reset">Reset</button>
                    </div>
                </div>

                <div class="card-body" id="mainForm">

                    <h3>Pasos (Steps):</h3>
                    <ul>
                        <li>
                            Escanea el código QR de SHELF para agregar CAJAS.<br>
                            Scan the SHELF QR code to add BOXEs
                        </li>
                        <li>
                            Escanea el código QR de la CAJA para añadirlo al SHELF.<br>
                            Scan the BOX QR code to add it to the SHELF
                        </li>
                        <li>
                            Una vez hecho esto, escanee el SHELF para cerrar Proceso.<br>
                            Once done, scan the SHELF to close the SHELF.
                        </li>
                    </ul>

                    <div class="row mb-3">
                        <div class="col-md-6">

                            <label for="el" class="col-form-label text-md-end">{{ __('Scan') }}</label>
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

    <script>
        let aux = '';
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let headers = {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": token
        }

        async function postData(boxes, url) {
            try {
                const response = await fetch(`${url}`, {
                    method: 'PUT',
                    body: JSON.stringify({
                        boxes: boxes
                    }),
                    headers: headers
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
                    body: JSON.stringify({
                        data: value
                    }),
                    headers: headers
                })
                const data = await response.json()
                return data

            } catch (err) {
                console.log(err);
                addElementList(`Error: ${err}`)
            }
        }


        let shelf={};
        let boxes = []

        document.querySelector('input[name="el"]').addEventListener("keyup", (e) => {
            // SHELF10000   BOX10001  BOX10002  BOX10003
            let myValue = e.target.value;

            if (e.key === "Enter") {
                getShelfData()
                async function getShelfData() {
                    if (Object.keys(shelf).length === 0)
                        await getData(myValue, '/validate/shelf').then(
                            data => {
                                if (!data.errors) {
                                    shelf={
                                        'shelf_id':data.shelf_id,
                                        'shelf_name':data.shelf_name
                                    }
                                    addElementList(`Adding ${shelf.shelf_name}`)
                                } else {
                                    addElementList(`Error: ${data.message}`)
                                }
                            }
                        );
                    else {
                        if (myValue !== shelf.shelf_name) {
                            if (!boxes.some(code => code.box_name === myValue)) {
                                await getData(myValue, '/validate/boxes').then(
                                    data => {
                                        if (!data.errors) {
                                            boxes.push({
                                                'box_id':data.box_id,
                                                'box_name':data.box_name
                                            })
                                            addElementList(`Adding to ${data.box_name}`)
                                        } else {
                                            addElementList(`Error: ${data.message}`)
                                        }
                                    }
                                );
                            }else{
                                addElementList(`Msg: Box already scanned.`)
                            }
                        }else{
                            if (boxes.length < 1) {
                                 addElementList('Msg: Need to add box first.')
                            } else {
                                addElementList('msg: Processing...')
                                await postData(boxes, `boxShelf/${shelf.shelf_id}`).then(
                                    data => {
                                        if (!data.errors) {
                                            addElementList(`Msg: ${data}`)
                                        } else {
                                            addElementList(`Error: ${data.errors}`)
                                        }
                                    }
                                )
                                await new Promise(r => setTimeout(r, 1000));
                                location.reload();
                            }
                        }
                    }
                }
            }
        });


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
