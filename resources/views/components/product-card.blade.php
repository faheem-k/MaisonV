<!-- Product Card Component -->
<div class="product-card bg-white rounded-lg overflow-hidden shadow-md">
    <div class="relative">
        <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=400' }}" 
             alt="{{ $product->name }}" 
             class="w-full h-64 object-cover">
        @if($product->is_sale ?? false)
            <span class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Sale</span>
        @endif
    </div>
    
    <div class="p-4">
        <h3 class="font-semibold text-lg text-gray-800 truncate">{{ $product->name }}</h3>
        <p class="text-gray-600 text-sm mb-2">{{ Str::limit($product->description, 60) }}</p>
        
        <div class="flex items-center justify-between mb-4">
            <span class="text-2xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
            <div class="flex items-center text-yellow-400">
                <i class="fas fa-star"></i>
                <span class="ml-1 text-sm text-gray-600">{{ $product->rating ?? '4.5' }}</span>
            </div>
        </div>
        
        <div class="flex gap-2">
            <a href="/products/{{ $product->id }}" 
               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 rounded-lg font-semibold transition">
                View Details
            </a>
            <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-lg transition">
                <i class="fas fa-heart"></i>
            </button>
        </div>
    </div>
</div>
