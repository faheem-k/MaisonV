@extends('layouts.app')

@section('title', 'Admin Dashboard - Maison V')

@section('content')
<div class="bg-gray-900 text-white min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold mb-2">Admin Dashboard</h1>
            <p class="text-gray-400">Welcome back! Here's an overview of your store.</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Products -->
            <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Products</p>
                        <p class="text-3xl font-bold">{{ $totalProducts }}</p>
                    </div>
                    <div class="text-4xl text-blue-400">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Orders</p>
                        <p class="text-3xl font-bold">{{ $totalOrders }}</p>
                    </div>
                    <div class="text-4xl text-green-400">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Revenue</p>
                        <p class="text-3xl font-bold">${{ number_format($totalRevenue, 2) }}</p>
                    </div>
                    <div class="text-4xl text-yellow-400">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Pending Orders</p>
                        <p class="text-3xl font-bold">{{ $pendingOrders }}</p>
                    </div>
                    <div class="text-4xl text-orange-400">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Management Links -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Products Management -->
            <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold flex items-center">
                        <i class="fas fa-box mr-3"></i>Products Management
                    </h2>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('admin.products.index') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded text-center font-semibold transition">
                        View All Products
                    </a>
                    <a href="{{ route('admin.products.create') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded text-center font-semibold transition">
                        Add New Product
                    </a>
                </div>
            </div>

            <!-- Orders Management -->
            <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
                <div class="bg-green-600 px-6 py-4">
                    <h2 class="text-xl font-bold flex items-center">
                        <i class="fas fa-shopping-cart mr-3"></i>Orders Management
                    </h2>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('admin.orders.index') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded text-center font-semibold transition">
                        View All Orders
                    </a>
                    <p class="text-gray-400 text-sm">{{ $pendingOrders }} orders pending processing</p>
                </div>
            </div>
        </div>

        <!-- Recent Products -->
        <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden mb-8">
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-xl font-bold">Recent Products</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Product Name</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Price</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Stock</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Category</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-700 transition">
                                <td class="px-6 py-4">{{ $product->name }}</td>
                                <td class="px-6 py-4">${{ number_format($product->price, 2) }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded text-sm font-semibold
                                        @if($product->stock > 0) bg-green-900 text-green-200
                                        @else bg-red-900 text-red-200 @endif">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 capitalize">{{ $product->category }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-400 hover:text-blue-300 mr-3">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-400">No products yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
            <div class="bg-green-600 px-6 py-4">
                <h2 class="text-xl font-bold">Recent Orders</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Order #</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Customer</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Items</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Total</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-700 transition">
                                <td class="px-6 py-4 font-semibold">{{ $order->order_number }}</td>
                                <td class="px-6 py-4">{{ $order->customer_name }}</td>
                                <td class="px-6 py-4">{{ $order->items->count() }}</td>
                                <td class="px-6 py-4">${{ number_format($order->total, 2) }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded text-sm font-semibold capitalize
                                        @if($order->order_status === 'pending') bg-yellow-900 text-yellow-200
                                        @elseif($order->order_status === 'processing') bg-blue-900 text-blue-200
                                        @elseif($order->order_status === 'shipped') bg-purple-900 text-purple-200
                                        @elseif($order->order_status === 'delivered') bg-green-900 text-green-200
                                        @else bg-red-900 text-red-200 @endif">
                                        {{ $order->order_status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-400 hover:text-blue-300">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-400">No orders yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Back to Shop -->
        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="inline-block bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded font-semibold transition">
                <i class="fas fa-arrow-left mr-2"></i>Back to Shop
            </a>
        </div>
    </div>
</div>
@endsection
