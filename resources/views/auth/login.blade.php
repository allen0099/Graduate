<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img class="w-32 h-32" src="{{url('/asset/Tamkang_University_logo.svg.png')}}"/>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        {{-- @if ($errors->any())
            <div class="mb-4">
                <div class="font-medium text-red-600">{{ __('哎呀！ 出了些問題') }}</div>

                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="username" value="{{ '帳號' }}"/>
                <x-jet-input id="username" class="block mt-1 w-full" type="string" name="username"
                             :value="old('username')" required autofocus/>
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ '密碼' }}"/>
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required
                             autocomplete="current-password"/>
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('記住此次登入') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('忘記密碼?') }}
                    </a>
                @endif

                <x-jet-button class="ml-4">
                    {{ '登入' }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
