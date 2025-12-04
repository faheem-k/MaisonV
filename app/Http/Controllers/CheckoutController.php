<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Show checkout page
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $coupon = session()->get('coupon');
        $discount = 0;
        
        if ($coupon) {
            if ($coupon['type'] === 'percentage') {
                $discount = ($subtotal * $coupon['value']) / 100;
            } elseif ($coupon['type'] === 'fixed') {
                $discount = $coupon['value'];
            }
        }

        $tax = ($subtotal - $discount) * 0.1; // 10% tax
        $shipping = ($subtotal - $discount) > 100 ? 0 : 10; // Free shipping over $100
        $total = $subtotal - $discount + $tax + $shipping;

        return view('checkout.index', compact('cart', 'subtotal', 'discount', 'tax', 'shipping', 'total', 'coupon'));
    }

    /**
     * Store new order
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'payment_method' => 'required|in:credit_card,debit_card,paypal,bank_transfer',
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $coupon = session()->get('coupon');
        $discount = 0;
        $coupon_code = null;
        
        if ($coupon) {
            if ($coupon['type'] === 'percentage') {
                $discount = ($subtotal * $coupon['value']) / 100;
            } elseif ($coupon['type'] === 'fixed') {
                $discount = $coupon['value'];
            }
            $coupon_code = $coupon['code'];
        }

        $tax = ($subtotal - $discount) * 0.1;
        $shipping = ($subtotal - $discount) > 100 ? 0 : 10;
        $total = $subtotal - $discount + $tax + $shipping;

        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'customer_address' => $validated['customer_address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'postal_code' => $validated['postal_code'],
            'country' => $validated['country'],
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'discount' => $discount,
            'total' => $total,
            'coupon_code' => $coupon_code,
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending',
            'order_status' => 'pending',
        ]);

        // Create order items
        foreach ($cart as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem['product_id'],
                'quantity' => $cartItem['quantity'],
                'price' => $cartItem['price'],
                'size' => $cartItem['size'] ?? null,
                'color' => $cartItem['color'] ?? null,
            ]);

            // Reduce product stock
            $product = Product::find($cartItem['product_id']);
            if ($product) {
                $product->decrement('stock', $cartItem['quantity']);
            }
        }

        // Process payment
        $paymentStatus = $this->processPayment($order, $validated['payment_method']);

        if ($paymentStatus) {
            $order->update([
                'payment_status' => 'paid',
                'order_status' => 'processing',
            ]);
        }

        // Clear cart and coupon
        session()->forget('cart');
        session()->forget('coupon');

        return redirect()->route('order.confirmation', $order->id)
            ->with('success', 'Order placed successfully!');
    }

    /**
     * Process payment (mock implementation)
     */
    private function processPayment(Order $order, $paymentMethod)
    {
        // This is a mock implementation
        // In production, you would integrate with payment gateways like Stripe, PayPal, etc.

        $payment = Payment::create([
            'order_id' => $order->id,
            'payment_method' => $paymentMethod,
            'amount' => $order->total,
            'currency' => 'USD',
            'transaction_id' => 'TXN-' . strtoupper(Str::random(15)),
            'status' => 'completed',
            'paid_at' => now(),
        ]);

        return true; // Payment successful
    }

    /**
     * Show order confirmation
     */
    public function confirmation($orderId)
    {
        $order = Order::with('items.product')->findOrFail($orderId);

        return view('checkout.confirmation', compact('order'));
    }
}
