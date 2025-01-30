@extends('layouts.admin')

@section('title', 'Edit Tracks')

@section('content')
<div class="container-xl">
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Edit Tracks for {{ $vinyl->title }}
                </h2>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Vinyl Information</h3>
        </div>
        <div class="card-body">
            <div class="datagrid">
                <div class="datagrid-item">
                    <div class="datagrid-title">Artist</div>
                    <div class="datagrid-content">{{ $vinyl->artists->pluck('name')->join(', ') }}</div>
                </div>
                <div class="datagrid-item">
                    <div class="datagrid-title">Title</div>
                    <div class="datagrid-content">{{ $vinyl->title }}</div>
                </div>
                <div class="datagrid-item">
                    <div class="datagrid-title">Year</div>
                    <div class="datagrid-content">{{ $vinyl->release_year }}</div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.vinyls.update-tracks', $vinyl->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Edit Tracks</h3>
            </div>
            <div class="card-body">
                <div id="tracks-container">
                    @foreach($vinyl->tracks as $index => $track)
                        <div class="mb-3 track-item">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="form-label">Track Name</label>
                                    <input type="text" class="form-control" name="tracks[{{ $index }}][name]" value="{{ $track->name }}" required>
                                    <input type="hidden" name="tracks[{{ $index }}][id]" value="{{ $track->id }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Duration</label>
                                    <input type="text" class="form-control" name="tracks[{{ $index }}][duration]" value="{{ $track->duration }}">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">YouTube URL</label>
                                    <div class="input-group">
                                        <input type="url" class="form-control" name="tracks[{{ $index }}][youtube_url]" value="{{ $track->youtube_url }}">
                                        <button type="button" class="btn btn-secondary search-youtube" data-track-name="{{ $track->name }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <circle cx="10" cy="10" r="7"></circle>
                                                <line x1="21" y1="21" x2="15" y2="15"></line>
                                            </svg>
                                            Buscar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-3">
                    <button type="button" id="add-track" class="btn btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                        </svg>
                        Add New Track
                    </button>
                </div>
            </div>
            <div class="card-footer text-end">
                <div class="d-flex">
                    <a href="{{ route('admin.vinyls.show', $vinyl->id) }}" class="btn btn-link">Cancel</a>
                    <button type="submit" class="btn btn-primary ms-auto">Save Changes</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Tabler modal for YouTube search results -->
<div class="modal modal-blur fade" id="youtube-results-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select YouTube Video</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="youtube-results-list" class="list-group list-group-flush"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof bootstrap === 'undefined') {
        console.error('Bootstrap não está carregado. Verifique se o script do Bootstrap está incluído corretamente.');
    }

    const container = document.getElementById('tracks-container');
    const addButton = document.getElementById('add-track');
    let trackCount = {{ $vinyl->tracks->count() }};

    addButton.addEventListener('click', function() {
        const newTrack = `
            <div class="mb-3 track-item">
                <div class="row g-2">
                    <div class="col-md-4">
                        <label class="form-label">Track Name</label>
                        <input type="text" class="form-control" name="tracks[${trackCount}][name]" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Duration</label>
                        <input type="text" class="form-control" name="tracks[${trackCount}][duration]">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">YouTube URL</label>
                        <div class="input-group">
                            <input type="url" class="form-control" name="tracks[${trackCount}][youtube_url]">
                            <button type="button" class="btn btn-secondary search-youtube" data-track-name="">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="10" cy="10" r="7"></circle>
                                    <line x1="21" y1="21" x2="15" y2="15"></line>
                                </svg>
                                Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', newTrack);
        trackCount++;
    });

    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('search-youtube') || e.target.closest('.search-youtube')) {
            const trackItem = e.target.closest('.track-item');
            const trackName = trackItem.querySelector('input[name$="[name]"]').value;
            const artistName = '{{ $vinyl->artists->pluck('name')->join(' ') }}';
            searchYouTube(trackName, artistName, trackItem);
        }
    });

    function searchYouTube(trackName, artistName, trackItem) {
        const query = `${artistName} ${trackName}`;
        const csrfToken = document.querySelector('meta[name="csrf-token"]');

        if (!csrfToken) {
            console.error('CSRF token not found');
            alert('Erro de segurança. Por favor, recarregue a página e tente novamente.');
            return;
        }

        fetch('{{ route('youtube.search') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken.getAttribute('content')
            },
            body: JSON.stringify({ query })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            showResultsModal(data, trackItem);
        })
        .catch(error => {
            console.error('Erro ao pesquisar no YouTube:', error);
            alert('Ocorreu um erro ao pesquisar no YouTube. Por favor, tente novamente.');
        });
    }

    function showResultsModal(results, trackItem) {
        const modalElement = document.getElementById('youtube-results-modal');
        const resultsList = document.getElementById('youtube-results-list');
        resultsList.innerHTML = '';

        if (!results || results.length === 0) {
            resultsList.innerHTML = '<p>Nenhum resultado encontrado.</p>';
        } else {
            results.forEach(item => {
                const listItem = document.createElement('a');
                listItem.href = '#';
                listItem.className = 'list-group-item list-group-item-action';
                listItem.innerHTML = `
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">${item.snippet.title}</h5>
                    </div>
                    <p class="mb-1">${item.snippet.description}</p>
                `;
                listItem.addEventListener('click', function(e) {
                    e.preventDefault();
                    const youtubeUrl = `https://www.youtube.com/watch?v=${item.id.videoId}`;
                    trackItem.querySelector('input[name$="[youtube_url]"]').value = youtubeUrl;
                    const modal = bootstrap.Modal.getInstance(modalElement);
                    if (modal) {
                        modal.hide();
                    }
                });
                resultsList.appendChild(listItem);
            });
        }

        const modal = new bootstrap.Modal(modalElement);
        modal.show();
    }
});
</script>
@endpush

@endsection


