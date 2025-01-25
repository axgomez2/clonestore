@props(['vinyl'])

<div x-data="{
    ...vinylCard({
        id: {{ $vinyl->id }},
        title: '{{ $vinyl->title }}',
        artist: '{{ $vinyl->artists->pluck('name')->implode(', ') }}',
        coverImage: '{{ $vinyl->cover_image }}',
        recordLabel: '{{ $vinyl->recordLabel->name }}',
        year: {{ $vinyl->year }},
        price: {{ $vinyl->vinylSec ? $vinyl->vinylSec->price : 'null' }},
        quantity: {{ $vinyl->vinylSec ? $vinyl->vinylSec->quantity : 0 }},
        inWishlist: {{ $vinyl->inWishlist() ? 'true' : 'false' }},
        tracks: {{ json_encode($vinyl->tracks) }}
    }),
    ...useToast()
}"   class="group relative overflow-hidden rounded-sm shadow-md hover:shadow-xl transition-all duration-300 bg-white transform hover:-translate-y-2">
    <div class="relative aspect-square overflow-hidden">
        <img
            src="{{ $vinyl->cover_image }}"
            alt="{{ $vinyl->title }} by {{ $vinyl->artists->pluck('name')->implode(', ') }}"
            class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-300"

        >
    </div>
    <div class="p-4">
        <a href="{{ route('site.vinyl.show', ['artistSlug' => $vinyl->artists->first()->slug, 'titleSlug' => $vinyl->slug]) }}" class="block flex-grow">
            <h3 class="text-xl font-semibold text-gray-800 hover:text-primary transition-colors duration-200 line-clamp-1">{{ $vinyl->artists->pluck('name')->implode(', ') }}</h3>
            <p class="text-base text-gray-600 line-clamp-1 mt-1">{{ $vinyl->title }}</p>
        </a>

        <div class="flex flex-col mt-4">
            <div class="mb-2">
                <p class="text-xs text-gray-500">SELO: {{ $vinyl->recordLabel->name }}</p>
                <p class="text-xs text-gray-500">ANO: {{ $vinyl->release_year }}</p>
                <p class="text-lg font-bold text-primary mt-1">
                    R$ {{ number_format($vinyl->vinylSec->price, 2, ',', '.') }}
                </p>

            </div>
            <div class="flex justify-between items-center mt-4">


                <button
                    type="button"
                    class="btn btn-primary flex-grow"
                    onclick="addToCart({{ $vinyl->product->id }}, 1, this)"
                    {{ $vinyl->vinylSec->quantity > 0 ? '' : 'disabled' }}
                >
                    <i class="fas fa-shopping-cart mr-2"></i>
                    <span class="add-to-cart-text">
                        {{ $vinyl->vinylSec->quantity > 0 ? 'Add to Cart' : 'Out of Stock' }}
                    </span>
                </button>
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




@push('scripts')
<script>
function toggleFavorite(productId, productType, button) {
    fetch('{{ route('site.wishlist.toggle') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            product_id: productId,
            product_type: productType
        })
    })
    .then(response => {
        if (response.redirected) {
            showToast('Faça login para adicionar aos favoritos.', 'error');

        } else {
            return response.json();
        }
    })
    .then(data => {
        if (data) {
            updateWishlistButton(button, data.added);
            showToast(data.message, data.added ? 'success' : 'info');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Ocorreu um erro com sua requisição, tente novamente em outro momento.', 'error');
    });
}

function updateWishlistButton(button, added) {
    const icon = button.querySelector('i');
    if (added) {
        button.dataset.inWishlist = 'true';
        button.title = 'Remove from wishlist';
        icon.classList.remove('text-gray-400', 'hover:text-red-500');
        icon.classList.add('text-red-500');
    } else {
        button.dataset.inWishlist = 'false';
        button.title = 'Add to wishlist';
        icon.classList.remove('text-red-500');
        icon.classList.add('text-gray-400', 'hover:text-red-500');
    }
}

function addToCart(productId, quantity, button) {
    console.log('Iniciando addToCart para produto:', productId);
    button.disabled = true;
    const originalText = button.querySelector('.add-to-cart-text').textContent;
    button.querySelector('.add-to-cart-text').textContent = 'Adicionando...';

    let csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('CSRF token not found');
        showToast('Erro ao adicionar ao carrinho: CSRF token não encontrado', 'error');
        button.disabled = false;
        button.querySelector('.add-to-cart-text').textContent = originalText;
        return;
    }
    csrfToken = csrfToken.getAttribute('content');

    fetch('{{ route('site.cart.items.store') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => {
        console.log('Resposta recebida:', response);
        if (!response.ok) {
            if (response.status === 401) {
                throw new Error('Unauthorized');
            }
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Dados recebidos:', data);
        if (data.success) {
            showToast(data.message, 'success');
            if (data.cartCount !== undefined) {
                updateCartCount(data.cartCount);
            }
        } else {
            showToast(data.message || 'Erro ao adicionar ao carrinho', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (error.message === 'Unauthorized') {
            showToast('Por favor, faça login para adicionar itens ao carrinho.', 'error');
        } else {
            showToast('Ocorreu um erro ao adicionar o item ao seu carrinho. Por favor, tente novamente mais tarde.', 'error');
        }
    })
    .finally(() => {
        button.disabled = false;
        button.querySelector('.add-to-cart-text').textContent = originalText;
    });
}

function updateCartCount(count) {
    const cartCountElement = document.getElementById('cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = count;
    }
}

function showToast(message, type = 'info') {
    let backgroundColor, textColor, icon;
    switch (type) {
        case 'success':
            backgroundColor = '#4CAF50';
            textColor = '#FFFFFF';
            icon = '<i class="fas fa-check-circle mr-2"></i>';
            break;
        case 'error':
            backgroundColor = '#F44336';
            textColor = '#FFFFFF';
            icon = '<i class="fas fa-exclamation-circle mr-2"></i>';
            break;
        default:
            backgroundColor = '#2196F3';
            textColor = '#FFFFFF';
            icon = '<i class="fas fa-info-circle mr-2"></i>';
    }

    Toastify({
        text: icon + message,
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        stopOnFocus: true,
        escapeMarkup: false,
        className: 'custom-toast',
        style: {
            background: backgroundColor,
            color: textColor,
        },
        offset: {
            x: 20,
            y: 20
        },
        onClick: function(){} // Callback after click
    }).showToast();
}

const style = document.createElement('style');
style.textContent = `
    .custom-toast {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 4px;
        padding: 12px 20px;
        font-size: 14px;
        font-weight: 500;
        animation: slideInRight 0.3s ease-in-out, fadeOut 0.3s ease-in-out 2.7s;
    }
    .custom-toast .toast-close {
        opacity: 0.7;
        font-size: 16px;
        padding-left: 10px;
    }
    .custom-toast .toast-close:hover {
        opacity: 1;
    }
    @keyframes slideInRight {
        from { transform: translateX(100%); }
        to { transform: translateX(0); }
    }
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
`;
document.head.appendChild(style);
</script>
@endpush
