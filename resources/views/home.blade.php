<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maison V - Premium Clothing Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .logo {
            font-family: 'Playfair Display', serif;
            letter-spacing: 2px;
        }
        
        .product-card {
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .product-card img {
            transition: transform 0.5s ease;
        }
        
        .product-card:hover img {
            transform: scale(1.08);
        }
        
        .hero-section {
            background: linear-gradient(135deg, #1a1a1a 0%, #000000 100%);
            min-height: 500px;
        }
        
        .category-badge {
            transition: all 0.3s ease;
        }
        
        .category-badge:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }
        
        .search-bar {
            transition: all 0.3s ease;
        }
        
        .search-bar:focus-within {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #000000;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Top Banner -->
    <div class="bg-black text-white text-center py-2 text-sm">
        <p>Free Shipping on Orders Over $100 | Use Code: FREESHIP</p>
    </div>

    <!-- Navigation -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <h1 class="text-3xl font-bold logo">MAISON V</h1>
                
                <!-- Main Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="#" class="nav-link text-gray-700 hover:text-black font-medium">New Arrivals</a>
                    <a href="#" class="nav-link text-gray-700 hover:text-black font-medium">Women</a>
                    <a href="#" class="nav-link text-gray-700 hover:text-black font-medium">Men</a>
                    <a href="#" class="nav-link text-gray-700 hover:text-black font-medium">Collections</a>
                    <a href="#" class="nav-link text-gray-700 hover:text-black font-medium">Sale</a>
                </nav>
                
                <!-- Icons -->
                <div class="flex items-center space-x-6">
                    <button class="text-gray-700 hover:text-black transition">
                        <i class="fas fa-search text-lg"></i>
                    </button>
                    <button class="text-gray-700 hover:text-black transition">
                        <i class="fas fa-user text-lg"></i>
                    </button>
                    <a href="/cart" class="text-gray-700 hover:text-black transition relative">
                        <i class="fas fa-shopping-bag text-lg"></i>
                        <span class="absolute -top-2 -right-2 bg-black text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section flex items-center justify-center text-white">
        <div class="text-center px-4">
            <h2 class="text-5xl md:text-6xl font-bold mb-4">Spring Collection 2024</h2>
            <p class="text-xl mb-8 font-light">Discover timeless elegance and modern sophistication</p>
            <button class="bg-white text-black px-8 py-3 rounded-full font-semibold hover:bg-gray-200 transition transform hover:scale-105">
                Shop Now
            </button>
        </div>
    </section>

    <!-- Category Navigation -->
    <section class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="category-badge bg-white rounded-lg shadow-md p-6 text-center cursor-pointer">
                <i class="fas fa-tshirt text-4xl text-black mb-3"></i>
                <h3 class="font-semibold text-gray-800">Tops</h3>
            </div>
            <div class="category-badge bg-white rounded-lg shadow-md p-6 text-center cursor-pointer">
                <i class="fas fa-vest text-4xl text-black mb-3"></i>
                <h3 class="font-semibold text-gray-800">Dresses</h3>
            </div>
            <div class="category-badge bg-white rounded-lg shadow-md p-6 text-center cursor-pointer">
                <i class="fas fa-shoe-prints text-4xl text-black mb-3"></i>
                <h3 class="font-semibold text-gray-800">Footwear</h3>
            </div>
            <div class="category-badge bg-white rounded-lg shadow-md p-6 text-center cursor-pointer">
                <i class="fas fa-gem text-4xl text-black mb-3"></i>
                <h3 class="font-semibold text-gray-800">Accessories</h3>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <main class="container mx-auto px-4 py-12">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Latest Arrivals</h2>
            <div class="flex space-x-4">
                <select class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black">
                    <option>Sort by: Featured</option>
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                    <option>Newest</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($products as $product)
                <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="relative overflow-hidden">
                        <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=400' }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-80 object-cover">
                        <div class="absolute top-4 right-4">
                            <button class="bg-white rounded-full p-2 shadow-md hover:bg-gray-100 transition">
                                <i class="far fa-heart text-gray-700"></i>
                            </button>
                        </div>
                        @if(isset($product->is_new) && $product->is_new)
                        <span class="absolute top-4 left-4 bg-black text-white text-xs px-3 py-1 rounded-full font-semibold">NEW</span>
                        @endif
                    </div>
                    <div class="p-5">
                        <div class="text-xs text-gray-500 mb-2 uppercase tracking-wide">
                            {{ $product->category ?? 'Fashion' }}
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2 text-lg">{{ $product->name }}</h3>
                        <div class="flex items-center mb-3">
                            <div class="flex text-yellow-400 text-sm">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="text-gray-500 text-sm ml-2">(4.5)</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-2xl font-bold text-gray-900">${{ $product->price }}</span>
                                @if(isset($product->original_price))
                                <span class="text-sm text-gray-400 line-through ml-2">${{ $product->original_price }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mt-4 flex space-x-2">
                            <a href="/products/{{ $product->id }}" 
                               class="flex-1 bg-black text-white text-center py-2 rounded-lg font-semibold hover:bg-gray-800 transition">
                                View Details
                            </a>
                            <button class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Load More -->
        <div class="text-center mt-12">
            <button class="border-2 border-black text-black px-8 py-3 rounded-full font-semibold hover:bg-black hover:text-white transition">
                Load More Products
            </button>
        </div>
    </main>

    <!-- Newsletter Section -->
    <section class="bg-gray-900 text-white py-16 mt-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Join Our Newsletter</h2>
            <p class="text-gray-400 mb-8">Get exclusive offers and updates delivered to your inbox</p>
            <div class="max-w-md mx-auto flex">
                <input type="email" 
                       placeholder="Enter your email" 
                       class="flex-1 px-6 py-3 rounded-l-full focus:outline-none text-gray-900">
                <button class="bg-black px-8 py-3 rounded-r-full font-semibold hover:bg-gray-800 transition">
                    Subscribe
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="logo text-white text-2xl font-bold mb-4">MAISON V</h3>
                    <p class="text-sm">Premium fashion for the modern individual. Quality, style, and elegance in every piece.</p>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="hover:text-white transition"><i class="fab fa-facebook text-xl"></i></a>
                        <a href="#" class="hover:text-white transition"><i class="fab fa-instagram text-xl"></i></a>
                        <a href="#" class="hover:text-white transition"><i class="fab fa-twitter text-xl"></i></a>
                        <a href="#" class="hover:text-white transition"><i class="fab fa-pinterest text-xl"></i></a>
                    </div>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Shop</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">New Arrivals</a></li>
                        <li><a href="#" class="hover:text-white transition">Best Sellers</a></li>
                        <li><a href="#" class="hover:text-white transition">Sale</a></li>
                        <li><a href="#" class="hover:text-white transition">Gift Cards</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Customer Service</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Contact Us</a></li>
                        <li><a href="#" class="hover:text-white transition">Shipping Info</a></li>
                        <li><a href="#" class="hover:text-white transition">Returns</a></li>
                        <li><a href="#" class="hover:text-white transition">Size Guide</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition">Careers</a></li>
                        <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm">
                <p>&copy; 2024 MAISON V. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>