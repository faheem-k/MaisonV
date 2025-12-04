@extends('layouts.app')

@section('title', $product->name . ' - Maison V')

@section('content')
<div class="container mx-auto px-4 py-12">
    <!-- Breadcrumb -->
    <div class="flex items-center mb-8 text-sm">
        <a href="{{ route('home') }}" class="text-gray-600 hover:text-black">Home</a>
        <span class="mx-3 text-gray-400">/</span>
        <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-black">Products</a>
        <span class="mx-3 text-gray-400">/</span>
        <span class="text-gray-900">{{ $product->name }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Product Images -->
        <div>
            <div class="bg-gray-100 rounded-lg overflow-hidden mb-6">
                <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=600' }}" 
                     alt="{{ $product->name }}"
                     class="w-full h-auto object-cover">
            </div>
            <div class="flex gap-4">
                <div class="w-20 h-20 bg-gray-100 rounded-lg cursor-pointer overflow-hidden">
                    <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=100' }}" 
                         alt="{{ $product->name }}" class="w-full h-full object-cover">
                </div>
                <div class="w-20 h-20 bg-gray-100 rounded-lg cursor-pointer overflow-hidden">
                    <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=100' }}" 
                         alt="{{ $product->name }}" class="w-full h-full object-cover">
                </div>
                <div class="w-20 h-20 bg-gray-100 rounded-lg cursor-pointer overflow-hidden">
                    <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=100' }}" 
                         alt="{{ $product->name }}" class="w-full h-full object-cover">
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div>
            <div class="mb-6">
                <div class="text-xs text-gray-500 uppercase tracking-wide mb-2">{{ $product->category ?? 'Fashion' }}</div>
                <h1 class="text-4xl font-bold text-gray-900 mb-3">{{ $product->name }}</h1>
                
                <!-- Rating -->
                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-400">
                        @for($i = 0; $i < 5; $i++)
                            @if($i < $product->rating)
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-gray-600 ml-3">({{ $product->reviews_count }} reviews)</span>
                </div>

                <!-- Price -->
                <div class="flex items-center gap-4 mb-6">
                    <span class="text-4xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                    @if($product->original_price)
                        <span class="text-xl text-gray-400 line-through">${{ number_format($product->original_price, 2) }}</span>
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">
                            Save {{ $product->discount_percentage }}%
                        </span>
                    @endif
                </div>

                <!-- Stock Status -->
                <div class="mb-6">
                    @if($product->stock > 0)
                        <span class="text-green-600 font-semibold">✓ In Stock ({{ $product->stock }} available)</span>
                    @else
                        <span class="text-red-600 font-semibold">Out of Stock</span>
                    @endif
                </div>

                <!-- Description -->
                <p class="text-gray-700 leading-relaxed mb-8">{{ $product->description }}</p>

                <!-- Add to Cart Form -->
                <form action="{{ route('cart.add') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <!-- Quantity -->
                    <div>
                        <label class="block text-sm font-semibold mb-2">Quantity</label>
                        <div class="flex items-center border border-gray-300 rounded-lg w-fit">
                            <button type="button" class="px-4 py-2 text-gray-600 hover:text-black" onclick="decrementQty()">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                   class="w-16 text-center border-l border-r border-gray-300 py-2 focus:outline-none">
                            <button type="button" class="px-4 py-2 text-gray-600 hover:text-black" onclick="incrementQty()">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Size -->
                    @if($product->sizes)
                        <div>
                            <label class="block text-sm font-semibold mb-2">Size</label>
                            <div class="flex gap-3">
                                @foreach(json_decode($product->sizes, true) ?? [] as $size)
                                    <label class="flex items-center">
                                        <input type="radio" name="size" value="{{ $size }}" class="mr-2">
                                        <span class="text-gray-700">{{ $size }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Color -->
                    @if($product->colors)
                        <div>
                            <label class="block text-sm font-semibold mb-2">Color</label>
                            <div class="flex gap-3">
                                @foreach(json_decode($product->colors, true) ?? [] as $color)
                                    <label class="flex items-center">
                                        <input type="radio" name="color" value="{{ $color }}" class="mr-2">
                                        <span class="text-gray-700">{{ $color }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Buttons -->
                    <div class="flex gap-4 pt-6">
                        <button type="submit" class="flex-1 bg-black text-white py-4 rounded-lg font-semibold hover:bg-gray-800 transition text-lg {{ $product->stock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $product->stock <= 0 ? 'disabled' : '' }}>
                            <i class="fas fa-shopping-bag mr-2"></i>Add to Cart
                        </button>
                        <button type="button" class="flex-1 border-2 border-black text-black py-4 rounded-lg font-semibold hover:bg-black hover:text-white transition text-lg">
                            <i class="far fa-heart mr-2"></i>Wishlist
                        </button>
                    </div>

                    <!-- Shipping Info -->
                    <div class="bg-gray-50 rounded-lg p-4 space-y-3 text-sm">
                        <div class="flex items-start">
                            <i class="fas fa-truck text-gray-700 mr-3 mt-1"></i>
                            <div>
                                <span class="font-semibold text-gray-900">Free Shipping</span>
                                <p class="text-gray-600">On orders over $100</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-shield-alt text-gray-700 mr-3 mt-1"></i>
                            <div>
                                <span class="font-semibold text-gray-900">Secure Payment</span>
                                <p class="text-gray-600">100% safe and secure checkout</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-undo text-gray-700 mr-3 mt-1"></i>
                            <div>
                                <span class="font-semibold text-gray-900">Easy Returns</span>
                                <p class="text-gray-600">30-day money back guarantee</p>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Product Meta -->
                <div class="border-t border-gray-200 mt-8 pt-8">
                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">SKU:</span>
                            <span class="font-semibold text-gray-900">{{ $product->sku ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Category:</span>
                            <a href="{{ route('products.category', $product->category) }}" class="font-semibold text-gray-900 hover:text-black">
                                {{ $product->category }}
                            </a>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Availability:</span>
                            <span class="font-semibold text-gray-900">{{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="mt-20">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">You Might Also Like</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($relatedProducts as $related)
                    <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="relative overflow-hidden bg-gray-100 h-64">
                            <img src="{{ $related->image ?? 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=300' }}" 
                                 alt="{{ $related->name }}"
                                 class="w-full h-full object-cover hover:scale-110 transition duration-500">
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 mb-2">{{ $related->name }}</h3>
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-900">${{ number_format($related->price, 2) }}</span>
                                <a href="{{ route('products.show', $related->id) }}" class="text-black hover:text-gray-700">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
function incrementQty() {
    const qty = document.getElementById('quantity');
    qty.value = parseInt(qty.value) + 1;
}

function decrementQty() {
    const qty = document.getElementById('quantity');
    if (parseInt(qty.value) > 1) {
        qty.value = parseInt(qty.value) - 1;
    }
}
</script>
@endsection
