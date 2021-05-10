<!DOCTYPE html>
<html>

<head>
    <title>{{ $year }}學年度{{ $type }}服{{ $preserve }}清單({{ $date }})</h1>
    </title>
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

        #orderlist tr:nth-child(even) {
            background: #CCC
        }

        #orderlist tr:nth-child(odd) {
            background: #FFF
        }

    </style>
</head>

<body>
    @if (count($orders_chunk) === 0)
        <div id="header">
            <h1 class="title">{{ $year }}學年度{{ $type }}服{{ $preserve }}清單({{ $date }})</h1>
        </div>
        <h1 class="title">無任何{{ $preserve }}</h1>
    @endif
    @foreach ($orders_chunk as $chunk_index => $orders)
        <div id="header">
            <h1 class="title">{{ $year }}學年度{{ $type }}服{{ $preserve }}清單({{ $date }})
            </h1>
        </div>
        <div id="main">
            <table border="1">
                <thead>
                    <tr>
                        <th></th>
                        <th>訂單編號</th>
                        <th>姓名</th>
                        <th>學號</th>
                        <th>代表色</th>
                        @foreach (array_keys($sizeList) as $s_i => $size)
                            <th> {{ $size }} </th>
                        @endforeach
                        @foreach (array_keys($colorList) as $c_i => $color)
                            <th> {{ $color }} </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody id="orderlist">
                    @foreach ($orders as $order_index => $order)
                        <tr>
                            <td> {{ $order_index + 1 }}</td>
                            <td>{{ $order->document_id }}</td>
                            <td>{{ $order->owner->name }}</td>
                            <td style="text-align: center;">{{ $order->owner->username }}</td>
                            <td style="text-align: center;">{{ $order->rep_color }}</td>
                            @foreach (array_keys($sizeList) as $s_i => $size)
                                <td style="text-align: center;">{{ $order->sizeList[$size] }}</td>
                            @endforeach
                            @foreach (array_keys($colorList) as $c_i => $color)
                                <td style="text-align: center;">{{ $order->colorList[$color] }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($chunk_index === count($orders_chunk) - 1)
                <p>{{ $type }}服總計(件)
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    狀態：{{ $preserve }}
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    列印日期：{{ $date }}
                </p>
                <table border="1">
                    <thead>
                        <tr>
                            @foreach (array_keys($sizeList) as $s_i => $size)
                                <th> {{ $size }} </th>
                            @endforeach
                            @foreach (array_keys($colorList) as $c_i => $color)
                                <th> {{ $color }} </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($sizeList as $key => $value)
                                <td style="text-align: center;"> {{ $value }} </td>
                            @endforeach
                            @foreach ($colorList as $key => $value)
                                <td style="text-align: center;"> {{ $value }} </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            @endif
            <div id="footer">
                <div class="page-number"></div>
            </div>
        </div>
        <div class="page-break"></div>
    @endforeach
</body>

</html>
