<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class CartController extends Controller
{
    private const RECOMMENDED_PRODUCTS_LIMIT = 4;
    private const MAX_QUANTITY_PER_ITEM = 99;
    
    private const COUPONS = [
        'SAVE10' => ['type' => 'percentage', 'value' => 10],
        'SAVE20' => ['type' => 'percentage', 'value' => 20],
        'FREESHIP' => ['type' => 'free_shipping', 'value' => 0],
        'FLAT50' => ['type' => 'fixed', 'value' => 50],
    ];

    /**
     * Display the shopping cart.
     */
    public function index(): View
    {
        $cart = $this->getCart();
        $recommendedProducts = $this->getRecommendedProducts();
        
        return view('cart.index', compact('cart', 'recommendedProducts'));
    }

    /**
     * Add product to cart.
     */
    public function add(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1|max:' . self::MAX_QUANTITY_PER_ITEM,
            'size' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
        ]);

        try {
            $product = Product::findOrFail($validated['product_id']);
            
            if (!$product->is_active) {
                return $this->redirectWithError('This product is currently unavailable.');
            }

            if (isset($product->stock) && $product->stock < ($validated['quantity'] ?? 1)) {
                return $this->redirectWithError('Insufficient stock available.');
            }

            $this->addItemToCart(
                $product,
                $validated['quantity'] ?? 1,
                $validated['size'] ?? null,
                $validated['color'] ?? null
            );
            
            return $this->redirectWithSuccess('Product added to cart successfully!');
            
        } catch (\Exception $e) {
            Log::error('Error adding product to cart', [
                'product_id' => $validated['product_id'],
                'error' => $e->getMessage()
            ]);
            
            return $this->redirectWithError('Failed to add product to cart. Please try again.');
        }
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:' . self::MAX_QUANTITY_PER_ITEM,
        ]);

        try {
            $cart = $this->getCart();
            
            if (!isset($cart[$id])) {
                return $this->redirectWithError('Item not found in cart!');
            }
            
            $cart[$id]['quantity'] = $validated['quantity'];
            $this->saveCart($cart);
            
            return $this->redirectWithSuccess('Cart updated successfully!');
            
        } catch (\Exception $e) {
            Log::error('Error updating cart', [
                'cart_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return $this->redirectWithError('Failed to update cart. Please try again.');
        }
    }

    /**
     * Remove item from cart.
     */
    public function remove(string $id): RedirectResponse
    {
        try {
            $cart = $this->getCart();
            
            if (!isset($cart[$id])) {
                return $this->redirectWithError('Item not found in cart!');
            }
            
            unset($cart[$id]);
            $this->saveCart($cart);
            
            return $this->redirectWithSuccess('Product removed from cart!');
            
        } catch (\Exception $e) {
            Log::error('Error removing cart item', [
                'cart_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return $this->redirectWithError('Failed to remove item. Please try again.');
        }
    }

    /**
     * Clear entire cart.
     */
    public function clear(): RedirectResponse
    {
        try {
            Session::forget('cart');
            Session::forget('coupon');
            
            return $this->redirectWithSuccess('Cart cleared successfully!');
            
        } catch (\Exception $e) {
            Log::error('Error clearing cart', ['error' => $e->getMessage()]);
            return $this->redirectWithError('Failed to clear cart. Please try again.');
        }
    }

    /**
     * Apply coupon code.
     */
    public function applyCoupon(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'coupon_code' => 'required|string|max:50',
        ]);

        try {
            $couponCode = strtoupper(trim($validated['coupon_code']));
            
            if (!isset(self::COUPONS[$couponCode])) {
                return $this->redirectWithError('Invalid coupon code!');
            }
            
            $coupon = self::COUPONS[$couponCode];
            
            Session::put('coupon', [
                'code' => $couponCode,
                'type' => $coupon['type'],
                'value' => $coupon['value'],
            ]);
            
            return $this->redirectWithSuccess('Coupon applied successfully!');
            
        } catch (\Exception $e) {
            Log::error('Error applying coupon', [
                'coupon_code' => $validated['coupon_code'],
                'error' => $e->getMessage()
            ]);
            
            return $this->redirectWithError('Failed to apply coupon. Please try again.');
        }
    }

    /**
     * Remove coupon.
     */
    public function removeCoupon(): RedirectResponse
    {
        try {
            Session::forget('coupon');
            return $this->redirectWithSuccess('Coupon removed!');
            
        } catch (\Exception $e) {
            Log::error('Error removing coupon', ['error' => $e->getMessage()]);
            return $this->redirectWithError('Failed to remove coupon. Please try again.');
        }
    }

    /**
     * Get cart count (for AJAX requests).
     */
    public function count(): JsonResponse
    {
        try {
            $cart = $this->getCart();
            $count = array_sum(array_column($cart, 'quantity'));
            
            return response()->json(['count' => $count]);
            
        } catch (\Exception $e) {
            Log::error('Error getting cart count', ['error' => $e->getMessage()]);
            return response()->json(['count' => 0], 500);
        }
    }

    /**
     * Get cart from session.
     */
    private function getCart(): array
    {
        return Session::get('cart', []);
    }

    /**
     * Save cart to session.
     */
    private function saveCart(array $cart): void
    {
        Session::put('cart', $cart);
    }

    /**
     * Generate unique cart ID for an item.
     */
    private function generateCartId(int $productId, ?string $size = null, ?string $color = null): string
    {
        $cartId = (string) $productId;
        
        if ($size) {
            $cartId .= '-' . $size;
        }
        
        if ($color) {
            $cartId .= '-' . $color;
        }
        
        return $cartId;
    }

    /**
     * Add item to cart.
     */
    private function addItemToCart(Product $product, int $quantity, ?string $size, ?string $color): void
    {
        $cart = $this->getCart();
        $cartId = $this->generateCartId($product->id, $size, $color);
        
        if (isset($cart[$cartId])) {
            $cart[$cartId]['quantity'] += $quantity;
        } else {
            $cart[$cartId] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->price,
                'image' => $product->image,
                'size' => $size,
                'color' => $color,
            ];
        }
        
        $this->saveCart($cart);
    }

    /**
     * Get recommended products.
     */
    private function getRecommendedProducts()
    {
        return Product::query()
            ->where('is_active', true)
            ->where('featured', true)
            ->inRandomOrder()
            ->limit(self::RECOMMENDED_PRODUCTS_LIMIT)
            ->get();
    }

    /**
     * Redirect back with success message.
     */
    private function redirectWithSuccess(string $message): RedirectResponse
    {
        return redirect()->back()->with('success', $message);
    }

    /**
     * Redirect back with error message.
     */
    private function redirectWithError(string $message): RedirectResponse
    {
        return redirect()->back()->with('error', $message);
    }
}