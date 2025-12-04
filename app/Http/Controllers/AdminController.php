<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total');
        $pendingOrders = Order::where('order_status', 'pending')->count();
        
        $products = Product::latest()->limit(5)->get();
        $orders = Order::with('items')->latest()->limit(5)->get();
        
        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders', 
            'totalRevenue',
            'pendingOrders',
            'products',
            'orders'
        ));
    }

    /**
     * Show products list
     */
    public function products(Request $request)
    {
        $query = Product::query();

        // Search products
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        $products = $query->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show create product form
     */
    public function createProduct()
    {
        return view('admin.products.create');
    }

    /**
     * Store new product
     */
    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'category' => 'required|string',
            'image' => 'nullable|url',
            'sku' => 'nullable|string|unique:products',
            'stock' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'is_new' => 'boolean',
            'is_sale' => 'boolean',
            'featured' => 'boolean',
        ]);

        Product::create($validated);
        
        return redirect()->route('admin.products')->with('success', 'Product created successfully!');
    }

    /**
     * Show edit product form
     */
    public function editProduct(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update product
     */
    public function updateProduct(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'category' => 'required|string',
            'image' => 'nullable|url',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'stock' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'is_new' => 'boolean',
            'is_sale' => 'boolean',
            'featured' => 'boolean',
        ]);

        $product->update($validated);
        
        return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
    }

    /**
     * Delete product
     */
    public function destroyProduct(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
    }

    /**
     * Show orders list
     */
    public function orders(Request $request)
    {
        $query = Order::with('items');

        // Search by order number, customer name, or email
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        // Filter by order status
        if ($status = $request->input('status')) {
            $query->where('order_status', $status);
        }

        // Filter by payment status
        if ($paymentStatus = $request->input('payment_status')) {
            $query->where('payment_status', $paymentStatus);
        }

        $orders = $query->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show order details
     */
    public function showOrder(Order $order)
    {
        $order->load('items.product', 'payment');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateOrderStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update($validated);
        
        return redirect()->back()->with('success', 'Order status updated!');
    }

    /**
     * Delete order
     */
    public function destroyOrder(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders')->with('success', 'Order deleted successfully!');
    }
}
