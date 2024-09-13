<!DOCTYPE html>
<html lang="en">
<head>
    <title>Laravel 8 Generate PDF From View</title>
    <style>
        .myTable{width:100%;}
        .myTable td{
            text-align:center;
        }
        .myTable th{
            text-align:center;
        }
        header
        .header h1{
           text-align:center;
        }
        @font-face {
            font-family: 'Open Sans';
            src: url({{ storage_path('fonts\OpenSans-Regular.ttf') }}) format("truetype");
            font-weight: 100;
            font-style: normal;
        }
        body {
            font-family: "Open Sans";
        }

    </style>
</head>
<body>
<div style="margin-bottom: 10px">
    <div style="float: left; width: 50%;font-weight: bold; font-size: 20px">Order PickList All</div>
    <div style="margin-left: 50%; width: 50%; font-weight: bold; font-size: 20px; text-align: right">{{$date}}</div>
</div>

    <table class="myTable">
        <thead>
            <tr>
                <th>Brand</th>
                <th>Model</th>
                <th>ShelfID</th>
                <th>BoxID</th>
                <th>SKU</th>
                <th>KitLCN</th>
                <th>QP</th>
                <th>Picked</th>
            </tr>
        </thead>
        <tbody>

        @foreach($data as $item)
            <tr>
                <td> {{$item->Brand}}</td>
                <td> {{$item->Model}}</td>
                <td> {{$item->ShelfID}}</td>
                <td> {{$item->BoxID}}</td>
                <td> {{$item->SKU}}</td>
                <td> {{$item->KitLCN}}</td>
                <td> {{$item->QP}}</td>
                <td> {{$item->Picked}}</td>
            </tr>

        @endforeach
        </tbody>
    </table>

</body>
</html>
