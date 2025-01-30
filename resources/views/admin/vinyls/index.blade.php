@extends('layouts.admin')

@section('title', 'Vinyls')

@section('breadcrumb')
    <x-admin.breadcrumb :items="[
        ['title' => 'Todos os discos', 'url' => route('admin.vinyls.index')]
    ]" />
@endsection

@section('content')
<div class="container-xl">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Todos os Discos</h3>
            <div class="card-actions">
                <a href="{{ route('admin.vinyls.create') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                    Adicionar novo disco
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($vinyls->isEmpty())
                <div class="empty">
                    <div class="empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="9" y1="10" x2="9.01" y2="10" /><line x1="15" y1="10" x2="15.01" y2="10" /><path d="M9.5 15.25a3.5 3.5 0 0 1 5 0" /></svg>
                    </div>
                    <p class="empty-title">Menhum disco cadastrado</p>
                    <p class="empty-subtitle text-muted">
                        vamos começar?
                    </p>
                </div>
            @else
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Vinyls</h3>
                </div>
                <div class="card-body border-bottom py-3">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Cover</th>
                                    <th>Informações do Disco</th>
                                    <th>preço de venda</th>
                                    <th>preço promocional</th>
                                    <th>Ano</th>
                                    <th>Estoque</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vinyls as $vinyl)
                                    <tr>
                                        <td rowspan="2" class="align-middle">
                                            <span class="avatar avatar-xl" style="background-image: url({{ $vinyl->cover_image ? asset('storage/' . $vinyl->cover_image) : asset('assets/images/placeholder.jpg') }})"></span>
                                        </td>
                                        <td>
                                            <div class="font-weight-medium">{{ $vinyl->artists->pluck('name')->join(', ') }}</div>
                                            <div class="text-muted">{{ $vinyl->title }}</div>
                                        </td>
                                        <td class="text-muted">
                                         R$   {{ $vinyl->vinylSec->price ?? '--' }}
                                        </td>
                                        <td class="text-muted">
                                         R$   {{ $vinyl->vinylSec->promotional_price ?? '--' }}
                                        </td>
                                        <td class="text-muted">
                                            {{ $vinyl->release_year }}
                                        </td>
                                        <td class="text-muted">
                                            {{ $vinyl->vinylSec->quantity ?? '0' }}
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <span class="text-muted">Faixas: {{ $vinyl->tracks->count() }} ({{ $vinyl->tracks->whereNotNull('youtube_url')->count() }} com YouTube)</span>
                                        </td>
                                        <td>

                                            <label class="form-check form-switch">
                                                <input class="form-check-input toggle-switch" type="checkbox"
                                                    data-id="{{ $vinyl->id }}"
                                                    data-field="is_promotional"
                                                    {{ $vinyl->vinylSec && $vinyl->vinylSec->is_promotional ? 'checked' : '' }}>
                                                <span class="form-check-label">Em promoção</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="form-check form-switch">
                                                <input class="form-check-input toggle-switch" type="checkbox"
                                                    data-id="{{ $vinyl->id }}"
                                                    data-field="in_stock"
                                                    {{ $vinyl->vinylSec && $vinyl->vinylSec->in_stock ? 'checked' : '' }}>
                                                <span class="form-check-label">Em estoque</span>
                                            </label>
                                        </td>
                                        <td colspan="2">
                                            <div class="btn-list flex-nowrap">
                                                <a href="{{ route('admin.vinyls.edit', $vinyl->id) }}" class="btn btn-icon btn-primary" title="Editar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                        <path d="M16 5l3 3"></path>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('admin.vinyls.edit-tracks', $vinyl->id) }}" class="btn btn-icon btn-secondary" title="Editar faixas">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-music" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M6 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                                        <path d="M16 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                                        <path d="M9 17l0 -13l10 0l0 13"></path>
                                                        <path d="M9 8l10 0"></path>
                                                    </svg>
                                                </a>
                                                @if($vinyl->vinylSec)
                                                    <a href="{{ route('admin.vinyl.images', $vinyl->id) }}" class="btn btn-icon btn-success" title="Adicionar imagens">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-photo" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M15 8h.01"></path>
                                                            <path d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z"></path>
                                                            <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5"></path>
                                                            <path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3"></path>
                                                        </svg>
                                                    </a>
                                                @else
                                                    <a href="{{ route('admin.vinyls.complete', $vinyl->id) }}" class="btn btn-icon btn-warning" title="Completar cadastro">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                                                            <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
                                                            <path d="M9 14l2 2l4 -4"></path>
                                                        </svg>
                                                    </a>
                                                @endif
                                                <a href="{{ route('admin.vinyls.show', $vinyl->id) }}" class="btn btn-icon btn-info" title="Ver disco">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                                        <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.vinyls.destroy', $vinyl->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this vinyl?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-icon btn-danger" title="Excluir">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M4 7l16 0"></path>
                                                            <path d="M10 11l0 6"></path>
                                                            <path d="M14 11l0 6"></path>
                                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>






                <div class="card-footer d-flex align-items-center">
                    {{ $vinyls->links('vendor.pagination.tabler') }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleSwitches = document.querySelectorAll('.toggle-switch');

    toggleSwitches.forEach(toggleSwitch => {
        toggleSwitch.addEventListener('change', function() {
            const vinylId = this.dataset.id;
            const field = this.dataset.field;
            const value = this.checked ? 1 : 0;

            console.log('Updating:', vinylId, field, value);

            fetch('{{ route('admin.vinyls.updateField') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: vinylId, field: field, value: value })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    console.log('Update successful');
                    // Optionally show a success message
                    alert('Atualizado com sucesso!');
                } else {
                    console.error('Update failed:', data);
                    this.checked = !this.checked;
                    alert('Falha na atualização. Por favor, tente novamente.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.checked = !this.checked;
                alert('Ocorreu um erro. Por favor, tente novamente.');
            });
        });
    });
});
</script>
@endpush
@endsection

