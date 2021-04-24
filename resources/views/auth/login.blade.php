<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center py-6 sm:pt-0 bg-gray-100">
        <div class="flex items-center flex-col">
            <img class="w-32 h-32" src="{{ url('/asset/Tamkang_University_logo.svg.png') }}" />
            <div class="mt-5 text-center font-black text-3xl">{{ $title }}</div>
        </div>

        <div class="bg-white lg:w-4/12 md:6/12 w-10/12 m-auto my-5 shadow-md">
            <div class="pt-5 pb-8 px-8 rounded-xl">
                <x-jet-validation-errors class="mb-4" />
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}" class="mt-3">
                    @csrf
                    <div class="my-5 text-sm">
                        <label for="username" class="block text-black">帳號</label>
                        <input type="text" autofocus required id="username" name="username"
                            class="rounded-sm px-4 py-3 mt-3 focus:outline-none bg-gray-100 w-full" placeholder="預設學號"
                            :value="old('username')" autocomplete="username" />
                    </div>
                    <div class="my-5 text-sm">
                        <label for="password" class="block text-black">密碼</label>
                        <input type="password" id="password" name="password" required
                            class="rounded-sm px-4 py-3 mt-3 focus:outline-none bg-gray-100 w-full"
                            placeholder="預設學號後六碼" autocomplete="current-password" />
                        <div class="flex justify-end mt-2 text-xs text-gray-600">
                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                    href="{{ route('password.request') }}">
                                    {{ __('忘記密碼?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="my-5 text-sm">
                        <label for="remember_me" class="flex items-center">
                            <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                            <span class="ml-2 text-sm text-gray-600">{{ __('記住此次登入') }}</span>
                        </label>
                    </div>

                    <button
                        class="block text-center text-white bg-gray-800 p-3 duration-300 rounded-sm hover:bg-black w-full">登入</button>
                </form>
            </div>
        </div>

        {{-- <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <x-jet-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="text-sm text-gray-600 mb-3">※ 登入帳號為學號，密碼預設學號後六碼。</div>
                <div>
                    <x-jet-label for="username" value="{{ '帳號' }}" />
                    <x-jet-input id="username" class="block mt-1 w-full" type="text" name="username"
                        :value="old('username')" required autofocus autocomplete="username" />
                </div>

                <div class="mt-4">
                    <x-jet-label for="password" value="{{ '密碼' }}" />
                    <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />
                </div>

                <div class="block mt-4">
                    <label for="remember_me" class="flex items-center">
                        <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('記住此次登入') }}</span>
                    </label>
                </div>
                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900"
                            href="{{ route('password.request') }}">
                            {{ __('忘記密碼?') }}
                        </a>
                    @endif

                    <x-jet-button class="ml-4">
                        {{ '登入' }}
                    </x-jet-button>
                </div>
            </form>
        </div> --}}

        <div class="mt-2 grid md:grid-rows-1 grid-rows-3 grid-flow-col gap-2">
            <a href="{{ route('find_pdf', ['name' => '公告1']) }}" target="_blank"
                class="text-center text-green-600 hover:text-purple-700">{{ '@' }}{{ \App\Models\Config::getPdfName('pdf_a') }}</a>
            <a href="{{ route('find_pdf', ['name' => '公告2']) }}" target="_blank"
                class="text-center text-green-600 hover:text-purple-700">{{ '@' }}{{ \App\Models\Config::getPdfName('pdf_b') }}</a>
            <a href="{{ route('find_pdf', ['name' => '公告3']) }}" target="_blank"
                class="text-center text-green-600 hover:text-purple-700">{{ '@' }}{{ \App\Models\Config::getPdfName('pdf_c') }}</a>
        </div>
    </div>
</x-guest-layout>
