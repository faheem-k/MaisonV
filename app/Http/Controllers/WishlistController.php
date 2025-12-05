<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    // Show user's wishlist
    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->paginate(12);

        return view('wishlist.index', compact('wishlistItems'));
    }

    // Toggle wishlist item (add/remove)
    public function toggle($productId)
    {
        $product = Product::findOrFail($productId);

        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $isInWishlist = false;
            $message = 'Removed from wishlist';
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
            ]);
            $isInWishlist = true;
            $message = 'Added to wishlist';
        }

        if (request()->wantsJson()) {
            return response()->json([
                'isInWishlist' => $isInWishlist,
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }

    // Add to wishlist
    public function add($productId)
    {
        $product = Product::findOrFail($productId);

        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->exists();

        if (!$exists) {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
            ]);
        }

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Added to wishlist']);
        }

        return back()->with('success', 'Added to wishlist');
    }

    // Remove from wishlist
    public function remove($productId)
    {
        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->delete();

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Removed from wishlist']);
        }

        return back()->with('success', 'Removed from wishlist');
    }

    // Check if product is in wishlist
    public function isInWishlist($productId)
    {
        $isInWishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->exists();

        return response()->json(['isInWishlist' => $isInWishlist]);
    }
}
