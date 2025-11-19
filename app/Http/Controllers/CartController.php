<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the shopping cart
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Get recommended products (optional)
        $recommendedProducts = Product::where('is_active', true)
            ->where('featured', true)
            ->inRandomOrder()
            ->limit(4)
            ->get();
        
        return view('cart.index', compact('cart', 'recommendedProducts'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
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
        if(isset($cart[$cartId])) {
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

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart');
        
        if(isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Cart updated successfully!');
        }
        
        return redirect()->back()->with('error', 'Item not found in cart!');
    }

    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        $cart = session()->get('cart');
        
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product removed from cart!');
        }
        
        return redirect()->back()->with('error', 'Item not found in cart!');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared successfully!');
    }

    /**
     * Apply coupon code
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $couponCode = strtoupper($request->coupon_code);
        
        // Define your coupons (you can move this to database later)
        $coupons = [
            'SAVE10' => ['type' => 'percentage', 'value' => 10],
            'SAVE20' => ['type' => 'percentage', 'value' => 20],
            'FREESHIP' => ['type' => 'free_shipping', 'value' => 0],
            'FLAT50' => ['type' => 'fixed', 'value' => 50],
        ];

        if (isset($coupons[$couponCode])) {
            session()->put('coupon', [
                'code' => $couponCode,
                'type' => $coupons[$couponCode]['type'],
                'value' => $coupons[$couponCode]['value'],
            ]);
            
            return redirect()->back()->with('success', 'Coupon applied successfully!');
        }
        
        return redirect()->back()->with('error', 'Invalid coupon code!');
    }

    /**
     * Remove coupon
     */
    public function removeCoupon()
    {
        session()->forget('coupon');
        return redirect()->back()->with('success', 'Coupon removed!');
    }

    /**
     * Get cart count (for AJAX requests)
     */
    public function count()
    {
        $cart = session()->get('cart', []);
        $count = 0;
        
        foreach($cart as $item) {
            $count += $item['quantity'];
        }
        
        return response()->json(['count' => $count]);
    }
}