<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Show all reviews for a product
    public function index($productId)
    {
        $reviews = Review::where('product_id', $productId)
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('reviews.index', compact('reviews', 'productId'));
    }

    // Store a new review
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
        ]);

        $product = Product::findOrFail($productId);

        // Check if user already reviewed this product
        $existing = Review::where('product_id', $productId)
            ->where('user_id', Auth::id())
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        Review::create([
            'product_id' => $productId,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'title' => $request->title,
            'content' => $request->content,
            'is_verified' => false,
        ]);

        return back()->with('success', 'Review submitted successfully!');
    }

    // Update a review
    public function update(Request $request, $reviewId)
    {
        $review = Review::findOrFail($reviewId);

        // Check authorization
        if ($review->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized');
        }

        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
        ]);

        $review->update($request->only(['rating', 'title', 'content']));

        return back()->with('success', 'Review updated successfully!');
    }

    // Delete a review
    public function destroy($reviewId)
    {
        $review = Review::findOrFail($reviewId);

        // Check authorization
        if ($review->user_id !== Auth::id() && !Auth::user()->is_admin) {
            return back()->with('error', 'Unauthorized');
        }

        $review->delete();

        return back()->with('success', 'Review deleted successfully!');
    }

    // Mark review as helpful
    public function markHelpful($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $review->increment('helpful_count');

        return response()->json(['helpful_count' => $review->helpful_count]);
    }
}
