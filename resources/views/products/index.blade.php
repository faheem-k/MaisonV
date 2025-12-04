@extends('layouts.app')

@section('title', 'Products - Maison V')

@section('content')
<div class="container mx-auto px-4 py-12">
    <!-- Breadcrumb -->
    <div class="flex items-center mb-8 text-sm">
        <a href="{{ route('home') }}" class="text-gray-600 hover:text-black">Home</a>
        <span class="mx-3 text-gray-400">/</span>
        <span class="text-gray-900">Products</span>
    </div>

    <div class="flex gap-8">
        <!-- Sidebar Filters -->
        <div class="w-64 flex-shrink-0">
            <div class="bg-white rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-bold mb-6">Filters</h3>

                <!-- Search -->
                <form method="GET" action="{{ route('products.index') }}" class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search products..."
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black">
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-sm font-semibold mb-2">Category</label>
                        <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black">
                            <option value="">All Categories</option>
                            <option value="fashion" {{ request('category') === 'fashion' ? 'selected' : '' }}>Fashion</option>
                            <option value="accessories" {{ request('category') === 'accessories' ? 'selected' : '' }}>Accessories</option>
                            <option value="shoes" {{ request('category') === 'shoes' ? 'selected' : '' }}>Shoes</option>
                            <option value="bags" {{ request('category') === 'bags' ? 'selected' : '' }}>Bags</option>
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div>
                        <label class="block text-sm font-semibold mb-2">Price Range</label>
                        <div class="flex gap-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}"
                                   placeholder="Min" class="w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black">
                            <input type="number" name="max_price" value="{{ request('max_price') }}"
                                   placeholder="Max" class="w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black">
                        </div>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label class="block text-sm font-semibold mb-2">Sort By</label>
                        <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black">
                            <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Most Popular</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-black text-white py-2 rounded-lg font-semibold hover:bg-gray-800 transition">
                        Apply Filters
                    </button>
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="flex-1">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold">Products</h2>
                <span class="text-gray-600">Showing {{ $products->count() }} products</span>
            </div>

            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($products as $product)
                        <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="relative overflow-hidden bg-gray-100 h-80">
                                <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=400' }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover hover:scale-110 transition duration-500">
                                <div class="absolute top-4 right-4">
                                    <button class="bg-white rounded-full p-2 shadow-md hover:bg-gray-100 transition">
                                        <i class="far fa-heart text-gray-700"></i>
                                    </button>
                                </div>
                                @if($product->is_new)
                                    <span class="absolute top-4 left-4 bg-black text-white text-xs px-3 py-1 rounded-full font-semibold">NEW</span>
                                @endif
                                @if($product->is_sale)
                                    <span class="absolute top-4 left-4 bg-red-500 text-white text-xs px-3 py-1 rounded-full font-semibold">SALE</span>
                                @endif
                            </div>
                            <div class="p-5">
                                <div class="text-xs text-gray-500 mb-2 uppercase tracking-wide">
                                    {{ $product->category ?? 'Fashion' }}
                                </div>
                                <h3 class="font-semibold text-gray-800 mb-2 text-lg">{{ $product->name }}</h3>
                                <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $product->description }}</p>
                                <div class="flex items-center mb-3">
                                    <div class="flex text-yellow-400 text-sm">
                                        @for($i = 0; $i < 5; $i++)
                                            @if($i < $product->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-gray-500 text-sm ml-2">({{ $product->reviews_count }})</span>
                                </div>
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <span class="text-2xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                        @if($product->original_price)
                                            <span class="text-sm text-gray-400 line-through ml-2">${{ number_format($product->original_price, 2) }}</span>
                                        @endif
                                    </div>
                                    @if($product->discount_percentage > 0)
                                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-sm font-semibold">-{{ $product->discount_percentage }}%</span>
                                    @endif
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('products.show', $product->id) }}" 
                                       class="flex-1 bg-black text-white text-center py-2 rounded-lg font-semibold hover:bg-gray-800 transition">
                                        View Details
                                    </a>
                                    <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="w-full bg-gray-100 text-gray-700 py-2 rounded-lg hover:bg-gray-200 transition font-semibold">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-2xl font-semibold text-gray-700 mb-2">No Products Found</h3>
                    <p class="text-gray-600">Try adjusting your filters or search terms.</p>
                    <a href="{{ route('products.index') }}" class="mt-6 inline-block bg-black text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-800 transition">
                        View All Products
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
