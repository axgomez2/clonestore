<x-app-layout>
    <div class="font-sans p-4 bg-gray-100" x-data="{
        isFavorite: {{ $vinyl->inWishlist() ? 'true' : 'false' }},
        currentImage: 0,
        images: [
            '{{ asset('storage/' . $vinyl->cover_image) }}',
            'https://readymadeui.com/images/sunscreen-img-1.webp',
            'https://readymadeui.com/images/sunscreen-img-2.webp',
            'https://readymadeui.com/images/sunscreen-img-3.webp',
            'https://readymadeui.com/images/sunscreen-img-4.webp',
            'https://readymadeui.com/images/sunscreen-img-5.webp'
        ],
        toggleFavorite() {
            this.isFavorite = !this.isFavorite;
            fetch('/api/toggle-favorite', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify({
                    id: {{ $vinyl->id }},
                    type: 'App\\Models\\VinylMaster'
                })
            });
        },
        nextImage() {
            this.currentImage = (this.currentImage + 1) % this.images.length;
        },
        prevImage() {
            this.currentImage = (this.currentImage - 1 + this.images.length) % this.images.length;
        },
        setImage(index) {
            this.currentImage = index;
        }
    }"
    x-init="
        document.addEventListener('alpine:init', () => {
            Alpine.data('audioPlayer', audioPlayerData);
        });
    "
    >
        <div class="lg:max-w-6xl max-w-xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="grid items-start grid-cols-1 lg:grid-cols-2 gap-8 max-lg:gap-12 max-sm:gap-8">
                <div class="w-full sticky top-0">
                    <div class="flex flex-col gap-4">
                        <div class="bg-white shadow p-4 mt-6 relative">
                            <img :src="images[currentImage]" alt="{{ $vinyl->title }}"
                                class="w-full aspect-square object-cover object-center" />
                            <button @click="toggleFavorite"
                                    class="absolute top-6 right-6 p-2 bg-white rounded-full shadow-md hover:bg-gray-100 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :class="{ 'text-red-500 fill-current': isFavorite, 'text-gray-400': !isFavorite }" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                            <button @click="prevImage" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-md hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button @click="nextImage" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-md hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                        <div class="bg-white p-2 w-full max-w-full overflow-auto">
                            <div class="flex justify-between flex-row gap-4 shrink-0">
                                <template x-for="(image, index) in images" :key="index">
                                    <img :src="image" :alt="`Product ${index + 1}`"
                                        class="w-16 h-16 aspect-square object-cover object-top cursor-pointer shadow-md"
                                        :class="{ 'border-b-2 border-black': currentImage === index, 'border-b-2 border-transparent': currentImage !== index }"
                                        @click="setImage(index)" />
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full">
                    <div class="mt-8">
                        <h3 class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $vinyl->artists->pluck('name')->implode(', ') }}</h3>
                        <h3 class="text-xl sm:text-2xl text-gray-700 mt-2">{{ $vinyl->title }}</h3>
                        <div class="mt-4 space-y-2">
                            <p class="text-base text-gray-600"><span class="font-semibold">Label:</span> {{ $vinyl->recordLabel->name }}</p>
                            <p class="text-base text-gray-600"><span class="font-semibold">Ano:</span> {{ $vinyl->release_year }}</p>
                            <p class="text-base text-gray-600"><span class="font-semibold">País:</span> {{ $vinyl->country }}</p>
                        </div>

                        <div class="mt-6">
                            <h2 class="text-xl font-semibold mb-2">Gênero:</h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach($vinyl->genres as $genre)
                                    <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-sm">{{ $genre->name }}</span>
                                @endforeach
                                @foreach($vinyl->styles as $style)
                                    <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm">{{ $style->name }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="flex items-center flex-wrap gap-2 mt-8">
                            <p class="text-gray-500 text-base"><strike>R$ {{ number_format($vinyl->vinylSec->price * 1.2, 2, ',', '.') }}</strike></p>
                            <h4 class="text-stone-800 text-2xl sm:text-3xl font-bold">R$ {{ number_format($vinyl->vinylSec->price, 2, ',', '.') }}</h4>
                            <div class="flex py-1 px-2 bg-amber-600 font-semibold ml-4">
                                <span class="text-white text-sm">oferta</span>
                            </div>
                        </div>

                        <div class="mt-8 flex flex-wrap gap-4">
                            <button type="button"
                                class="btn btn-outline btn-primary flex-grow"
                                @click="$dispatch('add-to-cart', { id: {{ $vinyl->product->id }}, quantity: 1 })"
                            >
                                Adicinar ao carrinho
                            </button>
                            <button type="button"
                                class="btn btn-primary flex-grow"
                            >
                                Compre agora
                            </button>
                        </div>
                        @if($vinyl->description)
                            <div class="mt-8">
                                <h2 class="text-2xl font-bold mb-4">Descrição</h2>
                                <p class="text-gray-700">{{ $vinyl->description }}</p>
                            </div>
                        @endif



                        <hr class="my-8 border-gray-300" />

                        <h2 class="text-2xl font-bold mb-4">Tracks</h2>
                        <div class="overflow-x-auto">
                            <table class="table w-full">
                                <thead>
                                    <tr>
                                        <th class="text-left">#</th>
                                        <th class="text-left">Faixa</th>
                                        <th class="text-left">Duração</th>
                                        <th class="text-left">##</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($vinyl->tracks as $track)
                                        <tr class="hover:bg-gray-100">
                                            <td>{{ $track->position }}</td>
                                            <td>{{ $track->name }}</td>
                                            <td>{{ $track->duration ?? 'N/A' }}</td>
                                            <td>
                                                @if($track->youtube_url)
                                                    <button
                                                        class="btn btn-sm btn-circle btn-ghost track-play-button"
                                                        data-vinyl-id="{{ $vinyl->id }}"
                                                        data-vinyl-title="{{ $vinyl->title }}"
                                                        data-artist="{{ $vinyl->artists->pluck('name')->implode(', ') }}"
                                                        data-tracks="{{ json_encode([$track]) }}"
                                                        x-on:click="$store.audioPlayer.loadTrack({
                                                            id: {{ $track->id }},
                                                            name: '{{ $track->name }}',
                                                            artist: '{{ $vinyl->artists->pluck('name')->implode(', ') }}',
                                                            youtube_url: '{{ $track->youtube_url }}'
                                                        }, {{ json_encode($vinyl->tracks) }})"
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                @else
                                                    <span class="text-gray-400">N/A</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>



                        <hr class="my-8 border-gray-300" />

                        <div class="flex justify-between gap-4 mt-6">
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-purple-600 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <p class='text-gray-500 text-xs sm:text-sm mt-3'>COD available</p>
                            </div>
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-purple-600 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <p class='text-gray-500 text-xs sm:text-sm mt-3'>15-Day Return Policy</p>
                            </div>
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-purple-600 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                </svg>
                                <p class='text-gray-500 text-xs sm:text-sm mt-3'>Free Delivery On Orders Above $100</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>








      <!-- Audio Player -->
      {{-- <div id="custom-player" class="fixed bottom-0 left-0 right-0 bg-slate-300 border-t border-base-300 p-4 hidden z-50" x-data="audioPlayer">
        <div class="container mx-auto">
            <div class="flex items-center gap-4">
                <!-- Controles de reprodução -->
                <div class="flex items-center gap-2">
                    <button id="prev-button" class="btn btn-circle btn-sm" @click="playPrevious" :class="{ 'disabled': currentTrackIndex === 0 }">
                        <i class="fas fa-step-backward"></i>
                    </button>
                    <button id="play-button" class="btn btn-circle btn-primary" @click="togglePlay">
                        <i class="fas" :class="isPlaying ? 'fa-pause' : 'fa-play'"></i>
                    </button>
                    <button id="next-button" class="btn btn-circle btn-sm" @click="playNext" :class="{ 'disabled': currentTrackIndex === playlist.length - 1 }">
                        <i class="fas fa-step-forward"></i>
                    </button>
                </div>

                <!-- Informações da faixa -->
                <div class="flex-1">
                    <div id="track-title" class="text-sm font-medium" x-text="currentTrack?.name"></div>
                    <div id="track-artist" class="text-xs text-base-content/60" x-text="currentTrack?.artist"></div>
                </div>

                <!-- Barra de progresso -->
                <div class="flex-1">
                    <div id="progress-container" class="h-2 bg-base-300 rounded-full cursor-pointer" @click="seek">
                        <div id="progress-bar" class="h-full bg-primary rounded-full" :style="{ width: `${progress}%` }"></div>
                    </div>
                    <div class="flex justify-between text-xs mt-1">
                        <span id="current-time" x-text="formatTime(currentTime)"></span>
                        <span id="duration" x-text="formatTime(duration)"></span>
                    </div>
                </div>

                <!-- Controle de volume -->
                <div class="flex items-center gap-2">
                    <button id="volume-button" class="btn btn-ghost btn-sm btn-circle" @click="toggleMute">
                        <i class="fas" :class="volumeIcon"></i>
                    </button>
                    <input
                        type="range"
                        id="volume-slider"
                        min="0"
                        max="1"
                        step="0.1"
                        x-model="volume"
                        @input="setVolume($event.target.value)"
                        class="range range-xs range-primary w-20"
                    >
                </div>
            </div>
        </div>
        <div id="youtube-player"></div>
    </div> --}}
</div>


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Vinyl details script loaded');

            const playButtons = document.querySelectorAll('.track-play-button');
            console.log('Found ' + playButtons.length + ' play buttons');

            playButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    let trackData;
                    try {
                        trackData = JSON.parse(this.dataset.track);
                    } catch (error) {
                        console.error('Error parsing track data:', error);
                        return;
                    }

                    trackData.artist = this.dataset.artist;
                    trackData.vinylTitle = this.dataset.vinylTitle;

                    console.log('Track data:', trackData);
                    if (trackData.youtube_url) {
                        console.log('Loading track');
                        if (typeof audioPlayer !== 'undefined' && audioPlayer.loadTrack) {
                            audioPlayer.loadTrack(trackData);
                        } else {
                            console.error('audioPlayer não está disponível ou não tem o método loadTrack');
                        }
                    } else {
                        console.error('No YouTube URL available for this track');
                    }
                });
            });
        });
    </script>
    @endpush

</x-app-layout>
