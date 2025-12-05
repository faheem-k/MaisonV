@extends('layouts.app')

@section('content')
<div class="wishlist-container">
    <div class="wishlist-header">
        <h1>My Wishlist</h1>
    </div>

    @if($wishlistItems->count() > 0)
        <div class="wishlist-items">
            @foreach($wishlistItems as $item)
                <div class="wishlist-item">
                    <div class="wishlist-image">
                        <img src="{{ $item->product->image_url ?? 'https://via.placeholder.com/200' }}" alt="{{ $item->product->name }}">
                    </div>
                    <div class="wishlist-details">
                        <h3>{{ $item->product->name }}</h3>
                        <p class="product-description">{{ Str::limit($item->product->description, 100) }}</p>
                        <div class="product-rating">
                            <span class="stars">
                                @php
                                    $rating = $item->product->reviews->avg('rating') ?? 0;
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="star @if($i <= round($rating)) filled @endif">★</span>
                                @endfor
                            </span>
                            <span class="review-count">({{ $item->product->reviews->count() }} reviews)</span>
                        </div>
                    </div>
                    <div class="wishlist-price">
                        <span class="price">${{ number_format($item->product->price, 2) }}</span>
                        @if($item->product->discount_price)
                            <span class="original-price">${{ number_format($item->product->original_price, 2) }}</span>
                        @endif
                    </div>
                    <div class="wishlist-actions">
                        <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                        </form>
                        <form action="{{ route('wishlist.remove', $item->product->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="remove-from-wishlist-btn" title="Remove from Wishlist">Remove</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="wishlist-pagination">
            {{ $wishlistItems->links() }}
        </div>
    @else
        <div class="empty-wishlist">
            <div class="empty-wishlist-icon">♡</div>
            <h2>Your Wishlist is Empty</h2>
            <p>Add items to your wishlist to save them for later</p>
            <a href="{{ route('products.index') }}" class="continue-shopping-btn">Continue Shopping</a>
        </div>
    @endif
</div>

<style>
.wishlist-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 30px 20px;
}

.wishlist-header {
    margin-bottom: 30px;
    border-bottom: 2px solid #333;
    padding-bottom: 20px;
}

.wishlist-header h1 {
    font-size: 28px;
    color: #333;
}

.wishlist-items {
    display: grid;
    gap: 20px;
    margin-bottom: 30px;
}

.wishlist-item {
    display: flex;
    gap: 20px;
    padding: 15px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    background-color: #fff;
    transition: box-shadow 0.2s;
}

.wishlist-item:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.wishlist-image {
    flex-shrink: 0;
    width: 150px;
    height: 150px;
    overflow: hidden;
    border-radius: 4px;
}

.wishlist-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.wishlist-details {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.wishlist-details h3 {
    font-size: 16px;
    margin-bottom: 8px;
    color: #333;
}

.product-description {
    color: #666;
    font-size: 13px;
    margin-bottom: 10px;
}

.product-rating {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 12px;
}

.stars {
    color: #ffc107;
}

.star.filled {
    color: #ffc107;
}

.star {
    color: #ddd;
}

.review-count {
    color: #999;
}

.wishlist-price {
    flex-shrink: 0;
    text-align: right;
    padding: 10px;
}

.price {
    display: block;
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.original-price {
    display: block;
    font-size: 12px;
    color: #999;
    text-decoration: line-through;
}

.wishlist-actions {
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
    justify-content: center;
}

.add-to-cart-btn,
.remove-from-wishlist-btn {
    padding: 8px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
    transition: background-color 0.2s;
}

.add-to-cart-btn {
    background-color: #333;
    color: white;
}

.add-to-cart-btn:hover {
    background-color: #555;
}

.remove-from-wishlist-btn {
    background-color: #f0f0f0;
    color: #333;
    border: 1px solid #ddd;
}

.remove-from-wishlist-btn:hover {
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

.empty-wishlist {
    text-align: center;
    padding: 60px 20px;
}

.empty-wishlist-icon {
    font-size: 60px;
    margin-bottom: 20px;
    opacity: 0.5;
}

.empty-wishlist h2 {
    font-size: 24px;
    margin-bottom: 10px;
    color: #333;
}

.empty-wishlist p {
    color: #666;
    margin-bottom: 30px;
}

.continue-shopping-btn {
    display: inline-block;
    padding: 12px 30px;
    background-color: #333;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.2s;
}

.continue-shopping-btn:hover {
    background-color: #555;
}

.wishlist-pagination {
    display: flex;
    justify-content: center;
    margin-top: 30px;
}

@media (max-width: 768px) {
    .wishlist-item {
        flex-direction: column;
        text-align: center;
    }

    .wishlist-image {
        width: 100%;
        height: 200px;
    }

    .wishlist-price {
        text-align: center;
    }

    .wishlist-actions {
        flex-direction: row;
        justify-content: center;
    }
}
</style>
@endsection
