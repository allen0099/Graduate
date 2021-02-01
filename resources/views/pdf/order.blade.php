<!DOCTYPE html>
<html>

<head>
    <title>淡江大學畢業班級{{ $cloth_type }}借用訂單</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        html {
            size: 21cm 29.6cm;
            margin: 1cm;
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
            margin: 1.0cm 0px;
            border-bottom: 1px dashed #000000;
        }

        .title {
            text-align: center;
            margin-top: 5px;
            margin-bottom: 10px;
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
            padding: 5px 10px;
        }

        table {
            margin-top: 5px;
            margin-bottom: 10px;
        }

        #footer {
            margin-top: 5px;
            text-align: right;
        }

        .remark {
            font-size: 14px;
        }

        .remark th {
            padding: 0px 10px;
        }

        .remark-title {
            font-size: 16px;
        }

    </style>
</head>

<body>
    @for ($part = 0; $part < 2; $part++)
        <div id="header">
            <h1 class="title">淡江大學畢業班級{{ $cloth_type }}借用訂單</h1>
        </div>
        <div id="main" class="flex-container">
            <div class="head-box">
                <table align="center">
                    <tr>
                        <th>
                            <p>訂單編號：{{ $order->document_id }}</p>
                        </th>
                        <th>
                            <p>成立時間：{{ substr($order->created_at, 0, 16) }}</p>
                        </th>
                        <th>
                        </th>
                    </tr>
                </table>
                <table align="center">
                    <tr>
                        <th>
                            <p>學號：{{ $order->owner->username }}</p>
                        </th>
                        <th>
                            <p>系級：{{ $order->owner->school_class->class_name }}</p>
                        </th>
                        <th>
                            <p>姓名：{{ $order->owner->name }}</p>
                        </th>
                    </tr>
                </table>
                {{-- <hr /> --}}
                <table>
                    <tr>
                        <th>
                            <p>項目：</p>
                        </th>
                        <th>
                            <p>學士服數量</p>
                        </th>
                        @foreach ($sizeList as $key => $value)
                            @if ($value == 0)
                                @continue
                            @endif
                            <th>
                                <p>{{ $key }} 號：{{ $value }}</p>
                            </th>
                        @endforeach
                    </tr>
                    <tr>
                        <th></th>
                        <th>
                            <p>領巾、帽子數量</p>
                        </th>
                        @foreach ($colorList as $key => $value)
                            @if ($value == 0)
                                @continue
                            @endif
                            <th>
                                <p>{{ $key }}色：{{ $value }}</p>
                            </th>
                        @endforeach
                    </tr>
                </table>
                <table>
                    <!--
                <tr>
                    <th>
                        <p>金額：</p>
                    </th>
                </tr>
-->
                    <tr>
                        <th>
                            <p>金額：</p>
                        </th>
                        <th>
                            <p>學士服 {{ $totle }} 套</p>
                        </th>
                        <th>
                            <p>×</p>
                        </th>
                        <th>
                            <p>{{ $one_set_price }} 元</p>
                        </th>
                        <th>
                            <p>=</p>
                        </th>
                        <th>
                            <p>{{ $totle * $one_set_price }} 元（新台幣）</p>
                        </th>
                        <th>
                            <p>經辦人蓋章：</p>
                        </th>
                    </tr>
                </table>
                <div style="padding: 10px 0px;"></div>
                <table class="remark">
                    <tr>
                        <th>
                            <p class="remark-title">備註：</p>
                        </th>
                        <th>
                            <p>1. 一二三四五六七八九十一二三四五六七八九十一二三四五六七八九十一二三四</p>
                        </th>
                    </tr>
                    <tr>
                        <th>
                        </th>
                        <th>
                            <p>2. 一二三四五六七八九十一二三四五六七八九十一二三四五六七八九十一二三四</p>
                        </th>
                    </tr>
                    <tr>
                        <th>
                        </th>
                        <th>
                            <p>3. 一二三四五六七八九十一二三四五六七八九十一二三四五六七八九十一二三四</p>
                        </th>
                    </tr>
                    <tr>
                        <th>
                        </th>
                        <th>
                            <p>4. 一二三四五六七八九十一二三四五六七八九十一二三四五六七八九十一二三四</p>
                        </th>
                    </tr>
                    <tr>
                        <th>
                        </th>
                        <th>
                            <p>5. 一二三四五六七八九十一二三四五六七八九十一二三四五六七八九十一二三四</p>
                        </th>
                    </tr>
                    <tr>
                        <th>
                        </th>
                        <th>
                            <p>6. 一二三四五六七八九十一二三四五六七八九十一二三四五六七八九十一二三四</p>
                        </th>
                    </tr>
                </table>
            </div>
        </div>
        <div id="footer">
            <p>{{ $part === 0 ? '（學生存根聯）' : '（事務組整備組收執聯）' }}</p>
        </div>
        @if ($part === 0)
            <hr class="half-bar" />
        @endif
    @endfor
</body>

</html>
