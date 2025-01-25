<div class="p-2 bg-white shadow-[0_2px_9px_-3px_rgba(61,63,68,0.3)] relative">
    <div class="grid sm:grid-cols-2 items-center gap-4">
        <div class="bg-gradient-to-tr from-gray-300 via-gray-100 flex items-center justify-center to-gray-50 w-full h-full p-4 shrink-0 text-center">
            <img src="{{ $vinyl->cover_image }}" alt="{{ $vinyl->title }}" class="w-56 h-full object-contain inline-block" />
        </div>
        <div class="p-2">
            <h3 class="text-lg font-bold text-gray-800">{{ $vinyl->title }}</h3>
            <p class="text-sm text-gray-600 mt-2">{{ $vinyl->artists->pluck('name')->implode(', ') }}</p>
            <ul class="text-sm text-gray-500 space-y-2 list-disc pl-4 mt-4">
                <li>Ano: {{ $vinyl->year }}</li>
                <li>Gravadora: {{ $vinyl->recordLabel->name }}</li>

                <li>Quantidade de faixas: {{ $vinyl->tracks->count() }}</li>
            </ul>
            <div class="flex items-center justify-between flex-wrap gap-4 mt-6">
                <div>
                    <h4 class="text-lg font-bold text-blue-600">R$ {{ number_format($vinyl->vinylSec->price, 2, ',', '.') }}</h4>
                </div>
            </div>
            <div class="divide-x border-y grid grid-cols-3 text-center mt-6">
                <a href="{{ route('site.vinyl.show', ['artistSlug' => $vinyl->artists->first()->slug, 'titleSlug' => $vinyl->slug]) }}" class="bg-transparent hover:bg-gray-100 flex items-center justify-center py-3 text-gray-800 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 fill-current mr-3 inline-block" viewBox="0 0 128 128">
                        <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z" data-original="#000000"></path>
                    </svg>
                    Ver detalhes
                </a>
                <button
                    type="button"
                    class="bg-transparent hover:bg-gray-100 flex items-center justify-center py-3 text-gray-800 text-sm w-full wishlist-button"
                    onclick="toggleFavorite({{ $vinyl->id }}, 'App\\Models\\VinylMaster', this)"
                    data-in-wishlist="true"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 fill-current mr-3 inline-block" viewBox="0 0 390 390">
                        <path d="M30.391 318.583a30.37 30.37 0 0 1-21.56-7.288c-11.774-11.844-11.774-30.973 0-42.817L266.643 10.665c12.246-11.459 31.462-10.822 42.921 1.424 10.362 11.074 10.966 28.095 1.414 39.875L51.647 311.295a30.366 30.366 0 0 1-21.256 7.288z" data-original="#000000"></path>
                        <path d="M287.9 318.583a30.37 30.37 0 0 1-21.257-8.806L8.83 51.963C-2.078 39.225-.595 20.055 12.143 9.146c11.369-9.736 28.136-9.736 39.504 0l259.331 257.813c12.243 11.462 12.876 30.679 1.414 42.922-.456.487-.927.958-1.414 1.414a30.368 30.368 0 0 1-23.078 7.288z" data-original="#000000"></path>
                    </svg>
                    <span>Remover</span>
                </button>
                <button
                                type="button"
                                class="bg-transparent hover:bg-gray-100 flex items-center justify-center py-3 text-gray-800 text-sm w-full"
                                onclick="addToCart({{ $vinyl->product->id }}, 1, this)"
                                {{ $vinyl->vinylSec->quantity > 0 ? '' : 'disabled' }}
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 fill-current mr-3 inline-block" viewBox="0 0 24 24">
                                    <path d="M8 1a2 2 0 0 1 2 2v2h4V3a2 2 0 1 1 4 0v2h3a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h3V3a2 2 0 1 1 4 0v2zm6 0a1 1 0 0 0-1 1v2h2V2a1 1 0 0 0-1-1zM7 2a1 1 0 0 0-1 1v2h2V3a1 1 0 0 0-1-1zm0 6a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm10 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                                </svg>
                                <span class="add-to-cart-text">
                                    {{ $vinyl->vinylSec->quantity > 0 ? 'Adicionar ao carrinho' : 'Fora de estoque' }}
                                </span>
                            </button>
            </div>
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
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateWishlistButton(button, data.added);
            showToast(data.message, data.added ? 'success' : 'info');
        } else {
            throw new Error(data.message || 'Erro ao atualizar a lista de desejos');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast(error.message || 'Ocorreu um erro com sua requisição, tente novamente em outro momento.', 'error');
    });
}

