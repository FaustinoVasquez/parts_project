@extends('adminlte::page')

@section('title', 'FillBox')

@section('content_header')
    <h1>Fill Box Content</h1>
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
                        {{ __('Box - Kit ')}}
                    </h3>
                    <div class="card-tools">
                    </div>
                </div>

                <div class="card-body" id="mainForm">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form method="POST" action="{{ route('fill-box.store',) }}" id="myForm">
                                @csrf

                            <label for="BoxID" class="col-form-label text-md-end">{{ __('Scan Box') }}</label>
                            <input id="BoxID" type="text" class="form-control" name="BoxID" autofocus>

                            <label for="Kit" class="col-form-label text-md-end">{{ __('Scan Kits') }}</label>
                            <input id="Kit" type="text" class="form-control" name="Kit" disabled>

                            <div id="newRow"></div>
                            </form>
                        </div>


                        <div class="col-md-6 mt-5">
                            <label class="col-form-label text-md-end">{{ __('Use the QR "RemoveKit" To remove Las KIT') }}</label>
                            <label  class="col-form-label text-md-end">{{ __('Use the QR "SubmitBox" To Save the Box') }}</label>
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
        document.querySelector('input[name="BoxID"]').addEventListener("keyup", (e) => {
            mvalue = e.target.value
            if (e.key === "Enter") {

                var html = '';
                html += '<div class="mt-3">';
                html += '<input type="text" class="form-control" name="BoxID" value="'+mvalue+'" readonly hidden>';
                html += '</div>';
                $('#newRow').append(html);

                e.currentTarget.setAttribute("disabled","disabled");
                document.getElementById("Kit").removeAttribute("disabled");
                document.getElementById("Kit").focus();
            }
        });


        document.querySelector('#Kit').addEventListener("keyup", (e) => {
            if (e.key === "Enter") {
                let value = e.target.value;
                e.target.value = '';


                // Se necesita validar el KIT


                switch(value) {
                    case 'RemoveKit':
                        remove_last_kit()
                        break;
                    case 'SubmitBox':
                        setFocusScanBox()

                        break;
                    default:
                        var html = '';
                        html += '<div class="mt-3">';
                        html += '<input id="KitID" type="text" class="form-control" name="KitID[]" value="'+value+'" readonly>';
                        html += '</div>';
                        $('#newRow').append(html);
                }
            }
        });

        function remove_last_kit() {
            var select = document.getElementById('newRow');
            select.removeChild(select.lastChild);
        }

        function setFocusScanBox(){
            let form= document.getElementById("myForm");
            form.submit()

            // document.getElementById("newRow").innerHTML = "";
            // document.getElementById("BoxID").removeAttribute("disabled");
            // document.getElementById("BoxID").value = '';
            // document.getElementById("BoxID").focus();
            // document.getElementById("Kit").setAttribute("disabled","disabled");


        }



        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });

    </script>
@stop
