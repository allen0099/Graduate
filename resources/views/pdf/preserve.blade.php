<!DOCTYPE html>
<html>

<head>
    <title>meow</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        html {
            size: 21cm 29.6cm;
            margin: 0.3cm 0.5cm;
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
            font-size: 32px;
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
            padding-left: 1px;
        }

        table {
            width: 100%;
            margin-top: 3px;
            margin-bottom: 5px;
            font-size: 14px;
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
            font-size: 16px;
            text-align: right;
        }

        .l-child {
            display: inline-block;
            font-size: 16px;
        }

        tr:nth-child(even) {
            background: #CCC
        }

        tr:nth-child(odd) {
            background: #FFF
        }

    </style>
</head>

<body>
    <div id="header">
        <h1 class="title">109學年度學士服預約清單 {{ $date }}</h1>
    </div>
    <div id="main">
        <table border="1">
            <thead>
                <tr>
                    <th>訂單編號</th>
                    <th>姓名</th>
                    <th>學號</th>
                    <th>代表色</th>
                    <th> S </th>
                    <th> M </th>
                    <th> L </th>
                    <th> XL</th>
                    <th> 白 </th>
                    <th> 黃 </th>
                    <th> 橘 </th>
                    <th> 灰 </th>
                    <th> 藍 </th>
                    <th> 紫 </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $key => $order)
                    <tr>
                        <td>{{ $order->document_id }}</td>
                        <td>{{ $order->owner->name }}</td>
                        <td style="text-align: center;">{{ $order->owner->username }}</td>
                        <td style="text-align: center;">{{ $order->rep_color }}</td>
                        <td style="text-align: center;">{{ $order->sizeList['S'] }}</td>
                        <td style="text-align: center;">{{ $order->sizeList['M'] }}</td>
                        <td style="text-align: center;">{{ $order->sizeList['L'] }}</td>
                        <td style="text-align: center;">{{ $order->sizeList['XL'] }}</td>
                        <td style="text-align: center;">{{ $order->colorList['白'] }}</td>
                        <td style="text-align: center;">{{ $order->colorList['黃'] }}</td>
                        <td style="text-align: center;">{{ $order->colorList['橘'] }}</td>
                        <td style="text-align: center;">{{ $order->colorList['灰'] }}</td>
                        <td style="text-align: center;">{{ $order->colorList['藍'] }}</td>
                        <td style="text-align: center;">{{ $order->colorList['紫'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
