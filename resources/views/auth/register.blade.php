<x-app-layout>
    <div class="font-[sans-serif] p-4 mt-6">
        <div class="flex flex-col justify-center  ">
            <div class="max-w-md w-full bg-white mx-auto shadow-[0_2px_10px_-2px_rgba(195,169,50,0.5)] p-8 relative mt-12">
                <div class=" w-24 h-24 border-[8px] p-4 absolute left-0 right-0 mx-auto -top-12 rounded-full overflow-hidden">
                    <a href="{{ route('site.home') }}">
                        <img src="https://readymadeui.com/readymadeui-short.svg" alt="logo" class='w-full inline-block' />
                    </a>
                </div>

                <form method="POST" action="{{ route('register') }}" class="mt-12">
                    @csrf
                    <h3 class="text-xl font-bold text-blue-600 mb-6 text-center">Create free account</h3>
                    <div class="space-y-4">
                        <input id="name" name="name" type="text" class="bg-gray-100 w-full text-sm text-gray-800 px-4 py-3 focus:bg-transparent border border-gray-100 focus:border-black outline-none transition-all @error('name') border-red-500 @enderror" placeholder="Enter name" value="{{ old('name') }}" required autocomplete="name" autofocus />
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <input id="email" name="email" type="email" class="bg-gray-100 w-full text-sm text-gray-800 px-4 py-3 focus:bg-transparent border border-gray-100 focus:border-black outline-none transition-all @error('email') border-red-500 @enderror" placeholder="Enter email" value="{{ old('email') }}" required autocomplete="email" />
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <input id="password" name="password" type="password" class="bg-gray-100 w-full text-sm text-gray-800 px-4 py-3 focus:bg-transparent border border-gray-100 focus:border-black outline-none transition-all @error('password') border-red-500 @enderror" placeholder="Enter password" required autocomplete="new-password" />
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <input id="password_confirmation" name="password_confirmation" type="password" class="bg-gray-100 w-full text-sm text-gray-800 px-4 py-3 focus:bg-transparent border border-gray-100 focus:border-black outline-none transition-all" placeholder="Enter confirm password" required autocomplete="new-password" />

                        <div class="flex items-center">
                            <input id="terms" name="terms" type="checkbox" class="h-4 w-4 shrink-0 border-gray-300 rounded @error('terms') border-red-500 @enderror" required />
                            <label for="terms" class="ml-3 block text-sm text-gray-800">
                                I accept the <a href="#" class="text-blue-600 font-semibold hover:underline ml-1">Terms and Conditions</a>
                            </label>
                        </div>
                        @error('terms')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full py-3 px-4 text-sm tracking-wide text-white bg-black hover:bg-[#111] focus:outline-none">
                            Create an account
                        </button>
                    </div>
                    <p class="text-sm mt-6 text-center text-gray-800">Already have an account? <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline ml-1">Login here</a></p>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

