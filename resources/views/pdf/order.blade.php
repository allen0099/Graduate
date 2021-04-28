<!DOCTYPE html>
<html>

<head>
    <title>淡江大學畢業班級{{ $cloth_type }}借用訂單</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        html {
            size: 21cm 29.6cm;
            margin: 0.3cm 0.7cm;
        }

        * {
            font-family: "TaipeiSansTCRegular";
            margin-top: 0px;
            margin-bottom: 0px;
        }

        body {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            z-index: -1;
        }

        .title {
            font-size: 26px;
            text-align: center;
            margin-top: 5px;
            margin-bottom: 5px;
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
            font-size: 14px;
        }

        #footer {
            text-align: right;
            font-size: 14px;
        }

        .remark {
            font-size: 12px;
            width: 90%;
        }

        .remark li {
            padding: 0px 5px;
            word-wrap: break-word;
        }

        .barcode {
            display: flex;
            justify-content: flex-start;
        }

        .img {
            position: absolute;
            width: 130px;
            height: 130px;
            right: -10px;
            top: 41%;
            z-index: 2;
            /* opacity: 0.9; */
        }

        .half-bar {
            width: 100vw;
            position: absolute;
            margin: 0.5cm 0px;
            border-bottom: 1px dashed #000000;
            top: 48%;
            z-index: 3;
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
                            <div class="barcode">
                                <span>
                                    <img
                                        src="data:image/png;base64,{{ DNS1D::getBarcodePNG((string) $order->document_id, 'C39', 1, 30) }}" />
                                </span>
                            </div>
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
                            <p>訂購人：{{ $order->owner->name }}</p>
                        </th>
                        <th>
                            <p>系級：{{ $order->owner->school_class->class_name }}</p>
                        </th>
                        <th>
                            <p>學號：{{ $order->owner->username }}
                            </p>
                            <div class="barcode">
                                <span>
                                    <img
                                        src="data:image/png;base64,{{ DNS1D::getBarcodePNG((string) $order->owner->username, 'C39', 1, 30) }}" />
                                </span>
                            </div>
                        </th>
                    </tr>
                </table>
                <hr />

                <table style="padding-left: 70px;">
                    @foreach ($order->sets as $index => $set)
                        <tr>
                            <th>
                                @if ($index === 0)
                                    <p>項目：</p>
                                @endif
                            </th>
                            <th>
                                <p>{{ $set->student->username }}</p>
                            </th>
                            <th>
                                <p>{{ $set->student->school_class->class_name }}</p>
                            </th>
                            <th>
                                <p>{{ $set->student->name }}</p>
                            </th>
                            <th>
                                <p>尺寸：{{ $set->cloth->spec }}</p>
                            </th>
                            <th>
                                <p>顏色：{{ $set->accessory->spec }}</p>
                            </th>
                        </tr>
                    @endforeach
                </table>

                <table>
                    <tr>
                        <th>
                            <p>金額：</p>
                        </th>
                        <th>
                            <p>{{ $cloth_type }} {{ count($order->sets) }} 套</p>
                        </th>
                        <th>
                            <p>×</p>
                        </th>
                        <th>
                            <p>（清潔費{{ $price }}元 + 保證金{{ $margin }}元）</p>
                        </th>
                        <th>
                            <p>{{ '=' }}</p>
                        </th>
                        <th>
                            <p>{{ count($order->sets) * ($price + $margin) }} 元（新台幣）</p>
                        </th>
                        <th>
                            <span style="vertical-align:middle;">經手人：
                                <img style="width: 50px;" src="{{ $admin_stamp }}">
                            </span>
                        </th>
                    </tr>
                    @for ($i = 0; $i < 10 - count($order->sets); $i++)
                        <tr>
                            <th>&nbsp;</th>
                        </tr>
                    @endfor
                </table>

                <div style="padding: 10px 0px;"></div>
                <table>
                    <th>
                    </th>
                    <ol class="remark">
                        <li>
                            <p>歸還採個人歸還，退還保證金一律採匯款至個人帳戶，配合學校付款作業時程，於歸還學位服後約7~10個工作日之後匯款。</p>
                        </li>
                        <li>
                            <p>請在繳費期限{{ $paid_time->start_time->format('Y/m/d') }}至{{ $paid_time->end_time->format('Y/m/d') }}止，至校園繳費機進行繳費，繳費完成後請持繳費單據與本單至{{ $payment_location }}完成繳費登記。
                            </p>
                        </li>
                        <li>
                            <p>請於{{ $rec_time->start_time->format('Y/m/d') }}至{{ $rec_time->end_time->format('Y/m/d') }}，在下午2~4點持本單學生存根聯至{{ $receive_location }}領取{{ $cloth_type }}。
                            </p>
                        </li>
                        <li>
                            <p>於領取期限前兩日至學位服租借網站可以預約領取衣服的日期，詳細請看網站說明。</p>
                        </li>
                    </ol>
                </table>
            </div>
        </div>
        <div id="footer">
            <p>{{ $part === 0 ? '（學生存根聯-' . $check_code . '）' : '（事務整備組收執聯-' . $check_code . '）' }}
                @for ($i = 0; $i < ($part === 0 ? 18 : 7); $i++)
                    &nbsp;
                @endfor
            </p>
        </div>
        @if ($part === 0)
            <hr style="position: relative; margin: 0.1cm 0px; border-bottom: 1px dashed #000000;">
            <div
                style="position: relative; left: 30%; top: -13px; height: 22px; width: 300px; text-align: center; font-size: 12px; opacity: 0.7;">
                請&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                沿&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                虛&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                線&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                撕&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                下
            </div>
            <img class="img" src="{{ $department_stamp }}" />
        @endif
    @endfor
</body>

</html>
