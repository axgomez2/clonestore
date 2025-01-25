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
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Cover</th>
                                <th>Artista(s)</th>
                                <th>Titulo</th>
                                <th>Ano</th>
                                <th>Gernero(s)</th>
                                <th>Preço de venda</th>
                                <th>estoque</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vinyls as $vinyl)
                                <tr>
                                    <td>

                                        <span class="avatar avatar-md" style="background-image: url({{ $vinyl->cover_image ? asset('storage/' . $vinyl->cover_image) : asset('images/placeholder.jpg')}})"></span>
                                    </td>
                                    <td>{{ $vinyl->artists->pluck('name')->join(', ') }} - </td>
                                    <td class="text-muted">{{ $vinyl->title }}</td>
                                    <td class="text-muted">{{ $vinyl->release_year }}</td>
                                    <td class="text-muted">{{ $vinyl->genres->pluck('name')->join(', ') }}</td>
                                    <td class="text-muted">{{ $vinyl->vinylSec->price ?? '--' }}</td>
                                    <th>{{ $vinyl->vinylSec->quantity ?? 'S/ estoque' }}</th>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <a href="{{ route('admin.vinyls.edit', $vinyl->id) }}" class="btn btn-icon btn-primary" title="Editar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4" /><line x1="13.5" y1="6.5" x2="17.5" y2="10.5" /></svg>
                                            </a>
                                            @if($vinyl->vinylSec)
                                                <a href="{{ route('admin.vinyl.images', $vinyl->id) }}" class="btn btn-icon btn-success" title="Adicionar imagens">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="15" y1="8" x2="15.01" y2="8" /><rect x="4" y="4" width="16" height="16" rx="3" /><path d="M4 15l4 -4a3 5 0 0 1 3 0l5 5" /><path d="M14 14l1 -1a3 5 0 0 1 3 0l2 2" /></svg>
                                                </a>
                                            @else
                                                <a href="{{ route('admin.vinyls.complete', $vinyl->id) }}" class="btn btn-icon btn-warning" title="Completar cadastro">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><rect x="9" y="3" width="6" height="4" rx="2" /><path d="M9 14l2 2l4 -4" /></svg>
                                                </a>
                                            @endif
                                            <a href="{{ route('admin.vinyls.show', $vinyl->id) }}" class="btn btn-icon btn-info" title="Ver disco">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
                                            </a>
                                            <form action="{{ route('admin.vinyls.destroy', $vinyl->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this vinyl?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-icon btn-danger" title="Excluir">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex align-items-center">
                    {{ $vinyls->links('vendor.pagination.tabler') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