function updateWishlistButton(button, added) {
  const icon = button.querySelector("svg")
  const text = button.querySelector("span")
  if (added) {
    button.dataset.inWishlist = "true"
    button.title = "Remover da lista de desejos"
    icon.classList.remove("text-gray-400", "hover:text-red-500")
    icon.classList.add("text-red-500")
    text.textContent = "Remover"
  } else {
    button.dataset.inWishlist = "false"
    button.title = "Adicionar à lista de desejos"
    icon.classList.remove("text-red-500")
    icon.classList.add("text-gray-400", "hover:text-red-500")
    text.textContent = "Adicionar"

    // Remover o item da wishlist na interface
    const wishlistItem = button.closest('.p-2.bg-white[class*="shadow-[0_2px_9px]"]')
    if (wishlistItem) {
      wishlistItem.remove()
    }

    // Verificar se a wishlist está vazia
    const wishlistContainer = document.querySelector(".lg\\:col-span-2.space-y-6")
    if (wishlistContainer && wishlistContainer.children.length === 0) {
      const emptyMessage = document.createElement("div")
      emptyMessage.className = "p-4 bg-white shadow-[0_2px_9px_-3px_rgba(61,63,68,0.3)] relative"
      emptyMessage.innerHTML = '<p class="text-center text-gray-600">Sua lista de desejos está vazia.</p>'
      wishlistContainer.appendChild(emptyMessage)
    }
  }
}

function addToCart(productId, quantity, button) {
  button.disabled = true
  const originalText = button.querySelector(".add-to-cart-text").textContent
  button.querySelector(".add-to-cart-text").textContent = "Adicionando..."

  fetch('{{ route('site.cart.items.store') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
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
        showToast('Ocorreu um erro ao adicionar o item ao seu carrinho. Por favor, tente novamente mais tarde.', 'error');
    })
    .finally(() => {
        button.disabled = false;
        button.querySelector('.add-to-cart-text').textContent = originalText;
    });
}

function updateCartCount(count) {
  const cartCountElement = document.getElementById("cart-count")
  if (cartCountElement) {
    cartCountElement.textContent = count
  }
}

function showToast(message, type = "info") {
  let backgroundColor, textColor, icon
  switch (type) {
    case "success":
      backgroundColor = "#4CAF50"
      textColor = "#FFFFFF"
      icon = '<i class="fas fa-check-circle mr-2"></i>'
      break
    case "error":
      backgroundColor = "#F44336"
      textColor = "#FFFFFF"
      icon = '<i class="fas fa-exclamation-circle mr-2"></i>'
      break
    default:
      backgroundColor = "#2196F3"
      textColor = "#FFFFFF"
      icon = '<i class="fas fa-info-circle mr-2"></i>'
  }

  Toastify({
    text: icon + message,
    duration: 3000,
    close: true,
    gravity: "top",
    position: "right",
    stopOnFocus: true,
    escapeMarkup: false,
    className: "custom-toast",
    style: {
      background: backgroundColor,
      color: textColor,
    },
    offset: {
      x: 20,
      y: 20,
    },
    onClick: () => {}, // Callback after click
  }).showToast()
}

const style = document.createElement("style")
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
`
document.head.appendChild(style)



</script>
@endpush
