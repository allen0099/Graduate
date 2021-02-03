<!DOCTYPE html>
<html>

<head>
    <title>meow</title>
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
    {{ $date }}
</body>

</html>
