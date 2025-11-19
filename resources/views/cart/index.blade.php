@extends('layouts.app')

@section('title', 'Shopping Cart - Maison V')

@section('content')
<div class="container mx-auto px-4 py-12">
    <!-- Breadcrumb -->
    <nav class="text-sm mb-8">
        <ol class="flex items-center space-x-2 text-gray-600">
            <li><a href="{{ route('home') }}" class="hover:text-black">Home</a></li>
            <li><i class="fas fa-chevron-right text-xs"></i></li>
            <li class="text-black font-medium">Shopping Cart</li>
        </ol>
    </nav>

    <h1 class="text-4xl font-bold mb-8">Shopping Cart</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('cart') && count(session('cart')) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md">
                    <!-- Cart Header -->
                    <div class="hidden md:grid grid-cols-12 gap-4 p-6 border-b font-semibold text-gray-700">
                        <div class="col-span-6">Product</div>
                        <div class="col-span-2 text-center">Price</div>
                        <div class="col-span-2 text-center">Quantity</div>
                        <div class="col-span-2 text-right">Total</div>
                    </div>

                    <!-- Cart Items -->
                    @php $subtotal = 0; @endphp
                    @foreach(session('cart') as $id => $item)
                        @php 
                            $itemTotal = $item['price'] * $item['quantity'];
                            $subtotal += $itemTotal;
                        @endphp
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 p-6 border-b items-center">
                            <!-- Product Info -->
                            <div class="md:col-span-6 flex items-center space-x-4">
                                <img src="{{ $item['image'] ?? 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=400' }}" 
                                     alt="{{ $item['name'] }}" 
                                     class="w-24 h-24 object-cover rounded">
                                <div>
                                    <h3 class="font-semibold text-gray-800">{{ $item['name'] }}</h3>
                                    @if(isset($item['size']))
                                        <p class="text-sm text-gray-500">Size: {{ $item['size'] }}</p>
                                    @endif
                                    @if(isset($item['color']))
                                        <p class="text-sm text-gray-500">Color: {{ $item['color'] }}</p>
                                    @endif
                                    <!-- Mobile Price -->
                                    <p class="md:hidden text-gray-700 font-semibold mt-2">${{ number_format($item['price'], 2) }}</p>
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="hidden md:block md:col-span-2 text-center">
                                <p class="text-gray-700 font-semibold">${{ number_format($item['price'], 2) }}</p>
                            </div>

                            <!-- Quantity -->
                            <div class="md:col-span-2">
                                <div class="flex items-center justify-center space-x-2">
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}">
                                        <button type="submit" class="w-8 h-8 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center transition">
                                            <i class="fas fa-minus text-xs"></i>
                                        </button>
                                    </form>
                                    
                                    <span class="w-12 text-center font-semibold">{{ $item['quantity'] }}</span>
                                    
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                        <button type="submit" class="w-8 h-8 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center transition">
                                            <i class="fas fa-plus text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Total -->
                            <div class="md:col-span-2 flex items-center justify-between md:justify-end">
                                <span class="md:hidden text-gray-600">Subtotal:</span>
                                <p class="text-gray-900 font-bold">${{ number_format($itemTotal, 2) }}</p>
                            </div>

                            <!-- Remove Button (Mobile & Desktop) -->
                            <div class="md:col-span-12 md:-mt-4">
                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm flex items-center space-x-1">
                                        <i class="fas fa-trash-alt"></i>
                                        <span>Remove</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Continue Shopping & Clear Cart -->
                <div class="flex flex-col sm:flex-row justify-between items-center mt-6 space-y-4 sm:space-y-0">
                    <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-black font-medium flex items-center space-x-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Continue Shopping</span>
                    </a>
                    
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium" onclick="return confirm('Are you sure you want to clear your cart?')">
                            Clear Cart
                        </button>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                    <h2 class="text-2xl font-bold mb-6">Order Summary</h2>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between text-gray-700">
                            <span>Subtotal ({{ count(session('cart')) }} items)</span>
                            <span class="font-semibold">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between text-gray-700">
                            <span>Shipping</span>
                            <span class="font-semibold">
                                @if($subtotal >= 100)
                                    <span class="text-green-600">FREE</span>
                                @else
                                    ${{ number_format(10, 2) }}
                                @endif
                            </span>
                        </div>
                        
                        @php
                            $shipping = $subtotal >= 100 ? 0 : 10;
                            $tax = $subtotal * 0.08; // 8% tax
                            $total = $subtotal + $shipping + $tax;
                        @endphp
                        
                        <div class="flex justify-between text-gray-700">
                            <span>Tax (8%)</span>
                            <span class="font-semibold">${{ number_format($tax, 2) }}</span>
                        </div>
                        
                        <div class="border-t pt-4">
                            <div class="flex justify-between text-xl font-bold">
                                <span>Total</span>
                                <span>${{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Promo Code -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Promo Code</label>
                        <form action="{{ route('cart.apply-coupon') }}" method="POST" class="flex space-x-2">
                            @csrf
                            <input type="text" 
                                   name="coupon_code"
                                   placeholder="Enter code" 
                                   class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black">
                            <button type="submit" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg font-semibold transition">
                                Apply
                            </button>
                        </form>
                        @if($subtotal >= 100)
                            <p class="text-green-600 text-sm mt-2 flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                Free shipping applied!
                            </p>
                        @else
                            <p class="text-gray-600 text-sm mt-2">
                                Add ${{ number_format(100 - $subtotal, 2) }} more for free shipping
                            </p>
                        @endif
                    </div>

                    <!-- Checkout Button -->
                    <a href="{{ route('checkout.index') }}" class="block w-full bg-black text-white text-center py-3 rounded-lg font-semibold hover:bg-gray-800 transition mb-3">
                        Proceed to Checkout
                    </a>
                    
                    <button class="block w-full bg-yellow-400 text-black text-center py-3 rounded-lg font-semibold hover:bg-yellow-500 transition">
                        <i class="fab fa-paypal mr-2"></i>PayPal
                    </button>

                    <!-- Trust Badges -->
                    <div class="mt-6 pt-6 border-t space-y-3 text-sm text-gray-600">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-shield-alt text-green-600"></i>
                            <span>Secure Checkout</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-truck text-blue-600"></i>
                            <span>Free shipping over $100</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-undo text-purple-600"></i>
                            <span>30-day easy returns</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        <!-- Empty Cart -->
        <div class="text-center py-16">
            <div class="mb-6">
                <i class="fas fa-shopping-bag text-gray-300 text-8xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Your cart is empty</h2>
            <p class="text-gray-600 mb-8">Looks like you haven't added anything to your cart yet.</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-black text-white px-8 py-3 rounded-full font-semibold hover:bg-gray-800 transition">
                Start Shopping
            </a>
        </div>
    @endif

    <!-- You May Also Like -->
    @if(isset($recommendedProducts) && count($recommendedProducts) > 0)
    <section class="mt-16">
        <h2 class="text-3xl font-bold mb-8">You May Also Like</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($recommendedProducts as $product)
                <x-product-card :product="$product"/>
            @endforeach
        </div>
    </section>
    @endif
</div>

@push('scripts')
<script>
    // Auto-hide success message after 3 seconds
    setTimeout(function() {
        const alert = document.querySelector('.bg-green-100');
        if(alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);
</script>
@endpush
@endsection