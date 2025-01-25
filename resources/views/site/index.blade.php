<x-app-layout>

    <div x-data="{ email: '' }" class="relative font-sans ">
        <div class="absolute inset-0 bg-black opacity-50 z-10"></div>
        <img src="https://therecordhub.com/cdn/shop/articles/realistic-scene-with-vinyl-records-neighborhood-yard-sale_optimized_100_3500x.jpg?v=1719231981" alt="Banner Image" class="absolute inset-0 w-full h-full object-cover object-bottom" />
        <div class="min-h-[400px] relative z-20 h-full max-w-4xl mx-auto flex flex-col justify-center items-center text-center px-6 py-12">
          <div class="max-w-3xl mx-auto text-center">
            <h3 class="text-white md:text-5xl text-4xl font-bold">A embaixada dance music</h3>
            <p class="text-gray-300 text-sm mt-6">Agora é digital, cadastre-se e receba nossas atualizações e ofertas</p>
            <form @submit.prevent="subscribeUser" class="form-control">
            <div class="max-w-lg mx-auto bg-gray-100 flex p-1 rounded-full text-left mt-12 border focus-within:border-gray-700">

              <input type='email' placeholder='Digite seu email' class="w-full outline-none bg-transparent text-sm text-gray-800 px-4 py-3" />
              <button type='button'
                class="bg-gray-800 hover:bg-gray-700 transition-all text-white tracking-wide text-sm rounded-full px-6 py-3">Enviar</button>

            </div>
            </form>
            <p class="mt-4 text-sm text-gray-300">
                Ao se cadastrar, você concorda com nossos <a href="#" class="underline hover:text-white">termos de serviço</a>.
            </p>
          </div>
        </div>
      </div>



    <script>
    function subscribeUser() {
        if (this.email) {
            // Here you would typically send the email to your server
            alert('Inscrito com o email: ' + this.email);
            this.email = ''; // Clear the input after submission
        } else {
            alert('Por favor, insira um email válido.');
        }
    }
    </script>



    <div class="font-[sans-serif]e p-4 mx-auto max-w-[1400px]">
        <h2 class="font-jersey text-xl sm:text-3xl  text-gray-800 mt-3  ">Ultimos discos adicionados</h2>
        <div class="divider mb-3"></div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6">
          @foreach($latestVinyls as $vinyl)
            @include('components.site.vinyl-card', ['vinyl' => $vinyl])
          @endforeach
        </div>
    </div>


</x-app-layout>
