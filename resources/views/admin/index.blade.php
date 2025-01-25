@extends('layouts.admin')

@section('title', 'inicio')

@section('breadcrumb')
    <x-admin.breadcrumb :items="[
        ['title' => 'inicio', 'url' => route('admin.dashboard')]
    ]" />
@endsection

@section('content')
<div class="container-xl">
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Inicio
                </h2>
            </div>
        </div>
    </div>
    <div class="row row-deck row-cards">
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Total de discos cadastrados</div>
                    </div>
                    <div class="h1 mb-3">{{ $totalVinyls }}</div>
                    <div class="d-flex mb-2">
                        <div>Total de discos cadastrados no banco de dados</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Cadastros Completos</div>
                    </div>
                    <div class="h1 mb-3">{{ $completedVinyls }}</div>
                    <div class="d-flex mb-2">
                        <div>Discos com cadastros completos</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Discos sem estoqueS</div>
                    </div>
                    <div class="h1 mb-3">{{ $outOfStockVinyls }}</div>
                    <div class="d-flex mb-2">
                        <div>Discos sem estoque na base</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Total de usuarios </div>
                    </div>
                    <div class="h1 mb-3">{{ $totalCustomers }}</div>
                    <div class="d-flex mb-2">
                        <div>usuarios essa semana: 0</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ultimos pedidos</h3>
                </div>
                <div class="card-body">
                    <div class="empty">
                        <div class="empty-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="9" y1="10" x2="9.01" y2="10" /><line x1="15" y1="10" x2="15.01" y2="10" /><line x1="9" y1="15" x2="15" y2="15" /></svg>
                        </div>
                        <p class="empty-title">sem pedidos no momento</p>
                        <p class="empty-subtitle text-muted">
                            quando o primeiro pedido chegar: ele vai aparecer aqui para você:
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

