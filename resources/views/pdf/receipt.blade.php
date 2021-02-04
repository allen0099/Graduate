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
        <h1 class="title">歸還證明單</h1>
    </div>
    <div id="main" class="flex-container">
        <div class="head-box">
            <table align="center">
                <tr>
                    <th>
                        項目：{{ $cloth->name }}
                    </th>
                    <th>
                        尺寸：{{ $cloth->spec }} 號
                    </th>
                    <th>
                        {{ $accessory->name }}：{{ $accessory->spec }}色
                    </th>
                </tr>
                <tr>
                    <th>學號：{{ $student->username }}</th>
                    <th>系級：{{ $student->school_class->class_name }}</th>
                    <th>姓名：{{ $student->name }}</th>
                </tr>
            </table>

            {{-- <table>
                <th>
                    注意事項：
                </th>
                <ol class="remark">
                    <li>
                        <p>一二三四五六七八九十一二三四五六七八九十一二三四五六七八九十一二三四五六七八九十一二三四五六七八九十</p>
                    </li>
                    <li>
                        <p>一二三四五六七八九十一二三四五六七八九十一二三四五六七八九十一二三四五六七八九十一二三四五六七八九十</p>
                    </li>
                    <li>
                        <p>一二三四五六七八九十一二三四五六七八九十一二三四五六七八九十一二三四五六七八九十一二三四五六七八九十</p>
                    </li>
                    <li>
                        <p>一二三四五六七八九十一二三四五六七八九十一二三四五六七八九十一二三四五六七八九十一二三四五六七八九十</p>
                    </li>
                    <li>
                        <p>一二三四五六七八九十一二三四五六七八九十一二三四五六七八九十一二三四五六七八九十一二三四五六七八九十</p>
                    </li>
                </ol>
            </table> --}}
        </div>
    </div>
    {{-- <div id="footer">
        <p>歸還人姓名：_____________________, 電話：_______________________</p>
    </div> --}}

</body>

</html>
