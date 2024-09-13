@extends('adminlte::page')

@section('title', 'AddInv')

@section('content_header')
    <h1>Remove BoxContent</h1>
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
                        {{ __('Remove BoxContent')}}
                    </h3>
                    <div class="card-tools">
                        <button class="btn btn-info btn-sm" id="reset">Reset</button>
                    </div>
                </div>

                <div class="card-body" id="mainForm">
                    <h3>Pasos (Steps):</h3>
                    <ul>
                        <li>
                            Escanea el código QR de la CAJA .<br>
                            Scan the BOX QR
                        </li>
                        <li>
                            Escanea el código QR de la KIT para eliminarlo de la caja.<br>
                            Scan the KIT QR code to remove from box
                        </li>
                        <li>
                            Una vez hecho esto, escanee el QR de la Caja para eliminar los kits.<br>
                            Once done, scan the BOX Qr to delete all kits.
                        </li>
                    </ul>
                    <div class="row mb-3">
                        <div class="col-md-6">

                            <label for="el" class="col-form-label text-md-end">{{ __('Scan Box') }}</label>
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
        let box = {};
        let kits = []

        async function deleteData(url) {
            try {
                const response = await fetch(`${url}`, {
                    method: 'DELETE',
                    headers: headers,
                    body: JSON.stringify({data: kits}),
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

                    getKitData()

                    async function getKitData() {
                        if (!box.id)
                            await getData(myValue, '/validate/box').then(
                                data => {
                                    if (!data.errors) {
                                        box = {'id': data.id, 'name': data.name}
                                        addElementList(`Removing from box ${data.name}`)
                                    } else {
                                        addElementList(`Error: ${data.message}`)
                                    }
                                }
                            );
                        else {
                            if (myValue !== box.name) {
                                if (!kits.some(code => code.name === myValue)) {
                                    await getData(myValue, `/validate/kits/${box.id}`).then(
                                        data => {
                                            if(Object.keys(data).length !== 0){
                                                if (!data.errors) {
                                                    kits.push(data.KitID)
                                                    addElementList(`Remove kit ${data.KitLCN} from BOX${box.id}`)
                                                } else {
                                                    addElementList(`Error: ${data.message}`)
                                                }
                                            }else{
                                                addElementList(`Error: This Kit don't belong this Box`)
                                            }
                                        }
                                    );
                                } else {
                                    addElementList(`Msg: Kit already scanned.`)
                                }
                            } else {
                                if (kits.length < 1) {
                                    addElementList('Msg: Need to add kit first.')
                                } else {

                                    Swal.fire({
                                        title: `Are you sure?`,
                                        text: `Delete those kits`,
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Yes, delete it!'
                                    }).then((result) => {
                                        if (result.value) {
                                            deleteData(`/boxes/${box.id}`)
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


