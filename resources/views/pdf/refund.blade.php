<!DOCTYPE html>
<html>

<head>
    <title>{{ $year }} 學年度{{ $type }}學位服退款清單</title>
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

    @foreach ($sets_chunk as $key => $chunk)
        <div id="header">
            <h1 class="title">{{ $year }} 學年度{{ $type }}學位服退款清單</h1>
        </div>
        <div id="main">
            <div class="space-between">
                <div class="l-child" style="width: 17%;">
                    編號：{{ $list->id }}
                </div>
                <div class="l-child" style="width: 51%;">
                    成立日期：2020-10-02 11:33
                </div>
                <div class="r-child" style="width: 30%;">狀態：{{ $state }}</div>
            </div>
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
                    @foreach ($chunk as $index => $set)
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
            </table>
            @if ($key === count($sets_chunk) - 1)
                {{-- <div class="space-between">
                    <div class="l-child" style="width: 49%;">
                        總筆數：{{ count($list->sets) }} 筆
                    </div>
                    <div class="r-child" style="width: 50%;">總金額：NT$ {{ count($list->sets) * 500 }}</div>
                </div> --}}
                <p>
                    <span>總筆數：{{ count($list->sets) }} 筆&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <span>保證金({{ $type }})：新台幣 {{ $margin }} 元&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <span>總金額：新台幣 {{ count($list->sets) * $margin }} 元</span>
                </p>
            @endif
            <div id="footer">
                <div class="page-number"></div>
            </div>
        </div>
        <div class="page-break"></div>
    @endforeach
</body>

</html>
