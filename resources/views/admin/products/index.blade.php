@extends('layouts.app')

@section('title', 'Manage Products - Admin Panel')

@section('content')
<div class="bg-gray-900 text-white min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold mb-2">Products Management</h1>
                <p class="text-gray-400">Manage your product inventory</p>
            </div>
            <a href="{{ route('admin.products.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded font-semibold transition flex items-center">
                <i class="fas fa-plus mr-2"></i>Add New Product
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-900 border border-green-700 text-green-200 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search & Filter -->
        <div class="bg-gray-800 rounded-lg border border-gray-700 p-6 mb-6">
            <form action="{{ route('admin.products') }}" method="GET" class="flex gap-4">
                <input type="text" name="search" placeholder="Search products..." 
                       class="flex-1 px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded focus:outline-none focus:border-blue-500"
                       value="{{ request('search') }}">
                <select name="category" class="px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded focus:outline-none focus:border-blue-500">
                    <option value="">All Categories</option>
                    <option value="fashion" {{ request('category') === 'fashion' ? 'selected' : '' }}>Fashion</option>
                    <option value="accessories" {{ request('category') === 'accessories' ? 'selected' : '' }}>Accessories</option>
                    <option value="shoes" {{ request('category') === 'shoes' ? 'selected' : '' }}>Shoes</option>
                </select>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-semibold transition">
                    Filter
                </button>
            </form>
        </div>

        <!-- Products Table -->
        <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Product Name</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Category</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Price</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Stock</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-700 transition">
                                <td class="px-6 py-4">
                                    <div class="font-semibold">{{ $product->name }}</div>
                                    <div class="text-sm text-gray-400">SKU: {{ $product->sku ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 capitalize">{{ $product->category }}</td>
                                <td class="px-6 py-4">
                                    <div>${{ number_format($product->price, 2) }}</div>
                                    @if($product->original_price)
                                        <div class="text-sm text-gray-400 line-through">${{ number_format($product->original_price, 2) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded text-sm font-semibold
                                        @if($product->stock > 20) bg-green-900 text-green-200
                                        @elseif($product->stock > 5) bg-yellow-900 text-yellow-200
                                        @else bg-red-900 text-red-200 @endif">
                                        {{ $product->stock }} units
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($product->is_active)
                                        <span class="px-3 py-1 rounded text-sm font-semibold bg-blue-900 text-blue-200">Active</span>
                                    @else
                                        <span class="px-3 py-1 rounded text-sm font-semibold bg-gray-700 text-gray-300">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-3">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-400 hover:text-blue-300 transition" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300 transition" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                                    <i class="fas fa-inbox text-4xl mb-4"></i>
                                    <p>No products found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="bg-gray-700 px-6 py-4 flex justify-center">
                    {{ $products->links() }}
                </div>
            @endif
        </div>

        <!-- Back Link -->
        <div class="mt-6">
            <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-white">
                <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
