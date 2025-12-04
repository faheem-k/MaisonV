@extends('layouts.app')

@section('title', 'Checkout - Maison V')

@section('content')
<div class="container mx-auto px-4 py-12">
    <!-- Breadcrumb -->
    <div class="flex items-center mb-8 text-sm">
        <a href="{{ route('home') }}" class="text-gray-600 hover:text-black">Home</a>
        <span class="mx-3 text-gray-400">/</span>
        <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-black">Cart</a>
        <span class="mx-3 text-gray-400">/</span>
        <span class="text-gray-900">Checkout</span>
    </div>

    <h1 class="text-4xl font-bold text-gray-900 mb-8">Checkout</h1>

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('checkout.store') }}" method="POST" class="space-y-8">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Checkout Form -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Shipping Information -->
                <div class="bg-white rounded-lg shadow-sm p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Shipping Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                            <input type="text" name="customer_name" value="{{ old('customer_name') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black @error('customer_name') border-red-500 @enderror"
                                   required>
                            @error('customer_name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                            <input type="email" name="customer_email" value="{{ old('customer_email') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black @error('customer_email') border-red-500 @enderror"
                                   required>
                            @error('customer_email')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number *</label>
                            <input type="tel" name="customer_phone" value="{{ old('customer_phone') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black @error('customer_phone') border-red-500 @enderror"
                                   required>
                            @error('customer_phone')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Street Address *</label>
                            <input type="text" name="customer_address" value="{{ old('customer_address') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black @error('customer_address') border-red-500 @enderror"
                                   required>
                            @error('customer_address')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">City *</label>
                            <input type="text" name="city" value="{{ old('city') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black @error('city') border-red-500 @enderror"
                                   required>
                            @error('city')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">State/Province</label>
                            <input type="text" name="state" value="{{ old('state') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black @error('state') border-red-500 @enderror">
                            @error('state')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Postal Code *</label>
                            <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black @error('postal_code') border-red-500 @enderror"
                                   required>
                            @error('postal_code')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Country *</label>
                            <input type="text" name="country" value="{{ old('country', 'United States') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black @error('country') border-red-500 @enderror"
                                   required>
                            @error('country')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white rounded-lg shadow-sm p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Payment Method</h2>
                    <div class="space-y-4">
                        <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-black transition" onclick="selectPayment('credit_card')">
                            <input type="radio" name="payment_method" value="credit_card" checked class="w-4 h-4">
                            <span class="ml-3 text-gray-900 font-semibold">Credit Card</span>
                        </label>
                        <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-black transition" onclick="selectPayment('debit_card')">
                            <input type="radio" name="payment_method" value="debit_card" class="w-4 h-4">
                            <span class="ml-3 text-gray-900 font-semibold">Debit Card</span>
                        </label>
                        <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-black transition" onclick="selectPayment('paypal')">
                            <input type="radio" name="payment_method" value="paypal" class="w-4 h-4">
                            <span class="ml-3 text-gray-900 font-semibold"><i class="fab fa-paypal mr-2"></i>PayPal</span>
                        </label>
                        <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-black transition" onclick="selectPayment('bank_transfer')">
                            <input type="radio" name="payment_method" value="bank_transfer" class="w-4 h-4">
                            <span class="ml-3 text-gray-900 font-semibold">Bank Transfer</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-8 sticky top-24">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Order Summary</h2>

                    <!-- Order Items -->
                    <div class="space-y-4 mb-6 max-h-64 overflow-y-auto">
                        @foreach($cart as $item)
                            <div class="flex justify-between items-start pb-4 border-b">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $item['name'] }}</p>
                                    <p class="text-sm text-gray-600">Qty: {{ $item['quantity'] }}</p>
                                </div>
                                <p class="font-bold text-gray-900">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                            </div>
                        @endforeach
                    </div>

                    <!-- Price Breakdown -->
                    <div class="space-y-3 mb-6 border-t border-gray-200 pt-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold text-gray-900">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        @if($discount > 0)
                            <div class="flex justify-between text-green-600">
                                <span>Discount</span>
                                <span class="font-semibold">-${{ number_format($discount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-600">Shipping</span>
                            <span class="font-semibold text-gray-900">
                                @if($shipping === 0)
                                    <span class="text-green-600">FREE</span>
                                @else
                                    ${{ number_format($shipping, 2) }}
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tax (10%)</span>
                            <span class="font-semibold text-gray-900">${{ number_format($tax, 2) }}</span>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="border-t border-gray-200 pt-6 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-gray-900">Total</span>
                            <span class="text-3xl font-bold text-gray-900">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <!-- Place Order Button -->
                    <button type="submit" class="w-full bg-black text-white py-4 rounded-lg font-bold text-lg hover:bg-gray-800 transition mb-3">
                        Place Order
                    </button>

                    <!-- Back to Cart -->
                    <a href="{{ route('cart.index') }}" class="w-full block text-center border-2 border-black text-black py-3 rounded-lg font-semibold hover:bg-black hover:text-white transition">
                        Back to Cart
                    </a>

                    <!-- Security Info -->
                    <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg text-sm text-blue-800">
                        <p class="flex items-center">
                            <i class="fas fa-lock mr-2"></i>
                            Your payment information is secure and encrypted
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function selectPayment(method) {
    document.querySelector(`input[value="${method}"]`).checked = true;
}
</script>
@endsection


@section('title', 'Checkout - Maison V')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold mb-8">Checkout</h1>
    <p class="text-gray-600">Checkout page coming soon...</p>
</div>
@endsection