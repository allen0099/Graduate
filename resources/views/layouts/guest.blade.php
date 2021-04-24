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
<div class="w-full bg-gray-800 text-white">
    <div class="xl:px-40 pb-5 lg:px-20 md:px-10 sm:px-5 px-10">
        <div class="w-full pt-12 flex flex-col sm:flex-row space-y-2  justify-start">
            <div class="w-full sm:w-1/2 pr-6 flex flex-col space-y-4">
                <div class="md:text-3xl sm:text-2xl text-xl">總務處事務整備組：</div>
                <p class="opacity-60">上班時間：星期一至星期五 上午8:00~12:00 下午1:00~5:00</p>
                <p class="opacity-60">電話：(02)2621-5656 / 0919-585656 轉 2275</p>
                <p class="opacity-60">地址：25137新北市淡水區英專路151號 守謙會議中心HC308室</p>
            </div>
            <div class="w-full sm:w-1/2 flex flex-col space-y-4 sm:pt-0 pt-5">
                <div class="md:text-3xl sm:text-2xl text-xl">網頁維護及個資聯絡窗口：</div>
                <p class="opacity-60">本網頁由事務整備組黃慶文先生負責維護，個資保護聯絡窗口為賴文經專員；若您有任何問題及意見，歡迎來信批評指教。</p>
                <p class="opacity-60">聯絡信箱：<a href="mailto:agox@oa.tku.edu.tw"
                        class="text-orange-300">agox@oa.tku.edu.tw</a></p>
            </div>
        </div>
        <hr class="mt-5" />
        <div class="w-full pt-5 flex flex-col sm:flex-row space-y-2  justify-start">
            <div class="w-full pr-6 flex flex-col space-y-4">
                <p class="opacity-60">本網站著作權屬於淡江大學總務處，請詳見。
                    <a href="https://www.tku.edu.tw/privacy.asp" class="text-orange-300" target="_blank">隱私權政策</a>
                    │ <a href="https://www.tku.edu.tw/pdp.asp" class="text-orange-300" target="_blank">個資政策</a>
                    │ <a href="https://www.tku.edu.tw/notify.asp" class="text-orange-300" target="_blank">個人資料告知聲明</a>
                </p>
                <p class="opacity-60">建議最佳瀏覽 Google Chrome / Mozilla Firefox / Edge 或相容 W3C 網頁標準之最新版瀏覽器。</p>
            </div>
        </div>
    </div>
    <div class="bg-gray-600 xl:px-40 pb-5 lg:px-20 md:px-10 sm:px-5 px-10">
        <div class="opacity-60 pt-5 text-center">
            <p>Copyright © 2020-{{ today()->year }} ALL RIGHTS RESERVED BY TAMKANG UNIVERSITY OFFICE OF INFORMATION
                SERVICES.</p>
        </div>
    </div>
</div>

</html>

{{-- <div><a href="https://www.tku.edu.tw/privacy.asp" class="hover:text-green-600" target="_blank">@
        隱私權政策</a></div>
<div><a href="https://www.tku.edu.tw/pdp.asp" class="hover:text-green-600" target="_blank">@ 個資政策</a>
</div>
<div><a href="https://www.tku.edu.tw/notify.asp" class="hover:text-green-600" target="_blank">@
        個人資料告知聲明</a></div> --}}
