<!-- Newsletter Section -->
<section class="bg-gray-900 text-white py-16 mt-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Join Our Newsletter</h2>
        <p class="text-gray-400 mb-8">Get exclusive offers and updates delivered to your inbox</p>
        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="max-w-md mx-auto flex">
            @csrf
            <input type="email" 
                   name="email"
                   placeholder="Enter your email" 
                   required
                   class="flex-1 px-6 py-3 rounded-l-full focus:outline-none text-gray-900">
            <button type="submit" class="bg-black px-8 py-3 rounded-r-full font-semibold hover:bg-gray-800 transition">
                Subscribe
            </button>
        </form>
        @if(session('newsletter_success'))
            <p class="text-green-400 mt-4">{{ session('newsletter_success') }}</p>
        @endif
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
                    <li><a href="{{ route('products.new') }}" class="hover:text-white transition">New Arrivals</a></li>
                    <li><a href="{{ route('products.bestsellers') }}" class="hover:text-white transition">Best Sellers</a></li>
                    <li><a href="{{ route('products.sale') }}" class="hover:text-white transition">Sale</a></li>
                    <li><a href="{{ route('gift-cards') }}" class="hover:text-white transition">Gift Cards</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4">Customer Service</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition">Contact Us</a></li>
                    <li><a href="{{ route('shipping') }}" class="hover:text-white transition">Shipping Info</a></li>
                    <li><a href="{{ route('returns') }}" class="hover:text-white transition">Returns</a></li>
                    <li><a href="{{ route('size-guide') }}" class="hover:text-white transition">Size Guide</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4">Company</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('about') }}" class="hover:text-white transition">About Us</a></li>
                    <li><a href="{{ route('careers') }}" class="hover:text-white transition">Careers</a></li>
                    <li><a href="{{ route('privacy') }}" class="hover:text-white transition">Privacy Policy</a></li>
                    <li><a href="{{ route('terms') }}" class="hover:text-white transition">Terms of Service</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm">
            <p>&copy; {{ date('Y') }} MAISON V. All rights reserved.</p>
        </div>
    </div>
</footer>