<!DOCTYPE html>
<html>

<head>
    <title>歸還證明單</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        html {
            size: 21cm 29.6cm;
            margin: 0.3cm 1cm;
        }

        * {
            font-family: "TaipeiSansTCRegular";
            margin-top: 0px;
            margin-bottom: 0px;
        }

        body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .half-bar {
            margin: 0.5cm 0px;
            border-bottom: 1px dashed #000000;
        }

        .title {
            font-size: 32px;
            text-align: center;
            margin-top: 10px;
            margin-bottom: 15px;
        }

        .page-break {
            page-break-after: always;
        }

        .flex-container {
            display: flex;
            justify-content: center;
        }

        th {
            text-align: left;
            padding: 0px 10px;
        }

        table {
            margin-top: 3px;
            margin-bottom: 5px;
            font-size: 18px;
        }

        #footer {
            text-align: right;
            font-size: 16px;
        }

        .remark {
            font-size: 14px;
        }

        .remark li {
            padding: 0px 5px;
            word-wrap: break-word;
        }

        .barcode {
            display: flex;
            justify-content: flex-start;
        }

    </style>
</head>

<body>
    <div id="header">
        <h1 class="title">還款名單</h1>
    </div>
    <div id="main">
        <p>編號：{{ $list->id }}, 狀態：{{ $state }}</p>
        <br><br>
        @foreach ($list->sets as $index => $set)
            <table>
                <tr>
                    <th>學號：{{ $set->student->username }}</th>
                    <th>系級：{{ $set->student->school_class->class_name }}</th>
                    <th>姓名：{{ $set->student->name }}</th>
                </tr>
            </table>
        @endforeach
    </div>
</body>

</html>
