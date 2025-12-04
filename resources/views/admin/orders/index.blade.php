@extends('layouts.app')

@section('title', 'Orders Management - Admin Panel')

@section('content')
<div class="bg-gray-900 text-white min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold">Orders Management</h1>
                <p class="text-gray-400 mt-2">View and manage all customer orders</p>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-blue-400">{{ $orders->total() }}</p>
                <p class="text-gray-400">Total Orders</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-gray-800 border border-gray-700 rounded-lg p-6 mb-8">
            <form method="GET" action="{{ route('admin.orders') }}" class="flex gap-4">
                <div class="flex-1">
                    <input type="text" name="search" placeholder="Search by order #, customer, email..."
                           value="{{ request('search') }}"
                           class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded focus:outline-none focus:border-blue-500">
                </div>
                <select name="status" class="px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded focus:outline-none focus:border-blue-500">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <select name="payment_status" class="px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded focus:outline-none focus:border-blue-500">
                    <option value="">All Payment Status</option>
                    <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Unpaid</option>
                    <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="refunded" {{ request('payment_status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-semibold transition">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
            </form>
        </div>

        <!-- Orders Table -->
        @if($orders->count() > 0)
            <div class="bg-gray-800 border border-gray-700 rounded-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-700 border-b border-gray-600">
                        <tr>
                            <th class="px-6 py-4 text-left">Order #</th>
                            <th class="px-6 py-4 text-left">Customer</th>
                            <th class="px-6 py-4 text-right">Amount</th>
                            <th class="px-6 py-4 text-center">Order Status</th>
                            <th class="px-6 py-4 text-center">Payment</th>
                            <th class="px-6 py-4 text-left">Date</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr class="border-b border-gray-700 hover:bg-gray-750 transition">
                                <td class="px-6 py-4 font-mono text-blue-400">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="hover:text-blue-300">
                                        #{{ $order->order_number }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-semibold">{{ $order->customer_name }}</p>
                                        <p class="text-gray-400 text-sm">{{ $order->customer_email }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-green-400">
                                    ${{ number_format($order->total, 2) }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-900 text-yellow-200',
                                            'processing' => 'bg-blue-900 text-blue-200',
                                            'shipped' => 'bg-purple-900 text-purple-200',
                                            'delivered' => 'bg-green-900 text-green-200',
                                            'cancelled' => 'bg-red-900 text-red-200',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $statusColors[$order->order_status] ?? 'bg-gray-700' }}">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $paymentColors = [
                                            'pending' => 'bg-yellow-900 text-yellow-200',
                                            'paid' => 'bg-green-900 text-green-200',
                                            'failed' => 'bg-red-900 text-red-200',
                                            'refunded' => 'bg-gray-700 text-gray-300',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $paymentColors[$order->payment_status] ?? 'bg-gray-700' }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-400 text-sm">
                                    {{ $order->created_at->format('M d, Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-400 hover:text-blue-300 mr-3" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button onclick="if(confirm('Delete this order?')) { document.getElementById('delete-form-{{ $order->id }}').submit(); }" class="text-red-400 hover:text-red-300" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $order->id }}" action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $orders->links() }}
                </div>
            @endif
        @else
            <div class="bg-gray-800 border border-gray-700 rounded-lg p-12 text-center">
                <i class="fas fa-box-open text-4xl text-gray-600 mb-4"></i>
                <p class="text-xl text-gray-400">No orders found</p>
                <p class="text-gray-500 mt-2">Try adjusting your search or filters</p>
            </div>
        @endif
    </div>
</div>
@endsection
