<x-app-layout>
    <div class="font-[sans-serif]">
        <div class="grid lg:grid-cols-2 gap-4 max-lg:gap-12 bg-gradient-to-r from-blue-500 to-blue-700 sm:px-8 px-4 py-12 h-[320px]">
            <div>

                <div class="max-w-lg mt-16 max-lg:hidden">
                    <h3 class="text-3xl font-bold text-white">Entre em sua conta:</h3>
                    <p class="text-sm mt-4 text-white">Acesse sua conta para comprar e fazer a gestão de seus pedidos.</p>
                </div>
            </div>

            <div class="bg-white rounded-xl sm:px-6 px-4 py-8 max-w-md w-full h-max shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] max-lg:mx-auto">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-8">
                        <h3 class="text-3xl font-extrabold text-gray-800">Login</h3>
                    </div>


                    <div>
                        <label for="email" class="text-gray-800 text-sm mb-2 block">Email</label>
                        <div class="relative flex items-center">
                            <input id="email" name="email" type="email" required class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-md outline-blue-600 @error('email') border-red-500 @enderror" placeholder="Enter email address" value="{{ old('email') }}" />
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4" viewBox="0 0 24 24">
                                <circle cx="10" cy="7" r="6" data-original="#000000"></circle>
                                <path d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z" data-original="#000000"></path>
                            </svg>
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <label for="password" class="text-gray-800 text-sm mb-2 block">Password</label>
                        <div class="relative flex items-center">
                            <input id="password" name="password" type="password" required class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-md outline-blue-600 @error('password') border-red-500 @enderror" placeholder="Enter password" />
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4 cursor-pointer" viewBox="0 0 128 128">
                                <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z" data-original="#000000"></path>
                            </svg>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mt-4 text-right">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-blue-600 text-sm font-semibold hover:underline">
                                Forgot your password?
                            </a>
                        @endif
                    </div>

                    <div class="mt-8">
                        <button type="submit" class="w-full shadow-xl py-2.5 px-4 text-sm font-semibold rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                            Log in
                        </button>
                    </div>
                    <p class="text-sm mt-6 text-center text-gray-800">Don't have an account <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline ml-1 whitespace-nowrap">Register here</a></p>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

