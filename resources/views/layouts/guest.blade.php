<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.js" defer></script>
</head>

<body>
    <div class="font-sans text-gray-900 antialiased">
        {{ $slot }}
    </div>
</body>
<!-- component -->
<script src="https://kit.fontawesome.com/4db6b32bd3.js" crossorigin="anonymous"></script>
<div class="w-full bg-gray-800 text-white mt-5">
    <div class="xl:px-40 pb-12 lg:px-20 md:px-10 sm:px-5 px-10">
        <div class="w-full pt-12 flex flex-col sm:flex-row space-y-2  justify-start">
            <div class="w-full sm:w-2/3 pr-6 flex flex-col space-y-4">
                <div class="md:text-3xl sm:text-2xl text-xl">{{ $title }}</div>
                <p class="opacity-60">地址：251301 新北市淡水區英專路151號</p>
                <p class="opacity-60">單位：事務整備組 (淡江大學守謙國際會議中心 H308)</p>
                <p class="opacity-60">上班時間：平日週一至週五 08:00~12:00、13:00~17:00</p>
                <p class="opacity-60">電話：02-26215656(市話) / 0919-585656(手機) 轉分機 2275</p>
                <p class="opacity-60">信箱：<a href="mailto:agox@oa.tku.edu.tw"
                        class="hover:text-green-600">agox@oa.tku.edu.tw</a>
                </p>
            </div>
            <div class="w-full sm:w-1/4 flex flex-col space-y-4 pt-5 sm:pt-0">
                <div class="sm:text-2xl text-xl">個資與隱私權宣告</div>
                <div><a href="https://www.tku.edu.tw/privacy.asp" class="hover:text-green-600" target="_blank">@
                        隱私權政策</a></div>
                <div><a href="https://www.tku.edu.tw/pdp.asp" class="hover:text-green-600" target="_blank">@ 個資政策</a>
                </div>
                <div><a href="https://www.tku.edu.tw/notify.asp" class="hover:text-green-600" target="_blank">@
                        個人資料告知聲明</a></div>
            </div>
        </div>
        <div class="opacity-60 pt-5">
            <p>Copyright © 2020-{{ today()->year }} 淡江大學版權所有</p>
        </div>
    </div>
</div>

</html>
