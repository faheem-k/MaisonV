<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display all products with optional filters
     */
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);

        // Search by name or description
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // Price range filter
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sort options
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('rating', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);

        return view('products.index', compact('products'));
    }

    /**
     * Display new arrival products
     */
    public function newArrivals()
    {
        $products = Product::where('is_active', true)
            ->where('is_new', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('products.index', compact('products'));
    }

    /**
     * Display sale products
     */
    public function sale()
    {
        $products = Product::where('is_active', true)
            ->where('is_sale', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('products.index', compact('products'));
    }

    /**
     * Display bestseller products
     */
    public function bestsellers()
    {
        $products = Product::where('is_active', true)
            ->where('featured', true)
            ->orderBy('rating', 'desc')
            ->orderBy('reviews_count', 'desc')
            ->paginate(12);

        return view('products.index', compact('products'));
    }

    /**
     * Display products by category
     */
    public function category($category)
    {
        $products = Product::where('is_active', true)
            ->where('category', $category)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('products.index', compact('products'));
    }

    /**
     * Display single product details
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        // Get related products
        $relatedProducts = Product::where('is_active', true)
            ->where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Add product to cart (API endpoint)
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        // Create unique cart ID based on product, size, and color
        $cartId = $product->id;
        if ($request->size) {
            $cartId .= '-' . $request->size;
        }
        if ($request->color) {
            $cartId .= '-' . $request->color;
        }

        // If item already exists, increase quantity
        if (isset($cart[$cartId])) {
            $cart[$cartId]['quantity'] += $request->quantity ?? 1;
        } else {
            // Add new item to cart
            $cart[$cartId] = [
                "product_id" => $product->id,
                "name" => $product->name,
                "quantity" => $request->quantity ?? 1,
                "price" => $product->price,
                "image" => $product->image,
                "size" => $request->size,
                "color" => $request->color,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
}
