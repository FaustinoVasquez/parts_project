<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <title>Document</title>
</head>
<body onload=window.print()>

<div class="visible-print text-center">
    {{\SimpleSoftwareIO\QrCode\Facades\QrCode::size(40)->generate('SHELF'.$shelf->shelf_id)}}
</div>
<div class="text-center">
{{$shelf->shelf_name_new}}
</div>
</body>
</html>
