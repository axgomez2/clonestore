<div x-data="{ isOpen: false, isSearchOpen: false }" class="bg-zinc-100 shadow-lg">
    <div class="container mx-auto px-4 ">
        <nav class="flex items-center justify-between  h-24">
            <!-- Logo e Toggle do Menu Mobile -->
            <div class="flex items-center">
                <button
                    @click="isOpen = !isOpen"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 lg:hidden hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
                >
                    <svg
                        class="h-7 w-7"
                        x-show="!isOpen"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg
                        class="h-6 w-6"
                        x-show="isOpen"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <a href="{{ route('site.home') }}" class="flex items-center  bg-slate-800  ml-4">
                   <img src="{{ asset('assets/images/logo_embaixada.png') }}" alt="logo" class='h-10 sm:h-18 md:h-14 lg:h-16' />
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex lg:items-center lg:space-x-8">
                <a href="#" class="text-gray-600 hover:text-gray-900">Novo</a>
                <a href="#" class="text-gray-600 hover:text-gray-900">Masculino</a>
                <a href="#" class="text-gray-600 hover:text-gray-900">Feminino</a>
                <a href="#" class="text-gray-600 hover:text-gray-900">Infantil</a>
            </div>

            <!-- Right Side Icons -->
            <div class="flex items-center space-x-4">
                <!-- Search Button (Desktop and Mobile) -->
                <button
                    @click="isSearchOpen = !isSearchOpen"
                    class="p-1 text-gray-700 hover:text-gray-900"
                >
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <!-- Wishlist -->
                <a href="#" class="relative p-1 text-gray-700 hover:text-gray-900">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-slate-800 rounded-full">0</span>
                </a>

                <!-- Cart -->
                <a href="#" class="relative p-1 text-gray-700 hover:text-gray-900">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-slate-800 rounded-full">0</span>
                </a>

                <!-- Auth -->
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                            <span class="text-gray-700 text-sm font-medium">{{ Auth::user()->name }}</span>
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-10">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Perfil</a>
                            {{-- <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Configurações</a> --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                <div class="flex w-full flex-col lg:flex-row ">
                    <div class="card  rounded-box grid  flex-grow place-items-center hidden sm:block">
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Login
                    </a></div>
                    <div class="divider lg:divider-horizontal hidden sm:block"></div>
                    <div class="card  rounded-box grid  flex-grow place-items-center hidden sm:block">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Cadastre-se
                    </a></div>
                  </div>

                <div x-data="{ open: false }" class="sm:hidden relative">
                    <!-- Botão do dropdown -->
                    <button @click="open = !open" @click.away="open = false" class="flex items-center justify-center  w-10 h-10 text-gray-500 hover:text-gray-600 focus:outline-none">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                      </svg>
                    </button>

                    <!-- Conteúdo do dropdown -->
                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                      <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-300">Login</a>
                      <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-300">Cadastro</a>
                    </div>
                  </div>

                @endauth
            </div>
        </nav>

        <!-- Search Bar (Desktop and Mobile) -->
        <div
            x-show="isSearchOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="py-4"
        >
            <div class="relative">
                <input
                    type="text"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Buscar produtos..."
                >
                <button class="absolute right-3 top-1/2 transform -translate-y-1/2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div
            x-show="isOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-x-full"
            x-transition:enter-end="opacity-100 transform translate-x-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 transform translate-x-0"
            x-transition:leave-end="opacity-0 transform -translate-x-full"
            class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg z-50 lg:hidden"
            @click.away="isOpen = false"
        >
            <div class="flex flex-col h-full">
                <div class="flex items-center justify-between p-4 border-b">
                    <span class="text-xl font-semibold text-gray-800">Menu</span>
                    <button @click="isOpen = false" class="text-gray-500 hover:text-gray-600 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <nav class="flex-grow overflow-y-auto p-4">
                    <div class="space-y-1">
                        <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Novo</a>
                        <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Masculino</a>
                        <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Feminino</a>
                        <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Infantil</a>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Mobile Menu Overlay -->
        <div
            x-show="isOpen"
            class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"
            @click="isOpen = false"
        ></div>
    </div>
</div>

