<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-2 sm:pt-0 bg-gray-100">
        <div class="flex items-center flex-col">
            <img class="w-32 h-32" src="{{ url('/asset/Tamkang_University_logo.svg.png') }}" />
            <div class="mt-5 text-center font-black text-3xl">{{ $title }}</div>
        </div>

        <div class="mt-8 mb-10 text-center">
            <div class="font-bold text-xl text-yellow-600">很抱歉~ 網站正在維護中！</div>
            <div class="font-bold text-xl text-yellow-600">請於維護後再使用各項功能服務，謝謝！</div>
        </div>

        <div class="mt-8 grid md:grid-rows-1 grid-rows-3 grid-flow-col gap-2">
            <a href="{{ route('find_pdf', ['name' => '公告1']) }}" target="_blank"
                class="text-center text-green-600 hover:text-purple-700">{{ '@' }}{{ \App\Models\Config::getPdfName('pdf_a') }}</a>
            <a href="{{ route('find_pdf', ['name' => '公告2']) }}" target="_blank"
                class="text-center text-green-600 hover:text-purple-700">{{ '@' }}{{ \App\Models\Config::getPdfName('pdf_b') }}</a>
            <a href="{{ route('find_pdf', ['name' => '公告3']) }}" target="_blank"
                class="text-center text-green-600 hover:text-purple-700">{{ '@' }}{{ \App\Models\Config::getPdfName('pdf_c') }}</a>
        </div>
    </div>
</x-guest-layout>
