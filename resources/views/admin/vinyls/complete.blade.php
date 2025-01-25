@extends('layouts.admin')

@section('title', 'Complete Vinyl Record')

@section('content')
<div class="container-xl">
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h2 class="page-title mt-4 mb-4">
                Completar cadastro de: {{ $vinylMaster->artists->pluck('name')->join(', ') }} - {{ $vinylMaster->title }}
            </h2>
            <form action="{{ route('admin.vinyl.storeComplete', $vinylMaster->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="alert alert-danger" role="alert">
                    <h2 class="alert-title">Campos obrigatórios</h2>
                    <div class="text-secondary">Complete todos esses campos, é importante:</div>
                  </div>
                <div class="row mt-5">

                    <div class="col-md-3 mb-3">
                        <label class="form-label" for="weight_id">peso:</label>
                        <select id="weight_id" name="weight_id" class="form-select" required>
                            <option value="">Selecionar peso:</option>
                            @foreach($weights as $weight)
                                <option value="{{ $weight->id }}">{{ $weight->name }} ({{ $weight->value }} {{ $weight->unit }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label" for="dimension_id">Dimensões</label>
                        <select id="dimension_id" name="dimension_id" class="form-select" required>
                            <option value="">Selecionar dimensão</option>
                            @foreach($dimensions as $dimension)
                                <option value="{{ $dimension->id }}">{{ $dimension->name }} ({{ $dimension->height }}x{{ $dimension->width }}x{{ $dimension->depth }} {{ $dimension->unit }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label" for="quantity">Estoque</label>
                        <input type="number" id="quantity" name="quantity" min="0" class="form-control" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label" for="price">Preço de Venda</label>
                        <input type="number" id="price" name="price" step="0.01" min="0" class="form-control" required>
                    </div>


                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">produto novo?</label>
                        <div>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_new" value="1" checked>
                                <span class="form-check-label">Novo</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_new" value="0">
                                <span class="form-check-label">Usado</span>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Em promoção?</label>
                        <div>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_promotional" value="1">
                                <span class="form-check-label">SIM</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_promotional" value="0" checked>
                                <span class="form-check-label">NÃO</span>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Em Estoque</label>
                        <div>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="in_stock" value="1" checked>
                                <span class="form-check-label">Com estoque</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="in_stock" value="0">
                                <span class="form-check-label">sem estoque</span>
                            </label>
                        </div>
                    </div>

                </div>

                <hr class="h-px my-8 bg-slate-900 border-1">
                <div class="row">

                    <div class="alert alert-success" role="alert">
                        <h2 class="alert-title">Campos opcionais</h2>
                        <div class="text-secondary">Campos auxiliares no cadastro, mas não são obrigatorios:</div>
                      </div>


                      <div class="col-md-3 mb-3">
                        <label class="form-label" for="cover_status">Estado da capa</label>
                        <select id="cover_status" name="cover_status" class="form-select" >
                            <option value="">Selecione estado da capa </option>
                            @foreach(['mint', 'near_mint', 'very_good', 'good', 'fair', 'poor'] as $status)
                                <option value="{{ $status }}">{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label" for="midia_status">Estado da mídia</label>
                        <select id="midia_status" name="midia_status" class="form-select" >
                            <option value="">Selecionar estado da midia</option>
                            @foreach(['mint', 'near_mint', 'very_good', 'good', 'fair', 'poor'] as $status)
                                <option value="{{ $status }}">{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="catalog_number">Numero de catálogo</label>
                        <input type="text" id="catalog_number" name="catalog_number" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="barcode">Barcode</label>
                        <input type="text" id="barcode" name="barcode" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="format">Formato</label>
                        <input type="text" id="format" name="format" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="num_discs">Numero de discos</label>
                        <input type="number" id="num_discs" name="num_discs" min="1" value="1" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="speed">Velocidade</label>
                        <input type="text" id="speed" name="speed" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="edition">Edição(se aplicável)</label>
                        <input type="text" id="edition" name="edition" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="buy_price">Preço de compra</label>
                        <input type="number" id="buy_price" name="buy_price" step="0.01" min="0" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="promotional_price">Preço promocional</label>
                        <input type="number" id="promotional_price" name="promotional_price" step="0.01" min="0" class="form-control">
                    </div>



                    <div class="col-12 mb-3">
                        <label class="form-label" for="notes">Notas e descrição</label>
                        <textarea id="notes" name="notes" rows="3" class="form-control"></textarea>
                    </div>
                </div>
                <div class="mb-3">
                    <h3 class="card-title">faixas: importante</h3>
                    <div class="table-responsive">
                        <table class="table table-vcenter">
                            <thead>
                                <tr>
                                    <th>Faixa</th>
                                    <th>Duração</th>
                                    <th>YouTube URL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tracks as $track)
                                    <tr>
                                        <td>{{ $track->name }}</td>
                                        <td>{{ $track->duration }}</td>
                                        <td>
                                            <input type="text" name="track_youtube_urls[{{ $track->id }}]" placeholder="YouTube URL (optional)" class="form-control">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary">Completar cadastro:</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

