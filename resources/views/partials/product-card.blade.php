<div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
    <div class="relative overflow-hidden">
        <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=400' }}" 
             alt="{{ $product->name }}" 
             class="w-full h-80 object-cover">
        <div class="absolute top-4 right-4">
            <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                @csrf
                <button type="submit" class="bg-white rounded-full p-2 shadow-md hover:bg-gray-100 transition">
                    <i class="far fa-heart text-gray-700"></i>
                </button>
            </form>
        </div>
        @if(isset($product->is_new) && $product->is_new)
        <span class="absolute top-4 left-4 bg-black text-white text-xs px-3 py-1 rounded-full font-semibold">NEW</span>
        @endif
        @if(isset($product->discount_percentage) && $product->discount_percentage > 0)
        <span class="absolute top-4 left-4 bg-red-600 text-white text-xs px-3 py-1 rounded-full font-semibold">
            -{{ $product->discount_percentage }}%
        </span>
        @endif
    </div>
    <div class="p-5">
        <div class="text-xs text-gray-500 mb-2 uppercase tracking-wide">
            {{ $product->category ?? 'Fashion' }}
        </div>
        <h3 class="font-semibold text-gray-800 mb-2 text-lg">{{ $product->name }}</h3>
        
        @if(isset($product->rating))
        <div class="flex items-center mb-3">
            <div class="flex text-yellow-400 text-sm">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= floor($product->rating))
                        <i class="fas fa-star"></i>
                    @elseif($i - 0.5 <= $product->rating)
                        <i class="fas fa-star-half-alt"></i>
                    @else
                        <i class="far fa-star"></i>
                    @endif
                @endfor
            </div>
            <span class="text-gray-500 text-sm ml-2">({{ number_format($product->rating, 1) }})</span>
        </div>
        @endif
        
        <div class="flex items-center justify-between">
            <div>
                <span class="text-2xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                @if(isset($product->original_price) && $product->original_price > $product->price)
                <span class="text-sm text-gray-400 line-through ml-2">${{ number_format($product->original_price, 2) }}</span>
                @endif
            </div>
        </div>
        
        <div class="mt-4 flex space-x-2">
            <a href="{{ route('products.show', $product->id) }}" 
               class="flex-1 bg-black text-white text-center py-2 rounded-lg font-semibold hover:bg-gray-800 transition">
                View Details
            </a>
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                    <i class="fas fa-shopping-cart"></i>
                </button>
            </form>
        </div>
    </div>
</div>