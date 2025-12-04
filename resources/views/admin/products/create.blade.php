@extends('layouts.app')

@section('title', 'Add New Product - Admin Panel')

@section('content')
<div class="bg-gray-900 text-white min-h-screen py-8">
    <div class="container mx-auto px-4 max-w-2xl">
        <!-- Header -->
        <h1 class="text-4xl font-bold mb-2">Add New Product</h1>
        <p class="text-gray-400 mb-8">Create a new product for your store</p>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-900 border border-red-700 text-red-200 rounded">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('admin.products.store') }}" method="POST" class="bg-gray-800 border border-gray-700 rounded-lg p-8">
            @csrf

            <!-- Basic Info -->
            <div class="mb-6">
                <h2 class="text-xl font-bold mb-4 pb-2 border-b border-gray-700">Basic Information</h2>
                
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-2">Product Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded focus:outline-none focus:border-blue-500"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-2">Description</label>
                    <textarea name="description" rows="4"
                              class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded focus:outline-none focus:border-blue-500">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold mb-2">Category *</label>
                        <select name="category" class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded focus:outline-none focus:border-blue-500" required>
                            <option value="">Select Category</option>
                            <option value="fashion" {{ old('category') === 'fashion' ? 'selected' : '' }}>Fashion</option>
                            <option value="accessories" {{ old('category') === 'accessories' ? 'selected' : '' }}>Accessories</option>
                            <option value="shoes" {{ old('category') === 'shoes' ? 'selected' : '' }}>Shoes</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">SKU</label>
                        <input type="text" name="sku" value="{{ old('sku') }}"
                               class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded focus:outline-none focus:border-blue-500">
                    </div>
                </div>
            </div>

            <!-- Pricing -->
            <div class="mb-6">
                <h2 class="text-xl font-bold mb-4 pb-2 border-b border-gray-700">Pricing</h2>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold mb-2">Sale Price *</label>
                        <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0"
                               class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded focus:outline-none focus:border-blue-500"
                               required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Original Price</label>
                        <input type="number" name="original_price" value="{{ old('original_price') }}" step="0.01" min="0"
                               class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded focus:outline-none focus:border-blue-500">
                    </div>
                </div>
            </div>

            <!-- Inventory -->
            <div class="mb-6">
                <h2 class="text-xl font-bold mb-4 pb-2 border-b border-gray-700">Inventory</h2>
                
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-2">Stock Quantity *</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0"
                           class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded focus:outline-none focus:border-blue-500"
                           required>
                </div>
            </div>

            <!-- Image -->
            <div class="mb-6">
                <h2 class="text-xl font-bold mb-4 pb-2 border-b border-gray-700">Media</h2>
                
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-2">Image URL</label>
                    <input type="url" name="image" value="{{ old('image') }}"
                           class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded focus:outline-none focus:border-blue-500"
                           placeholder="https://example.com/image.jpg">
                </div>
            </div>

            <!-- Status & Features -->
            <div class="mb-6">
                <h2 class="text-xl font-bold mb-4 pb-2 border-b border-gray-700">Status & Features</h2>
                
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="w-4 h-4">
                        <span class="ml-2">Active</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_new" value="1" {{ old('is_new') ? 'checked' : '' }}
                               class="w-4 h-4">
                        <span class="ml-2">Mark as New</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_sale" value="1" {{ old('is_sale') ? 'checked' : '' }}
                               class="w-4 h-4">
                        <span class="ml-2">On Sale</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}
                               class="w-4 h-4">
                        <span class="ml-2">Featured Product</span>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4 pt-6 border-t border-gray-700">
                <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 rounded font-semibold transition">
                    <i class="fas fa-save mr-2"></i>Create Product
                </button>
                <a href="{{ route('admin.products') }}" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white py-3 rounded font-semibold text-center transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
