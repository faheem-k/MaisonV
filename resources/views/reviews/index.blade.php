<div class="reviews-section">
    <h2 class="reviews-title">Customer Reviews</h2>

    @if($reviews->count() > 0)
        <div class="reviews-list">
            @foreach($reviews as $review)
                <div class="review-item">
                    <div class="review-header">
                        <div class="review-user">
                            <strong>{{ $review->user->name }}</strong>
                            @if($review->is_verified)
                                <span class="verified-badge">✓ Verified Purchase</span>
                            @endif
                        </div>
                        <div class="review-rating">
                            <span class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="star @if($i <= $review->rating) filled @endif">★</span>
                                @endfor
                            </span>
                            <small class="review-date">{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                    </div>

                    <h4 class="review-title">{{ $review->title }}</h4>
                    <p class="review-content">{{ $review->content }}</p>

                    <div class="review-footer">
                        <button class="helpful-btn" onclick="markHelpful({{ $review->id }})">
                            👍 Helpful (<span id="helpful-{{ $review->id }}">{{ $review->helpful_count }}</span>)
                        </button>

                        @if(Auth::check() && Auth::id() === $review->user_id)
                            <a href="#" class="edit-review-btn" onclick="editReview({{ $review->id }})">Edit</a>
                            <form action="{{ route('reviews.destroy', $review) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-review-btn" onclick="return confirm('Delete this review?')">Delete</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="reviews-pagination">
            {{ $reviews->links() }}
        </div>
    @else
        <p class="no-reviews">No reviews yet. Be the first to review!</p>
    @endif

    @if(Auth::check())
        <div class="review-form-section">
            <h3>Leave a Review</h3>
            <form action="{{ route('reviews.store', $productId) }}" method="POST" class="review-form">
                @csrf
                <div class="form-group">
                    <label for="rating">Rating:</label>
                    <div class="rating-input">
                        @for($i = 1; $i <= 5; $i++)
                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required>
                            <label for="star{{ $i }}" class="star-label">★</label>
                        @endfor
                    </div>
                </div>

                <div class="form-group">
                    <label for="title">Review Title:</label>
                    <input type="text" id="title" name="title" required placeholder="Brief title for your review" maxlength="255">
                </div>

                <div class="form-group">
                    <label for="content">Review:</label>
                    <textarea id="content" name="content" required placeholder="Share your experience with this product" rows="5" maxlength="1000"></textarea>
                </div>

                <button type="submit" class="submit-review-btn">Submit Review</button>
            </form>
        </div>
    @else
        <p class="login-to-review">Login to leave a review</p>
    @endif
</div>

<style>
.reviews-section {
    margin: 30px 0;
    padding: 20px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
}

.reviews-title {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
}

.reviews-list {
    margin-bottom: 30px;
}

.review-item {
    padding: 15px;
    border-bottom: 1px solid #f0f0f0;
    margin-bottom: 15px;
}

.review-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

.review-user strong {
    font-size: 16px;
    color: #333;
}

.verified-badge {
    display: inline-block;
    margin-left: 10px;
    padding: 2px 8px;
    background-color: #d4edda;
    color: #155724;
    border-radius: 3px;
    font-size: 12px;
}

.review-rating {
    text-align: right;
}

.stars {
    color: #ffc107;
    font-size: 16px;
}

.star.filled {
    color: #ffc107;
}

.star {
    color: #ddd;
}

.review-date {
    display: block;
    color: #999;
    font-size: 12px;
    margin-top: 5px;
}

.review-title {
    font-size: 16px;
    font-weight: 600;
    margin: 10px 0;
    color: #333;
}

.review-content {
    color: #666;
    line-height: 1.6;
    margin-bottom: 10px;
}

.review-footer {
    display: flex;
    gap: 15px;
    align-items: center;
    margin-top: 10px;
}

.helpful-btn, .edit-review-btn, .delete-review-btn {
    padding: 5px 10px;
    background-color: #f0f0f0;
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
    transition: background-color 0.2s;
}

.helpful-btn:hover, .edit-review-btn:hover {
    background-color: #e0e0e0;
}

.delete-review-btn:hover {
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

.no-reviews {
    text-align: center;
    color: #999;
    padding: 20px;
}

.review-form-section {
    margin-top: 30px;
    padding-top: 30px;
    border-top: 1px solid #e0e0e0;
}

.review-form-section h3 {
    font-size: 18px;
    margin-bottom: 20px;
    color: #333;
}

.review-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-weight: 600;
    margin-bottom: 5px;
    color: #333;
}

.form-group input[type="text"],
.form-group textarea {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-family: inherit;
}

.rating-input {
    display: flex;
    gap: 10px;
    font-size: 30px;
}

.rating-input input[type="radio"] {
    display: none;
}

.star-label {
    cursor: pointer;
    color: #ddd;
    transition: color 0.2s;
}

.rating-input input[type="radio"]:checked ~ .star-label,
.star-label:hover,
.star-label:has(~ input[type="radio"]:checked) {
    color: #ffc107;
}

.submit-review-btn {
    padding: 10px 20px;
    background-color: #333;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.2s;
}

.submit-review-btn:hover {
    background-color: #555;
}

.login-to-review {
    text-align: center;
    color: #666;
    padding: 20px;
}

.login-to-review a {
    color: #007bff;
    text-decoration: none;
}

.login-to-review a:hover {
    text-decoration: underline;
}
</style>

<script>
function markHelpful(reviewId) {
    fetch(`/reviews/${reviewId}/helpful`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById(`helpful-${reviewId}`).textContent = data.helpful_count;
    });
}

function editReview(reviewId) {
    alert('Edit functionality to be implemented');
}
</script>
