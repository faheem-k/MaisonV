@extends('layouts.app')

@section('title', 'Order ' . $order->order_number . ' - Admin Panel')

@section('content')
<div class="bg-gray-900 text-white min-h-screen py-8">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Header -->
        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-4xl font-bold">Order {{ $order->order_number }}</h1>
                <p class="text-gray-400 mt-2">{{ $order->created_at->format('M d, Y H:i') }}</p>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-green-400">${{ number_format($order->total, 2) }}</p>
                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-900 text-yellow-200',
                        'processing' => 'bg-blue-900 text-blue-200',
                        'shipped' => 'bg-purple-900 text-purple-200',
                        'delivered' => 'bg-green-900 text-green-200',
                        'cancelled' => 'bg-red-900 text-red-200',
                    ];
                @endphp
                <span class="px-4 py-2 rounded-full text-sm font-bold {{ $statusColors[$order->order_status] ?? 'bg-gray-700' }}">
                    {{ ucfirst($order->order_status) }}
                </span>
            </div>
        </div>

        <!-- Status Update Form -->
        <div class="bg-gray-800 border border-gray-700 rounded-lg p-6 mb-8">
            <h2 class="text-xl font-bold mb-4">Update Order Status</h2>
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="flex gap-4">
                @csrf
                @method('PUT')
                <select name="order_status" class="flex-1 px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded focus:outline-none focus:border-blue-500">
                    <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ $order->order_status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-semibold transition">
                    <i class="fas fa-save mr-2"></i>Update Status
                </button>
                <a href="{{ route('admin.orders') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2 rounded font-semibold transition">
                    Back to Orders
                </a>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content (Left) -->
            <div class="lg:col-span-2">
                <!-- Customer Information -->
                <div class="bg-gray-800 border border-gray-700 rounded-lg p-6 mb-6">
                    <h3 class="text-xl font-bold mb-4 pb-2 border-b border-gray-700">Customer Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-400 text-sm">Full Name</p>
                            <p class="font-semibold">{{ $order->customer_name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Email</p>
                            <p class="font-semibold">{{ $order->customer_email }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Phone</p>
                            <p class="font-semibold">{{ $order->customer_phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Customer ID</p>
                            <p class="font-semibold">{{ $order->user_id ?? 'Guest' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="bg-gray-800 border border-gray-700 rounded-lg p-6 mb-6">
                    <h3 class="text-xl font-bold mb-4 pb-2 border-b border-gray-700">Shipping Address</h3>
                    <p class="font-semibold">{{ $order->customer_name }}</p>
                    <p class="text-gray-300">{{ $order->customer_address }}</p>
                    <p class="text-gray-300">{{ $order->city }}, {{ $order->state }} {{ $order->postal_code }}</p>
                    <p class="text-gray-300">{{ $order->country }}</p>
                </div>

                <!-- Order Items -->
                <div class="bg-gray-800 border border-gray-700 rounded-lg p-6 mb-6">
                    <h3 class="text-xl font-bold mb-4 pb-2 border-b border-gray-700">Order Items</h3>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex justify-between items-center pb-4 border-b border-gray-700 last:border-b-0 last:pb-0">
                                <div class="flex-1">
                                    <p class="font-semibold">{{ $item->product->name ?? 'Product Deleted' }}</p>
                                    <p class="text-gray-400 text-sm">
                                        @if($item->size) Size: {{ $item->size }} @endif
                                        @if($item->color) | Color: {{ $item->color }} @endif
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold">Qty: {{ $item->quantity }}</p>
                                    <p class="text-gray-400 text-sm">${{ number_format($item->price, 2) }} each</p>
                                </div>
                                <div class="text-right ml-4 min-w-24">
                                    <p class="font-bold text-green-400">${{ number_format($item->quantity * $item->price, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="bg-gray-800 border border-gray-700 rounded-lg p-6">
                    <h3 class="text-xl font-bold mb-4 pb-2 border-b border-gray-700">Payment Information</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Payment Method:</span>
                            <span class="font-semibold">{{ ucfirst($order->payment_method ?? 'Not specified') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Payment Status:</span>
                            @php
                                $paymentColors = [
                                    'pending' => 'text-yellow-400',
                                    'paid' => 'text-green-400',
                                    'failed' => 'text-red-400',
                                    'refunded' => 'text-gray-400',
                                ];
                            @endphp
                            <span class="font-semibold {{ $paymentColors[$order->payment_status] ?? 'text-gray-400' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        @if($order->payment && $order->payment->transaction_id)
                            <div class="flex justify-between">
                                <span class="text-gray-400">Transaction ID:</span>
                                <span class="font-mono text-sm">{{ $order->payment->transaction_id }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar (Right) -->
            <div>
                <!-- Order Summary -->
                <div class="bg-gray-800 border border-gray-700 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-bold mb-4 pb-2 border-b border-gray-700">Order Summary</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Subtotal:</span>
                            <span>${{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        @if($order->discount > 0)
                            <div class="flex justify-between text-green-400">
                                <span>Discount:</span>
                                <span>-${{ number_format($order->discount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-400">Shipping:</span>
                            <span>${{ number_format($order->shipping, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Tax:</span>
                            <span>${{ number_format($order->tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold pt-3 border-t border-gray-700">
                            <span>Total:</span>
                            <span class="text-green-400">${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Order Details -->
                <div class="bg-gray-800 border border-gray-700 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-bold mb-4 pb-2 border-b border-gray-700">Details</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-400">Order Number</p>
                            <p class="font-mono">{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400">Order Date</p>
                            <p>{{ $order->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400">Status History</p>
                            <p class="px-2 py-1 bg-gray-700 rounded mt-1 font-mono text-xs">
                                {{ ucfirst($order->order_status) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="space-y-3">
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded font-semibold transition">
                        <i class="fas fa-envelope mr-2"></i>Send Email
                    </button>
                    <button onclick="if(confirm('Are you sure?')) { document.getElementById('delete-order').submit(); }" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded font-semibold transition">
                        <i class="fas fa-trash mr-2"></i>Delete Order
                    </button>
                    <form id="delete-order" action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
