@extends('layouts.admin')

@section('title', 'Create New Vinyl')

@section('content')
<div class="container-xl">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pesquisar novo disco:</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Passo 1 - busca no discogs:</h3>
                            <form action="{{ route('admin.vinyls.create') }}" method="GET" id="searchForm">
                                <div class="row g-2 align-items-center">
                                    <div class="col">
                                        <input type="text" name="query" value="{{ $query }}" class="form-control" placeholder="encontre o disco pelo artista, titulo ou codigo do disco">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <circle cx="10" cy="10" r="7"></circle>
                                                <line x1="21" y1="21" x2="15" y2="15"></line>
                                            </svg>
                                            Clique para pesquisar
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div id="loadingBar" class="progress mt-3 d-none">
                                <div class="progress-bar progress-bar-indeterminate bg-primary"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($selectedRelease)
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Você selecionou o disco: {{ $selectedRelease['title'] }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    @if(isset($selectedRelease['images']))
                                        <img src="{{ $selectedRelease['images'][0]['uri'] }}" alt="{{ $selectedRelease['title'] }}" class="img-fluid rounded mb-3">
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <div class="datagrid mb-4">
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Artista</div>
                                            <div class="datagrid-content">{{ implode(', ', array_column($selectedRelease['artists'], 'name')) }}</div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Título</div>
                                            <div class="datagrid-content">{{ $selectedRelease['title'] }}</div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Ano</div>
                                            <div class="datagrid-content">{{ $selectedRelease['year'] }}</div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Gênero</div>
                                            <div class="datagrid-content">{{ implode(', ', $selectedRelease['genres'] ?? []) }}</div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Estilos</div>
                                            <div class="datagrid-content">{{ implode(', ', $selectedRelease['styles'] ?? []) }}</div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">País de Origem</div>
                                            <div class="datagrid-content">{{ $selectedRelease['country'] }}</div>
                                        </div>
                                        @if(isset($selectedRelease['labels']))
                                            <div class="datagrid-item">
                                                <div class="datagrid-title">Gravadora</div>
                                                <div class="datagrid-content">{{ implode(', ', array_column($selectedRelease['labels'], 'name')) }}</div>
                                            </div>
                                        @endif
                                        @if(isset($selectedRelease['master_id']))
                                            <div class="datagrid-item">
                                                <div class="datagrid-title">Master ID - interno</div>
                                                <div class="datagrid-content">{{ $selectedRelease['master_id'] }}</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <h4 class="card-title mt-4 mb-3">Informações de Mercado (Discogs)</h4>
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th>Métrica</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($selectedRelease['community']['have']))
                                            <tr>
                                                <td>Quantidade em coleções</td>
                                                <td>{{ $selectedRelease['community']['have'] }}</td>
                                            </tr>
                                        @endif
                                        @if(isset($selectedRelease['num_for_sale']))
                                            <tr>
                                                <td>Quantidade à venda</td>
                                                <td>{{ $selectedRelease['num_for_sale'] }}</td>
                                            </tr>
                                        @endif
                                        @if(isset($selectedRelease['lowest_price']))
                                            <tr>
                                                <td>Preço mais baixo</td>
                                                <td>{{ $selectedRelease['lowest_price'] }} {{ $selectedRelease['price_currency'] ?? 'USD' }}</td>
                                            </tr>
                                        @endif
                                        @if(isset($selectedRelease['median_price']))
                                            <tr>
                                                <td>Preço médio</td>
                                                <td>{{ $selectedRelease['median_price'] }} {{ $selectedRelease['price_currency'] ?? 'USD' }}</td>
                                            </tr>
                                        @endif
                                        @if(isset($selectedRelease['highest_price']))
                                            <tr>
                                                <td>Preço mais alto</td>
                                                <td>{{ $selectedRelease['highest_price'] }} {{ $selectedRelease['price_currency'] ?? 'USD' }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                <a href="{{ $selectedRelease['uri'] }}" target='_blank' class="btn btn-danger">Link do disco no Discogs</a>
                            </div>

                            @if(isset($selectedRelease['formats']))
                                <div class="mt-4">
                                    <h4 class="card-title mb-2">Formato</h4>
                                    <div class="tags">
                                        @foreach($selectedRelease['formats'] as $format)
                                            <span class="tag">
                                                {{ $format['name'] }}
                                                @if(isset($format['descriptions']))
                                                    <span class="tag-addon">{{ implode(', ', $format['descriptions']) }}</span>
                                                @endif
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if(isset($selectedRelease['notes']))
                                <div class="mt-4">
                                    <h4 class="card-title mb-2">Notas e observações</h4>
                                    <div class="text-muted">{{ $selectedRelease['notes'] }}</div>
                                </div>
                            @endif

                            @if(isset($selectedRelease['identifiers']))
                                <div class="mt-4">
                                    <h4 class="card-title mb-2">Identificadores</h4>
                                    <div class="table-responsive">
                                        <table class="table table-vcenter table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Tipo</th>
                                                    <th>Nome</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($selectedRelease['identifiers'] as $identifier)
                                                    <tr>
                                                        <td>{{ $identifier['type'] }}</td>
                                                        <td>{{ $identifier['value'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            @if(isset($selectedRelease['tracklist']))
                                <div class="mt-4">
                                    <h4 class="card-title mb-2">Tracklist</h4>
                                    <ol class="list-group list-group-numbered">
                                        @foreach($selectedRelease['tracklist'] as $track)
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div>{{ $track['title'] }}</div>
                                                </div>
                                                <span class="badge bg-primary rounded-pill">{{ $track['duration'] }}</span>
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                            @endif

                            <div class="d-grid gap-2 mt-4">
                                <button id="saveVinylBtn" class="btn btn-primary" data-release-id="{{ $selectedRelease['id'] }}">
                                    <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                                    Salvar disco
                                </button>
                                <a href="{{ route('admin.vinyls.create') }}" class="btn btn-secondary">Voltar para busca</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @elseif(count($searchResults) > 0)
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Resultados da Busca</h3>
                                <div class="d-flex align-items-center" style="padding-left: 50px;">
                                    <select id="formatFilter" class="form-select form-select-sm">
                                        <option value="">Todos os Formatos</option>
                                    </select>
                                    <div class="mx-4"></div>
                                    <select id="countryFilter" class="form-select form-select-sm">
                                        <option value="">Todos os Países</option>
                                    </select>
                                    <div class="mx-4"></div>
                                    <select id="yearFilter" class="form-select form-select-sm">
                                        <option value="">Todos os Anos</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                @foreach($searchResults as $result)
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <a href="{{ route('admin.vinyls.create', ['release_id' => $result['id'], 'query' => $query]) }}">
                                                    <span class="avatar avatar-md" style="background-image: url({{ $result['thumb'] ?? '/placeholder-image.jpg' }})"></span>
                                                </a>
                                            </div>
                                            <div class="col text-truncate">
                                                <a href="{{ route('admin.vinyls.create', ['release_id' => $result['id'], 'query' => $query]) }}" class="text-reset d-block text-truncate">{{ $result['title'] }}</a>
                                                <div class="d-flex align-items-center mt-1">
                                                    <div class="text-muted">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <rect x="4" y="4" width="16" height="16" rx="2" />
                                                            <circle cx="12" cy="12" r="4" />
                                                            <path d="M12 12l0 .01" />
                                                        </svg>
                                                        {{ $result['year'] ?? 'Year unknown' }}
                                                    </div>
                                                    @if(isset($result['formats']))
                                                        <div class="text-muted ms-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <path d="M16.5 17.5m-3.5 0a3.5 3.5 0 1 0 7 0a3.5 3.5 0 1 0 -7 0" />
                                                                <path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                                                <path d="M16.5 17.5l0 .01" />
                                                                <path d="M11.5 20l6 -6" />
                                                            </svg>
                                                            {{ $result['formats'][0]['name'] ?? 'Format unknown' }}
                                                        </div>
                                                    @endif
                                                    @if(isset($result['country']))
                                                        <div class="text-muted ms-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <circle cx="12" cy="12" r="9" />
                                                                <line x1="3.6" y1="9" x2="20.4" y2="9" />
                                                                <line x1="3.6" y1="15" x2="20.4" y2="15" />
                                                                <path d="M11.5 3a17 17 0 0 0 0 18" />
                                                                <path d="M12.5 3a17 17 0 0 1 0 18" />
                                                            </svg>
                                                            {{ $result['country'] }}
                                                        </div>
                                                    @endif
                                                    @if(isset($result['label']))
                                                        <div class="text-muted ms-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <rect x="4" y="4" width="16" height="16" rx="2" />
                                                                <path d="M8 8h8v8h-8z" />
                                                            </svg>
                                                            {{ is_array($result['label']) ? $result['label'][0] : $result['label'] }}
                                                        </div>
                                                    @endif
                                                    @if(isset($result['cat']))
                                                        <div class="text-muted ms-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <rect x="4" y="4" width="16" height="16" rx="2" />
                                                                <path d="M8 8h8v8h-8z" />
                                                            </svg>
                                                            {{ is_array($result['cat']) ? $result['cat'][0] : $result['cat'] }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{ route('admin.vinyls.create', ['release_id' => $result['id'], 'query' => $query]) }}" class="btn btn-icon btn-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M5 12l5 5l10 -10" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @elseif($query)
                <div class="alert alert-info mt-4" role="alert">
                    Nenhum resultado encontrado para "{{ $query }}".
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('searchForm');
    const loadingBar = document.getElementById('loadingBar');
    const saveBtn = document.getElementById('saveVinylBtn');

    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            loadingBar.classList.remove('d-none');
        });
    }

    if (saveBtn) {
        saveBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const releaseId = this.dataset.releaseId;
            const spinner = this.querySelector('.spinner-border');
            const buttonText = this.textContent;

            // Show loading indicator
            spinner.classList.remove('d-none');
            this.textContent = 'Salvando...';
            this.disabled = true;

            fetch('{{ route('admin.vinyls.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ release_id: releaseId })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Resposta da rede não foi ok');
                }
                return response.json();
            })
            .then(data => {
                alert(data.message);
                if (data.status === 'success') {
                    window.location.href = '{{ route('admin.vinyls.index') }}';
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Ocorreu um erro ao salvar o disco. Por favor, tente novamente.');
            })
            .finally(() => {
                // Hide loading indicator
                spinner.classList.add('d-none');
                this.textContent = buttonText;
                this.disabled = false;
            });
        });
    }

    if (document.querySelector('.list-group-flush')) {
        const formatFilter = document.getElementById('formatFilter');
        const countryFilter = document.getElementById('countryFilter');
        const yearFilter = document.getElementById('yearFilter');
        const listItems = document.querySelectorAll('.list-group-item');

        // Populate filter options
        const formats = new Set();
        const countries = new Set();
        const years = new Set();

        listItems.forEach(item => {
            const format = item.querySelector('.text-muted:nth-child(2)');
            const country = item.querySelector('.text-muted:nth-child(3)');
            const year = item.querySelector('.text-muted:nth-child(1)');

            if (format) formats.add(format.textContent.trim());
            if (country) countries.add(country.textContent.trim());
            if (year) years.add(year.textContent.trim());
        });

        populateFilter(formatFilter, formats);
        populateFilter(countryFilter, countries);
        populateFilter(yearFilter, years);

        // Filter function
        function filterResults() {
            const selectedFormat = formatFilter.value;
            const selectedCountry = countryFilter.value;
            const selectedYear = yearFilter.value;

            listItems.forEach(item => {
                const format = item.querySelector('.text-muted:nth-child(2)');
                const country = item.querySelector('.text-muted:nth-child(3)');
                const year = item.querySelector('.text-muted:nth-child(1)');

                const formatMatch = !selectedFormat || (format && format.textContent.trim() === selectedFormat);
                const countryMatch = !selectedCountry || (country && country.textContent.trim() === selectedCountry);
                const yearMatch = !selectedYear || (year && year.textContent.trim() === selectedYear);

                if (formatMatch && countryMatch && yearMatch) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // Populate filter options
        function populateFilter(select, options) {
            options.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.value = option;
                optionElement.textContent = option;
                select.appendChild(optionElement);
            });
        }

        // Add event listeners to filters
        formatFilter.addEventListener('change', filterResults);
        countryFilter.addEventListener('change', filterResults);
        yearFilter.addEventListener('change', filterResults);
    }
});
</script>
@endpush

