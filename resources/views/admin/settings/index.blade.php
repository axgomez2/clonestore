@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Settings</h1>

    <div x-data="{ activeTab: 'weights' }">
        <!-- Tab Navigation -->
        <div class="mb-4 border-b border-gray-200">
            <ul class="flex flex-wrap -mb-px">
                <li class="mr-2">
                    <a class="inline-block p-4 rounded-t-lg" :class="{ 'text-blue-600 border-b-2 border-blue-600': activeTab === 'weights', 'hover:text-gray-600 hover:border-gray-300': activeTab !== 'weights' }" @click.prevent="activeTab = 'weights'" href="#">Weights</a>
                </li>
                <li class="mr-2">
                    <a class="inline-block p-4 rounded-t-lg" :class="{ 'text-blue-600 border-b-2 border-blue-600': activeTab === 'dimensions', 'hover:text-gray-600 hover:border-gray-300': activeTab !== 'dimensions' }" @click.prevent="activeTab = 'dimensions'" href="#">Dimensions</a>
                </li>
                <li class="mr-2">
                    <a class="inline-block p-4 rounded-t-lg" :class="{ 'text-blue-600 border-b-2 border-blue-600': activeTab === 'brands', 'hover:text-gray-600 hover:border-gray-300': activeTab !== 'brands' }" @click.prevent="activeTab = 'brands'" href="#">Brands</a>
                </li>
                <li class="mr-2">
                    <a class="inline-block p-4 rounded-t-lg" :class="{ 'text-blue-600 border-b-2 border-blue-600': activeTab === 'equipment-categories', 'hover:text-gray-600 hover:border-gray-300': activeTab !== 'equipment-categories' }" @click.prevent="activeTab = 'equipment-categories'" href="#">Equipment Categories</a>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="bg-white p-6 rounded-lg shadow">
            <!-- Weights Tab -->
            <div x-show="activeTab === 'weights'">
                <h2 class="text-xl font-semibold mb-4">Weights</h2>
                <form action="{{ route('admin.settings.storeWeight') }}" method="POST" class="mb-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="weight_name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="weight_name" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="weight_value" class="block text-sm font-medium text-gray-700">Value</label>
                            <input type="number" step="0.01" name="value" id="weight_value" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="weight_unit" class="block text-sm font-medium text-gray-700">Unit</label>
                            <input type="text" name="unit" id="weight_unit" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Add Weight
                        </button>
                    </div>
                </form>
                <ul class="divide-y divide-gray-200">
                    @foreach($weights as $weight)
                        <li class="py-4">
                            <p class="text-sm font-medium text-gray-900">{{ $weight->name }} ({{ $weight->value }} {{ $weight->unit }})</p>
                        </li>
                    @endforeach
                </ul>
            </div>


            <!-- Dimensions Tab -->
            <div x-show="activeTab === 'dimensions'">
                <h2 class="text-xl font-semibold mb-4">Dimensions</h2>
                <form action="{{ route('admin.settings.storeDimension') }}" method="POST" class="mb-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <label for="dimension_name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="dimension_name" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="dimension_height" class="block text-sm font-medium text-gray-700">Height</label>
                            <input type="number" step="0.01" name="height" id="dimension_height" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="dimension_width" class="block text-sm font-medium text-gray-700">Width</label>
                            <input type="number" step="0.01" name="width" id="dimension_width" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="dimension_depth" class="block text-sm font-medium text-gray-700">Depth</label>
                            <input type="number" step="0.01" name="depth" id="dimension_depth" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="dimension_unit" class="block text-sm font-medium text-gray-700">Unit</label>
                            <input type="text" name="unit" id="dimension_unit" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Add Dimension
                        </button>
                    </div>
                </form>
                <ul class="divide-y divide-gray-200">
                    @foreach($dimensions as $dimension)
                        <li class="py-4">
                            <p class="text-sm font-medium text-gray-900">{{ $dimension->name }} ({{ $dimension->height }}x{{ $dimension->width }}x{{ $dimension->depth }} {{ $dimension->unit }})</p>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Brands Tab -->
            <div x-show="activeTab === 'brands'">
                <h2 class="text-xl font-semibold mb-4">Brands</h2>
                <form action="{{ route('admin.settings.storeBrand') }}" method="POST" class="mb-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="brand_name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="brand_name" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="brand_logo_url" class="block text-sm font-medium text-gray-700">Logo URL</label>
                            <input type="url" name="logo_url" id="brand_logo_url" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div class="md:col-span-2">
                            <label for="brand_description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="brand_description" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Add Brand
                        </button>
                    </div>
                </form>
                <ul class="divide-y divide-gray-200">
                    @foreach($brands as $brand)
                        <li class="py-4">
                            <div class="flex items-center space-x-4">
                                @if($brand->logo_url)
                                    <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }} logo" class="h-12 w-12 object-contain">
                                @endif
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $brand->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $brand->description }}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Equipment Categories Tab -->
            <div x-show="activeTab === 'equipment-categories'">
                <h2 class="text-xl font-semibold mb-4">Equipment Categories</h2>
                <form action="{{ route('admin.settings.storeEquipmentCategory') }}" method="POST" class="mb-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="category_name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="category_name" required class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="category_parent_id" class="block text-sm font-medium text-gray-700">Parent Category</label>
                            <select name="parent_id" id="category_parent_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">None</option>
                                @foreach($equipmentCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label for="category_description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="category_description" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Add Equipment Category
                        </button>
                    </div>
                </form>
                <ul class="divide-y divide-gray-200">
                    @foreach($equipmentCategories as $category)
                        <li class="py-4">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $category->name }}</p>
                                <p class="text-sm text-gray-500">{{ $category->description }}</p>
                                @if($category->parent)
                                    <p class="text-xs text-gray-400">Parent: {{ $category->parent->name }}</p>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
@endpush
@endsection
