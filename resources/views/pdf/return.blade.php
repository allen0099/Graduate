<!DOCTYPE html>
<html>

<head>
    <title>歸還證明單</title>
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
            font-size: 40px;
            text-align: center;
            margin-top: 10px;
            margin-bottom: 40px;
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
            margin-bottom: 50px;
        }

        table {
            margin-top: 5px;
            margin-bottom: 20px;
            font-size: 18px;
        }

        #footer {
            text-align: right;
            font-size: 15px;
        }

        .remark {
            font-size: 15px;
            width: 90%;
        }

        .remark li {
            margin-top: 5px;
            padding: 0px 5px;
            word-wrap: break-word;
        }

        .img {
            position: absolute;
            top: 42%;
            width: 120px;
            height: 120px;
            left: 53%;
            z-index: 2;
            /* opacity: 0.65; */
        }

        .centent {
            margin-top: 15px;
            font-size: 18px;
            text-align: center;
        }

        .date {
            margin-top: 60px;
            margin-bottom: 70px;
            font-size: 20px;
            text-align: center;
        }

        .return_id {
            position: absolute;
            z-index: 999;
            text-align: right;
        }

        .sign1 {
            margin-top: 15px;
            margin-bottom: 50px;
            font-size: 18px;
            text-align: center;
        }

        .sign2 {
            margin-top: 15px;
            font-size: 14px;
        }

        .half-bar {
            position: relative;
            margin: 0.5cm 0px;
            border-bottom: 1px dashed #000000;
        }

        .hr-more {
            position: relative;
            height: 20px;
            left: 44%;
            top: 5px;
            text-align: center;
            /* border-radius: 4px; */
        }

        .barcode {
            display: flex;
            justify-content: flex-start;
        }


        .r-child {
            position: absolute;
            bottom: 0;
            font-size: 32px;
            text-align: right;
            right: 0;
        }

        .l-child {
            position: absolute;
            bottom: 0;
            font-size: 32px;
            left: 0;
        }

    </style>
</head>

<body>
    <img class="img" src="{{ $department_stamp }}" />
    <div>
        <h1 style="font-size: 32px;"> {{ $set->student->username[0] }}</h1>
    </div>
    <div class="return_id">
        <p>單據編號：{{ $payment_id . '-' . $pos }}</p>
    </div>
    <div id="header">
        <h1 class="title">歸還證明單</h1>
    </div>
    <div id="main">
        <div class="centent">
            <p>茲退還&nbsp;&nbsp;
                @for ($i = 0; $i < 20 - strlen($set->student->name); $i++)
                    &nbsp;
                @endfor
                {{ $set->student->name }}
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                同學
            </p>
            <p style="margin-top: 10px;">借用{{ $set->cloth->name }}一套。</p>
        </div>
        <table style="margin-top: 30px; border-spacing: 0 1em;">
            <tr>
                <th>
                    <p>學號：{{ $set->student->username }}</p>
                    <div class="barcode">
                        <span>
                            <img
                                src="data:image/png;base64,{{ DNS1D::getBarcodePNG((string) $set->student->username, 'C39', 1.5, 30) }}" />
                        </span>
                    </div>
                </th>
                <th>
                    <p>系級：{{ $set->student->school_class->class_name }}</p>
                </th>
                <th>
                </th>
            </tr>
            <tr>
                <th>
                    <p>訂單編號：{{ $document_id }}</p>
                </th>
                <th>
                    <p>付款編號：{{ $payment_id }}</p>
                </th>
                <th>
                    <span style="vertical-align:middle;">經手人：
                        <img style="width: 80px;" src="{{ $admin_stamp }}" />
                    </span>
                </th>
            </tr>
        </table>
    </div>
    <div id="footer">
        <div style="padding: 10px 0px;"></div>
        <table>
            <th>
                注意事項：
            </th>
            <ol class="remark">
                <li>
                    <p>請於{{ $return_time->end_time->format('Y/m/d') }}前，持本單與所借用服飾至{{ $return_location }}辦理歸還手續。
                    </p>
                </li>
                <li>
                    <p>服裝如有毀損或非本校學位服之情事者，須照價賠償。</p>
                </li>
                {{-- <li>
                    <p>請於109年06月30日前，持本單與所借用服飾至守謙會議中心HC308辦理歸還手續。</p>
                </li>
                <li>
                    <p>服裝如有毀損或非本校學位服之情事者，須照價賠償，價目表如下：
                    <ul>
                        <li>衣服：????元、帽子(連帽穗)：????元</li>
                        <li>領巾：????元、帽穗：????元</li>
                    </ul>
                    </p>
                </li> --}}
            </ol>
        </table>
    </div>
    <div class="date">
        <p>中&nbsp;&nbsp;華&nbsp;&nbsp;民&nbsp;&nbsp;國&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ today()->year - 1911 }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;年
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ today()->month }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;月
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ today()->day }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日
        </p>
    </div>
    <div class="sign1">退還人姓名：____________________，連絡電話：____________________</div>
    <div class="sign2">
        <p>※無法親自歸還學位服時，請借用學位服者親自填寫下列資料。</p>
    </div>
    <div class="sign2">
        <p>本人______________(請簽章)，連絡電話______________，茲委託______________(代理人姓名)協助歸還學位服。</p>
    </div>
    <div class="l-child">{{ substr($set->student->school_class->class_id, 0, 2) }}</div>
    <div class="r-child">{{ substr($set->student->school_class->class_id, 2, 2) }}</div>
</body>

</html>
