<!DOCTYPE html>
<html>

<head>
    <title>{{ $year }} 學年度{{ $type }}學位服訂單資料</title>
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

        .half-bar {
            margin: 0.5cm 0px;
            border-bottom: 1px dashed #000000;
        }

        .title {
            font-size: 30px;
            text-align: center;
            margin-top: 10px;
            margin-bottom: 15px;
        }

        .page-break {
            page-break-after: always;
        }

        .page-break:last-child {
            page-break-after: auto;
        }

        .flex-container {
            display: flex;
            justify-content: center;
        }

        td {
            padding-left: 2px;
            padding-right: 2px;
        }

        table {
            width: 100%;
            margin-top: 3px;
            margin-bottom: 5px;
            font-size: 12px;
            border-collapse: collapse;
        }

        #footer {
            text-align: center;
            position: absolute;
            bottom: 3;
        }

        .page-number:before {
            font-size: 14px;
            content: counter(page);
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

        .space-between {
            font-size: 16;
        }

        .r-child {
            display: inline-block;
            font-size: 14px;
            text-align: right;
        }

        .l-child {
            display: inline-block;
            font-size: 14px;
        }

        #orderlist tr:nth-child(even) {
            background: #CCC
        }

        #orderlist tr:nth-child(odd) {
            background: #FFF
        }

    </style>
</head>

<body>

    @foreach ($list_chunk as $key => $chunk)
        <div id="header">
            <h1 class="title">{{ $year }} 學年度{{ $type }}學位服訂單資料</h1>
        </div>
        <div id="main">
            <div class="space-between">
                <div class="l-child" style="width: 51%;">
                        列印日期：{{ now()->format('Y/m/d H:i') }}
                </div>
                <div class="r-child" style="width: 30%;">
                        總筆數：{{ count($list) }} 筆
                </div>
            </div>
            <table border="1">
                <thead>
                    <tr>
                        <th></th>
                        <th>學號</th>
                        <th>系級</th>
                        <th>姓名</th>
                        <th>訂單號</th>
                        <th>付款號</th>
                        <th>歸還號</th>
                        <th>批次</th>
                        <th>狀態</th>
                    </tr>
                </thead>
                <tbody id="orderlist">
                    @foreach ($chunk as $index => $set)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $set['student_id'] }}</td>
                            <td>{{ $set['name'] }}</td>
                            <td>{{ $set['class'] }}</td>
                            <td>{{ $set['document_id'] }}</td>
                            <td>{{ $set['payment_id'] }}</td>
                            <td>{{ $set['return_id'] }}</td>
                            <td>{{ $set['batch_id'] }}</td>
                            <td>{{ $set['status'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div id="footer">
                <div class="page-number"></div>
            </div>
        </div>
        <div class="page-break"></div>
    @endforeach
</body>

</html>
