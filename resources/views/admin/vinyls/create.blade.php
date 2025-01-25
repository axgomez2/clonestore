@extends('layouts.admin')

@section('title', 'Create New Vinyl')

@section('content')
<div class="container-xl">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pesquisar novo disco:</h3>
        </div>
        <div class="card-body">
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

              <script>
              document.getElementById('searchForm').addEventListener('submit', function(e) {
                document.getElementById('loadingBar').classList.remove('d-none');
              });
              </script>

            @if($selectedRelease)







            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Voce selecionou o disco: {{ $selectedRelease['title'] }}</h3>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4 p-3">
                        @if(isset($selectedRelease['images']))
                          <div class="mb-3">
                            <img src="{{ $selectedRelease['images'][0]['uri'] }}" alt="{{ $selectedRelease['title'] }}" class="img-fluid rounded">
                          </div>
                        @endif

                      </div>


                    <div class="col-md-8 p-3">
                      <h2 class="card-title mb-4"></h2>
                      <div class="datagrid mb-4">
                        <div class="datagrid-item">
                          <div class="datagrid-title">Artista</div>
                          <div class="datagrid-content">{{ implode(', ', array_column($selectedRelease['artists'], 'name')) }}</div>
                        </div>

                        <div class="datagrid-item">
                            <div class="datagrid-title">Titulo</div>
                            <div class="datagrid-content">{{ $selectedRelease['year'] }}</div>
                          </div>


                        <div class="datagrid-item">
                          <div class="datagrid-title">Ano</div>
                          <div class="datagrid-content">{{ $selectedRelease['year'] }}</div>
                        </div>
                        <div class="datagrid-item">
                          <div class="datagrid-title">Genero</div>
                          <div class="datagrid-content">{{ implode(', ', $selectedRelease['genres'] ?? []) }}</div>
                        </div>
                        <div class="datagrid-item">
                          <div class="datagrid-title">Estilos</div>
                          <div class="datagrid-content">{{ implode(', ', $selectedRelease['styles'] ?? []) }}</div>
                        </div>
                        <div class="datagrid-item">
                          <div class="datagrid-title">pais de Origem</div>
                          <div class="datagrid-content">{{ $selectedRelease['country'] }}</div>
                        </div>
                        @if(isset($selectedRelease['labels']))
                          <div class="datagrid-item">
                            <div class="datagrid-title">gravadora</div>
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

                      @if(isset($selectedRelease['formats']))
                        <div class="mb-3">
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
                        <div class="mb-3">
                          <h4 class="card-title mb-2">Notas e observações</h4>
                          <div class="text-muted">{{ $selectedRelease['notes'] }}</div>
                        </div>
                      @endif

                      @if(isset($selectedRelease['identifiers']))
                        <div class="mb-3">
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
                        <div class="mb-3">
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
                    </div>

                    <div class="d-grid gap-2">
                        <button id="saveVinylBtn" class="btn btn-primary" data-release-id="{{ $selectedRelease['id'] }}">
                          <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                          Salvar disco
                        </button>
                        <a href="{{ route('admin.vinyls.create') }}" class="btn btn-secondary">Voltar para busca</a>
                      </div>
                  </div>
                </div>
              </div>
            @elseif(count($searchResults) > 0)
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Search Results</h3>
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
            @elseif($query)
                <div class="alert alert-info" role="alert">
                    No results found for "{{ $query }}".
                </div>
            @endif
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="resultModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="modalMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" id="completeNowBtn" class="btn btn-primary">Completar cadastro agora</button>
                <button type="button" id="completeLaterBtn" class="btn btn-secondary">Completar depois</button>
                <button type="button" id="newSearchBtn" class="btn btn-link" data-bs-dismiss="modal">Nova busca</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const saveBtn = document.getElementById('saveVinylBtn');
    const modal = new bootstrap.Modal(document.getElementById('resultModal'));
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    const completeNowBtn = document.getElementById('completeNowBtn');
    const completeLaterBtn = document.getElementById('completeLaterBtn');
    const newSearchBtn = document.getElementById('newSearchBtn');

    let savedVinylId = null;

    if (saveBtn) {
        saveBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const releaseId = this.dataset.releaseId;
            const spinner = this.querySelector('.spinner-border');
            const buttonText = this.textContent;

            // Show loading indicator
            spinner.classList.remove('d-none');
            this.textContent = 'Saving...';
            this.disabled = true;

            fetch('{{ route('admin.vinyls.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ release_id: releaseId })
            })
            .then(response => response.json())
            .then(data => {
                modalTitle.textContent = data.status === 'success' ? 'Success' :
                                         data.status === 'warning' ? 'Warning' : 'Error';
                modalMessage.textContent = data.message;
                savedVinylId = data.vinyl_id;

                completeNowBtn.style.display = (data.status === 'success' || data.status === 'warning') ? 'inline-block' : 'none';
                completeLaterBtn.style.display = (data.status === 'success' || data.status === 'warning') ? 'inline-block' : 'none';

                modal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                modalTitle.textContent = 'Error';
                modalMessage.textContent = 'An unexpected error occurred.';
                completeNowBtn.style.display = 'none';
                completeLaterBtn.style.display = 'none';
                modal.show();
            })
            .finally(() => {
                // Hide loading indicator
                spinner.classList.add('d-none');
                this.textContent = buttonText;
                this.disabled = false;
            });
        });
    }

    completeNowBtn.addEventListener('click', function() {
        if (savedVinylId) {
            window.location.href = `{{ route('admin.vinyls.complete', ['id' => ':id']) }}`.replace(':id', savedVinylId);
        }
    });

    completeLaterBtn.addEventListener('click', function() {
        window.location.href = '{{ route('admin.vinyls.index') }}';
    });

    newSearchBtn.addEventListener('click', function() {
        window.location.href = '{{ route('admin.vinyls.create') }}';
    });
});
</script>
@endpush

