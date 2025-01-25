<x-app-layout>
    <div class="font-[sans-serif]e p-4 mx-auto max-w-[1400px]">
        <h2 class="font-jersey text-xl sm:text-3xl  text-gray-800 mt-3  ">WHISHLIST</h2>
        <div class="divider mb-3">
    </div>




    @if($wishlistItems->count() > 0)
        <div class="font-[sans-serif]e p-4 mx-auto max-w-[1400px]">
            <h2 class="font-jersey text-xl sm:text-3xl  text-gray-800 mt-3  ">Discos</h2>
            @foreach($wishlistItems as $item)
                @if($item instanceof App\Models\VinylMaster)
                    @include('components.site.wishlist-vinyl', ['vinyl' => $item])
                @elseif($item instanceof App\Models\Equipment)
                    @include('components.site.wishlist-equipment', ['equipment' => $item])
                @endif
            @endforeach
        </div>
    @else
        <p class="text-xl text-gray-600">Sua lista de desejos está vazia.</p>
    @endif
</div>



</x-app-layout>
