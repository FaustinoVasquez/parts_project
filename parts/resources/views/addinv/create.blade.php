@extends('adminlte::page')

@section('title', 'AddInv')

@section('content_header')
    <h1>Add KIT to BOX</h1>
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

            <div class="card card-outline card-warning">
                <div class="card-header ">
                    <h3 class="card-title mt-1">
                        {{ __('Add Kit To Box ')}}
                    </h3>
                    <div class="card-tools">
                        <button class="btn btn-info btn-sm" id="reset">Reset</button>
                    </div>
                </div>

                <div class="card-body" id="mainForm">

                       <h3>Pasos (Steps):</h3>
                    <ul>
                        <li>
                            Escanea el código QR de la caja para agregar kits.<br>
                            Scan the box QR code to add kits
                        </li>
                        <li>
                            Escanea el código QR del KIT para añadirlo a la caja.<br>
                            Scan the KIT QR code to add it to the box
                        </li>
                        <li>
                            Una vez hecho esto, escanee la caja para cerrar la caja.<br>
                            Once done, scan the box to close the box.
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
        let aux='';
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let headers = {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": token
        }

        async function postData(box,kits){
            try {
            const response = await fetch('/add-inv',{
                method: 'POST',
                body: JSON.stringify({box:box.id,kits:kits}),
                headers:headers
            })

                const data = await response.json()
                return data
            }
            catch(err) {
                console.log(err);
                addElementList(`Error: ${err}`)
            }
        }


        async function getData(value,url){
            try {
                const response = await fetch(`${url}`,{
                    method: 'POST',
                    body: JSON.stringify({data:value}),
                    headers:headers
                })
                const data = await response.json()
                return data

            }
            catch(err) {
                console.log(err);
                addElementList(`Error: ${err}`)
            }
        }


        let box = {};
        let kits =[]

        document.querySelector('input[name="el"]').addEventListener("keyup", (e) => {
            // BOX10016   MTC68T0573-KIT  MTC8UT0197-KIT  MTBACT0284-KIT  MTC7ST0799-KIT
            let myValue = e.target.value;


            if (e.key === "Enter") {

                getKitData()
                async function getKitData() {
                    if(!box.id)
                        await getData(myValue,'/validate/box').then(
                            data => {
                                if (!data.errors) {
                                    box = {'id': data.id, 'name': data.name}
                                    addElementList(`Adding to ${data.name}`)
                                }else{
                                    addElementList(`Error: ${data.message}`)
                                }
                            }
                        );
                    else{
                        if (myValue !== box.name) {
                            if (!kits.some(code => code.name === myValue)){
                                await getData(myValue,'/validate/kit').then(
                                    data => {
                                        if (!data.errors) {
                                            kits.push({'id':data.id,'name':data.name})
                                            addElementList(`Adding Kit ${data.name} to BOX${box.id}`)
                                        }else{
                                            addElementList(`Error: ${data.message}`)
                                        }
                                    }
                                );
                            }else{
                                addElementList(`Msg: Kit already scanned.`)
                            }
                        }else{
                            if (kits.length < 1){
                                addElementList('Msg: Need to add kit first.')
                            }else{
                                addElementList('msg: Processing...')
                                await postData(box,kits,'/validate/kit').then(
                                    data => {
                                        if (!data.errors){
                                            addElementList(`Msg: ${data}`)
                                        }else {
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


