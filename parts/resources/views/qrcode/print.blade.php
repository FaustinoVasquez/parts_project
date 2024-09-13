<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>How to Generate QR Code in Laravel 8</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" rel="stylesheet"/>

    <style>
        body {
            width: 2in;
            /*margin: 1in .1in;*/
        }

        .label {
            /* Avery 5160 labels -- CSS and HTML by MM at Boulder Information Services */
            width: 2.025in; /* plus .6 inches from padding */
            height: 1in; /* plus .125 inches from padding */
            /*padding: .125in .3in 0;*/
            margin-right: 0in; /* the gutter */
            margin-top: 0.3in ;

            float: left;
            font-size: small;
            /*font-size: xx-small*/

            /*text-align: center;*/
            /*overflow: hidden;*/

            /*outline: 1px dotted; !* outline doesn't occupy space like border does *!*/
        }

        .page-break {
            clear: left;
            display: block;
            page-break-after: always;
        }

        ul {
            width: 280px;
            overflow: hidden;
            padding: 2px;
        }
        li {
            float: left;
            display: inline;
            border-bottom: 1px  ;
            border-right: 2px;
        }
        #double li {
            width: 45%;
        }
        #double li:nth-child(odd) {
            border-right:  1px ;
        }
        #double li:nth-child(even) {
            margin-left: 1px;
        }
    </style>
</head>

<body onload="window.print()">

@if($parts)
    <div class="label">
        <ul id="double">
            @foreach ($parts as $id => $name)
                <li>
                    {{$name}}
                </li>
            @endforeach
        </ul>
    </div>
@endif

<div class="label">
    <table>
        <tr>
            <td colspan="2">.</td>
        </tr>
        <tr>
            <td>
                {!! QrCode::size(60)->generate($kitlcn);!!}
            </td>
            <td class="text-left">
                <div class="text-nowrap" style="font-weight: bold">&nbsp;SKU:&nbsp;{{$ref_sku}} /  QP: {{$lastTreeLcn}}</div>
                <div class="text-nowrap" style="width: 8rem;">&nbsp;{{$kitlcn}}</div>
                <div class="text-nowrap" style="width: 8rem;">&nbsp;{{$brand}}&nbsp;{{$model}}</div>
{{--                <ul class="mt-1">--}}
{{--                    <li>SKU:{{$ref_sku}}</li><br>--}}
{{--                    <li>{{$kitlcn}}</li><br>--}}
{{--                    <li>{{$brand}}</li>--}}
{{--                    <li>{{$model}}</li>--}}
{{--                </ul>--}}
            </td>
        </tr>

    </table>
{{--    <div class="float-left">--}}
{{--        <ul>--}}
{{--            <li>{{$kitlcn}}</li>--}}
{{--            <li>{{$brand}}</li>--}}
{{--            <li>{{$model}}</li>--}}
{{--        </ul>--}}
{{--    </div>--}}

{{--    <span class="float-left">{{$kitlcn}}</span>--}}
{{--    <span class="float-left">{{$brand}}</span>--}}
{{--    <span class="float-left">{{$model}}</span>--}}
{{--    <span class="float-left"> {!! QrCode::size(40)->generate($kitlcn);!!}</span>--}}
</div>

</body>
</html>
