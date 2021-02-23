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

        td {
            padding-left: 5px;
        }

        table {
            width: 100%;
            margin-top: 3px;
            margin-bottom: 5px;
            font-size: 14px;
            border-collapse: collapse;
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
        <p>編號：{{ $list->id }} 學位：碩士 狀態：{{ $state }} 成立日期：2020-10-02 11:33</p>
        <table border="1">
            <thead>
                <tr>
                    <th></th>
                    <th>學號</th>
                    <th>系級</th>
                    <th>姓名</th>
                    <th>所屬訂單</th>
                    <th>歸還編號</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list->sets as $index => $set)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $set->student->username }}</td>
                        <td>{{ $set->student->school_class->class_name }}</td>
                        <td>{{ $set->student->name }}</td>
                        <td>{{ $set->document_id }}</td>
                        <td>{{ $set->return_id }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    {{-- <td span="2"></td> --}}
                    <th colspan="2">總計</th>
                    <td>100筆</td>
                    <th>總金額</th>
                    <td>NT$ 270000</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
