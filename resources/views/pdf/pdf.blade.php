<!DOCTYPE html>
<html>
<head>
    <title>Hi</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>{{ $date }}</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    <h1>中文測試</h1>
    <div class="page-break"></div>
    <h1>Page 2</h1>
</body>
</html>


<style>

* {
    font-family: "TaipeiSansTCRegular";
}

.page-break {
    page-break-after: always;
}

@page {
  size: A4 portrait;
}

</style>