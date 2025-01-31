@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Editar Disco: {{ $vinyl->title }}</h1>
        <a href="{{ route('admin.vinyls.show', $vinyl->id) }}" class="btn btn-secondary">Voltar para Detalhes</a>
    </div>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <form action="{{ route('admin.vinyls.update', $vinyl->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-control">
                        <label class="label" for="description">
                            <span class="label-text">Descrição</span>
                        </label>
                        <textarea id="description" name="description" rows="4" class="textarea textarea-bordered">{{ old('description', $vinyl->description) }}</textarea>
                    </div>

                    <div class="form-control">
                        <label class="label" for="weight_id">
                            <span class="label-text">Peso</span>
                        </label>
                        <select id="weight_id" name="weight_id" class="select select-bordered" required>
                            @foreach($weights as $weight)
                                <option value="{{ $weight->id }}" {{ (old('weight_id', $vinyl->vinylSec->weight_id ?? '') == $weight->id) ? 'selected' : '' }}>
                                    {{ $weight->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label" for="dimension_id">
                            <span class="label-text">Dimensão</span>
                        </label>
                        <select id="dimension_id" name="dimension_id" class="select select-bordered" required>
                            @foreach($dimensions as $dimension)
                                <option value="{{ $dimension->id }}" {{ (old('dimension_id', $vinyl->vinylSec->dimension_id ?? '') == $dimension->id) ? 'selected' : '' }}>
                                    {{ $dimension->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label" for="quantity">
                            <span class="label-text">Quantidade</span>
                        </label>
                        <input type="number" id="quantity" name="quantity" value="{{ old('quantity', $vinyl->vinylSec->quantity ?? 0) }}" class="input input-bordered" required min="0">
                    </div>

                    <div class="form-control">
                        <label class="label" for="price">
                            <span class="label-text">Preço</span>
                        </label>
                        <input type="number" id="price" name="price" value="{{ old('price', $vinyl->vinylSec->price ?? 0) }}" class="input input-bordered" required min="0" step="0.01">
                    </div>

                    <div class="form-control">
                        <label class="label" for="buy_price">
                            <span class="label-text">Preço de Compra</span>
                        </label>
                        <input type="number" id="buy_price" name="buy_price" value="{{ old('buy_price', $vinyl->vinylSec->buy_price ?? '') }}" class="input input-bordered" min="0" step="0.01">
                    </div>

                    <div class="form-control">
                        <label class="label" for="promotional_price">
                            <span class="label-text">Preço Promocional</span>
                        </label>
                        <input type="number" id="promotional_price" name="promotional_price" value="{{ old('promotional_price', $vinyl->vinylSec->promotional_price ?? '') }}" class="input input-bordered" min="0" step="0.01">
                    </div>

                    <div class="form-control">
                        <label class="label cursor-pointer">
                            <span class="label-text">Em Promoção</span>
                            <input type="checkbox" name="is_promotional" class="toggle toggle-primary" {{ (old('is_promotional', $vinyl->vinylSec->is_promotional ?? false)) ? 'checked' : '' }} value="1">
                        </label>
                    </div>

                    <div class="form-control">
                        <label class="label cursor-pointer">
                            <span class="label-text">Em Estoque</span>
                            <input type="checkbox" name="in_stock" class="toggle toggle-primary" {{ (old('in_stock', $vinyl->vinylSec->in_stock ?? false)) ? 'checked' : '' }} value="1">
                        </label>
                    </div>
                </div>

                <div class="form-control mt-6">
                    <button type="submit" class="btn btn-primary">Atualizar Disco</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

