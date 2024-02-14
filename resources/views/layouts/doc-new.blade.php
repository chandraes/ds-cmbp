<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{public_path('assets/plugins/bootstrap/css/bootstrap.rtl.min.css')}}">
    <title>@yield('title', 'Document')</title>
    <style>
        header {
            position: fixed;
            display: block !important;
            float: right;
            top: -20px;
            width: 100% !important;
            left: 0px;
            height: 50px;
            text-align: right;
        }
        .table-pdf {
            border: 1px solid;
            padding-left: 5px;
            padding-right: 5px;
        }
        .text-pdf {
            font-size: 9pt;
        }
        .text-10 {
            font-size: 10pt;
        }
        .page-break {
            page-break-after: always;
        }
        .column-pdf {
            float: left;
            width: 50%;
        }
        .row-pdf:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{public_path('cmbp.png')}}" alt="cmbp" width="100">
        <br>
        <img src="{{public_path('images/saind-2.jpg')}}" alt="saind" width="170">
    </header>
    <br><br><br>
<div class="container-fluid">@yield('content')</div>
</body>
</html>
