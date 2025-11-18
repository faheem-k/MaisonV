<!-- Category Navigation -->
<section class="container mx-auto px-4 py-12">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('products.category', 'tops') }}" class="category-badge bg-white rounded-lg shadow-md p-6 text-center cursor-pointer">
            <i class="fas fa-tshirt text-4xl text-black mb-3"></i>
            <h3 class="font-semibold text-gray-800">Tops</h3>
        </a>
        <a href="{{ route('products.category', 'dresses') }}" class="category-badge bg-white rounded-lg shadow-md p-6 text-center cursor-pointer">
            <i class="fas fa-vest text-4xl text-black mb-3"></i>
            <h3 class="font-semibold text-gray-800">Dresses</h3>
        </a>
        <a href="{{ route('products.category', 'footwear') }}" class="category-badge bg-white rounded-lg shadow-md p-6 text-center cursor-pointer">
            <i class="fas fa-shoe-prints text-4xl text-black mb-3"></i>
            <h3 class="font-semibold text-gray-800">Footwear</h3>
        </a>
        <a href="{{ route('products.category', 'accessories') }}" class="category-badge bg-white rounded-lg shadow-md p-6 text-center cursor-pointer">
            <i class="fas fa-gem text-4xl text-black mb-3"></i>
            <h3 class="font-semibold text-gray-800">Accessories</h3>
        </a>
    </div>
</section>