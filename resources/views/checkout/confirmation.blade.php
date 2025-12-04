@extends('layouts.app')

@section('title', 'Order Confirmation - Maison V')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-2xl mx-auto">
        <!-- Success Message -->
        <div class="text-center mb-12">
            <div class="mb-6">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full">
                    <i class="fas fa-check text-4xl text-green-600"></i>
                </div>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Order Confirmed!</h1>
            <p class="text-xl text-gray-600 mb-2">Thank you for your purchase</p>
            <p class="text-gray-600">A confirmation email has been sent to {{ $order->customer_email }}</p>
        </div>

        <!-- Order Details -->
        <div class="bg-white rounded-lg shadow-sm p-8 mb-8">
            <div class="grid grid-cols-2 gap-8 mb-8">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Order Number</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $order->order_number }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Order Date</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $order->created_at->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Status</p>
                    <p class="text-2xl font-bold text-gray-900 capitalize">{{ $order->order_status }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Payment Status</p>
                    <span class="inline-block px-4 py-2 rounded-full font-semibold
                        @if($order->payment_status === 'paid') bg-green-100 text-green-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="border-t border-gray-200 pt-8 mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Shipping To</h2>
                <div class="text-gray-700">
                    <p class="font-semibold">{{ $order->customer_name }}</p>
                    <p>{{ $order->customer_address }}</p>
                    <p>{{ $order->city }}, {{ $order->state }} {{ $order->postal_code }}</p>
                    <p>{{ $order->country }}</p>
                    <p class="mt-4">
                        <span class="text-gray-600">Phone:</span>
                        <span class="font-semibold">{{ $order->customer_phone }}</span>
                    </p>
                </div>
            </div>

            <!-- Order Items -->
            <div class="border-t border-gray-200 pt-8 mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Order Items</h2>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex justify-between items-start pb-4 border-b">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $item->product->name }}</p>
                                <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                                @if($item->size)
                                    <p class="text-sm text-gray-600">Size: {{ $item->size }}</p>
                                @endif
                                @if($item->color)
                                    <p class="text-sm text-gray-600">Color: {{ $item->color }}</p>
                                @endif
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900">${{ number_format($item->price, 2) }}</p>
                                <p class="text-gray-600">x {{ $item->quantity }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="border-t border-gray-200 pt-8">
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold text-gray-900">${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    @if($order->discount > 0)
                        <div class="flex justify-between text-green-600">
                            <span>Discount</span>
                            <span class="font-semibold">-${{ number_format($order->discount, 2) }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-semibold text-gray-900">
                            @if($order->shipping === 0)
                                <span class="text-green-600">FREE</span>
                            @else
                                ${{ number_format($order->shipping, 2) }}
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tax</span>
                        <span class="font-semibold text-gray-900">${{ number_format($order->tax, 2) }}</span>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-gray-900">Total</span>
                        <span class="text-3xl font-bold text-gray-900">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="bg-white rounded-lg shadow-sm p-8 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Payment Information</h2>
            <div class="grid grid-cols-2 gap-8">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Payment Method</p>
                    <p class="text-gray-900 font-semibold capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Payment Status</p>
                    <span class="inline-block px-4 py-2 rounded-full font-semibold
                        @if($order->payment_status === 'paid') bg-green-100 text-green-800
                        @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-8 mb-8">
            <h2 class="text-xl font-bold text-blue-900 mb-4">What's Next?</h2>
            <ul class="space-y-3 text-blue-900">
                <li class="flex items-start">
                    <span class="inline-flex items-center justify-center w-6 h-6 bg-blue-200 text-blue-900 rounded-full text-sm font-bold mr-3 flex-shrink-0">1</span>
                    <span>You will receive an order confirmation email shortly</span>
                </li>
                <li class="flex items-start">
                    <span class="inline-flex items-center justify-center w-6 h-6 bg-blue-200 text-blue-900 rounded-full text-sm font-bold mr-3 flex-shrink-0">2</span>
                    <span>Your items will be packaged and shipped within 1-2 business days</span>
                </li>
                <li class="flex items-start">
                    <span class="inline-flex items-center justify-center w-6 h-6 bg-blue-200 text-blue-900 rounded-full text-sm font-bold mr-3 flex-shrink-0">3</span>
                    <span>You'll receive a tracking number via email when your order ships</span>
                </li>
                <li class="flex items-start">
                    <span class="inline-flex items-center justify-center w-6 h-6 bg-blue-200 text-blue-900 rounded-full text-sm font-bold mr-3 flex-shrink-0">4</span>
                    <span>Expect delivery in 5-7 business days depending on your location</span>
                </li>
            </ul>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-4">
            <a href="{{ route('products.index') }}" class="w-full block text-center bg-black text-white py-4 rounded-lg font-bold text-lg hover:bg-gray-800 transition">
                Continue Shopping
            </a>
            <button onclick="window.print()" class="w-full block text-center border-2 border-black text-black py-3 rounded-lg font-semibold hover:bg-black hover:text-white transition">
                <i class="fas fa-print mr-2"></i>Print Receipt
            </button>
        </div>

        <!-- Support Info -->
        <div class="mt-12 text-center text-gray-600 text-sm">
            <p class="mb-2">Questions about your order?</p>
            <p>Contact our customer service at <span class="font-semibold">support@maisonv.com</span> or call <span class="font-semibold">1-800-123-4567</span></p>
        </div>
    </div>
</div>
@endsection
