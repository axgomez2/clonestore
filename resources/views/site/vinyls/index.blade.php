<x-app-layout>

    <div class="font-[sans-serif]e p-4 mx-auto max-w-[1400px] rounded-lg bg-slate-800 mt-5">
        <h2 class="text-xl font-bold mb-6 text-white">Filtros</h2  >

            <form action="{{ route('site.vinyls.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6">

                    <div>
                        <label for="style" class="block text-sm font-medium text-white">Estilo</label>
                        <select name="style" id="style" class="select select-bordered w-full max-w-xs mt-2">
                            <option value="">Todos os estilos</option>
                            @foreach($styles as $style)
                                <option value="{{ $style->id }}" {{ request('style') == $style->id ? 'selected' : '' }}>{{ $style->name }}</option>
                            @endforeach
                        </select>
                    </div>



                    <div>
                        <label for="price_range" class="block text-sm font-medium text-white">Faixa de Preço</label>
                        <div class="flex items-center space-x-4">
                            <input type="range" name="min_price" id="min_price" min="{{ $priceRange->min_price }}" max="{{ $priceRange->max_price }}" step="0.01" value="{{ request('min_price', default: $priceRange->min_price) }}" class="range mt-5 [--range-shdw:yellow]"">
                            <input type="range" name="max_price" id="max_price" min="{{ $priceRange->min_price }}" max="{{ $priceRange->max_price }}" step="0.01" value="{{ request('max_price', $priceRange->max_price) }}" class="range mt-5 [--range-shdw:yellow]">
                        </div>
                        <div class="flex justify-between ">
                            <span id="min_price_display " class="text-white">R$ {{ number_format(request('min_price', $priceRange->min_price), 2, ',', '.') }}</span>
                            <span id="max_price_display " class="text-white">R$ {{ number_format(request('max_price', $priceRange->max_price), 2, ',', '.') }}</span>
                        </div>
                    </div>
                    <div><label for="sort_by" class="block text-sm font-medium text-white">Ordenar por</label>
                        <select name="sort_by" id="sort_by" class="select select-bordered w-full max-w-xs mt-2">
                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Data de adição</option>
                            <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Preço</option>
                            <option value="release_year" {{ request('sort_by') == 'release_year' ? 'selected' : '' }}>Ano de lançamento</option>
                            <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Título</option>
                        </select></div>
                        <div class="">
                            <label for="sort_order" class="block text-sm font-medium text-white">Ordem</label>
                        <select name="sort_order" id="sort_order" class="select select-bordered w-full max-w-xs mt-2">
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Crescente</option>
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Decrescente</option>
                        </select>
                        </div>
                        <div class=""><button type="submit" class="btn btn-wide mt-7">
                            Aplicar Filtros
                        </button>
                    </div>
                </div>
            </form>

    </div>




<div class="font-[sans-serif]e p-4 mx-auto max-w-[1400px]">
    <h2 class="font-jersey text-xl sm:text-3xl  text-gray-800 mt-3  ">Todos os discos</h2>
    <div class="divider mb-3"></div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6">
@foreach($vinyls as $vinyl)



        <div x-data="vinylCard()" class="group relative overflow-hidden rounded-sm shadow-md hover:shadow-xl transition-all duration-300 bg-white transform hover:-translate-y-2">
        <div class="relative aspect-square overflow-hidden">
            <img
                src="{{ $vinyl->cover_image }}"
                alt="{{ $vinyl->title }} by {{ $vinyl->artists->pluck('name')->implode(', ') }}"
                class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-300"
                onerror="this.src='{{ asset('images/default-album-cover.jpg') }}'"
            >
        </div>
            <div class="p-4">
            <a href="{{ route('site.vinyl.show', ['artistSlug' => $vinyl->artists->first()->slug, 'titleSlug' => $vinyl->slug]) }}" class="block flex-grow">
                <h3 class="text-xl font-semibold text-gray-800 hover:text-primary transition-colors duration-200 line-clamp-1">{{ $vinyl->artists->pluck('name')->implode(', ') }}</h3>
                <p class="text-base text-gray-600 line-clamp-1 mt-1">{{ $vinyl->title }}</p>
            </a>

            <div class="flex flex-col mt-3">
                <div class="mb-2">
                    <p class="text-xs text-gray-500">{{ $vinyl->recordLabel->name }}</p>
                    <p class="text-xs text-gray-500">{{ $vinyl->release_year }}</p>
                    @if($vinyl->vinylSec)

                    <p class="text-lg font-bold text-primary mt-1">R$ {{ number_format($vinyl->vinylSec->price, 2, ',', '.') }}</p>
                    @else
                    <p class="text-lg font-bold text-primary mt-1">sem estoque</p>
                    @endif


                </div>
                <div class="flex justify-between items-center mt-3">
                    @if($vinyl->vinylSec)
                    <button type="button" class="btn btn-outline flex-grow" onclick="addToCart({{ $vinyl->product->id }}, 1, this)">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="add-to-cart-text truncate">
                            adicionar ao carrinho
                        </span>
                    </button>
                    @else
                    <span class="add-to-cart-text">
                        <button type="button" class="btn btn-outline flex-grow" >

                            <span class="add-to-cart-text cursor-not-allowed">
                                produto indisponivel
                            </span>
                        </button>
                    </span>
                    @endif
                    <button
                        type="button"
                        title="{{ $vinyl->inWishlist() ? 'Remove from wishlist' : 'Add to wishlist' }}"
                        class="wishlist-button ml-2 p-2 bg-gray-100 hover:bg-gray-200 rounded-full focus:outline-none transition-colors duration-200"
                        onclick="toggleFavorite({{ $vinyl->id }}, 'App\\Models\\VinylMaster', this)"
                        data-in-wishlist="{{ $vinyl->inWishlist() ? 'true' : 'false' }}"
                    >
                        <i class="fas fa-heart text-xl {{ $vinyl->inWishlist() ? 'text-red-500' : 'text-gray-400 hover:text-red-500' }}"></i>
                    </button>
                </div>
                <button
                    x-ref="playButton"
                    class="track-play-button mt-4 w-full flex items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded transition-colors duration-300"
                    @click="playVinylTracks"
                    data-vinyl-id="{{ $vinyl->id }}"
                    data-vinyl-title="{{ $vinyl->title }}"
                    data-artist="{{ $vinyl->artists->pluck('name')->implode(', ') }}"
                    data-tracks="{{ json_encode($vinyl->tracks) }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Play
                </button>
            </div>
            </div>
        </div>

@endforeach

    </div></div>

















        <div class="mt-8">
            {{ $vinyls->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const minPriceInput = document.getElementById('min_price');
            const maxPriceInput = document.getElementById('max_price');
            const minPriceDisplay = document.getElementById('min_price_display');
            const maxPriceDisplay = document.getElementById('max_price_display');

            function updatePriceDisplay(input, display) {
                display.textContent = 'R$ ' + parseFloat(input.value).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }

            minPriceInput.addEventListener('input', function() {
                updatePriceDisplay(minPriceInput, minPriceDisplay);
            });

            maxPriceInput.addEventListener('input', function() {
                updatePriceDisplay(maxPriceInput, maxPriceDisplay);
            });
        });
    </script>

</x-app-layout>
