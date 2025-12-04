<!-- Top Banner -->
<div class="bg-black text-white text-center py-2 text-sm">
    <p>Free Shipping on Orders Over $100 | Use Code: FREESHIP</p>
</div>

<!-- Navigation -->
<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="text-3xl font-bold logo">MAISON V</a>
            
            <!-- Main Navigation -->
            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('products.new') }}" class="nav-link text-gray-700 hover:text-black font-medium">New Arrivals</a>
                <a href="{{ route('products.category', 'women') }}" class="nav-link text-gray-700 hover:text-black font-medium">Women</a>
                <a href="{{ route('products.category', 'men') }}" class="nav-link text-gray-700 hover:text-black font-medium">Men</a>
                <a href="{{ route('collections') }}" class="nav-link text-gray-700 hover:text-black font-medium">Collections</a>
                <a href="{{ route('products.sale') }}" class="nav-link text-gray-700 hover:text-black font-medium">Sale</a>
            </nav>
            
            <!-- Icons -->
            <div class="flex items-center space-x-6">
                <button class="text-gray-700 hover:text-black transition" onclick="toggleSearch()">
                    <i class="fas fa-search text-lg"></i>
                </button>
                @auth
                    @if(Route::has('profile'))
                        <a href="{{ route('profile') }}" class="text-gray-700 hover:text-black transition">
                            <i class="fas fa-user text-lg"></i>
                        </a>
                    @else
                        <a href="{{ url('/account') }}" class="text-gray-700 hover:text-black transition">
                            <i class="fas fa-user text-lg"></i>
                        </a>
                    @endif
                @else
                    @if(Route::has('login'))
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-black transition">
                            <i class="fas fa-user text-lg"></i>
                        </a>
                    @else
                        <a href="{{ url('/login') }}" class="text-gray-700 hover:text-black transition">
                            <i class="fas fa-user text-lg"></i>
                        </a>
                    @endif
                @endauth
                <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-black transition relative">
                    <i class="fas fa-shopping-bag text-lg"></i>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute -top-2 -right-2 bg-black text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </div>
</header>