<x-layouts.app title="Welcome">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <section class="lg:col-span-2">
            <h2 class="text-2xl font-semibold mb-4">Featured Products</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($featuredProducts as $product)
                    <div class="bg-white shadow rounded p-4">
                        <h3 class="text-lg font-semibold">{{ $product->title }}</h3>
                        <p class="text-sm text-gray-500">{{ $product->category?->name }}</p>
                        <p class="text-xl font-bold mt-2">${{ number_format($product->price, 2) }}</p>
                        <a href="{{ route('products.show', $product) }}" class="mt-4 inline-block text-indigo-600">View details</a>
                    </div>
                @endforeach
            </div>
        </section>
        <aside>
            <h2 class="text-2xl font-semibold mb-4">Latest Articles</h2>
            <div class="space-y-4">
                @foreach($blogPosts as $post)
                    <a href="{{ route('blog.show', $post) }}" class="block bg-white shadow rounded p-4 hover:bg-indigo-50">
                        <h3 class="text-lg font-semibold">{{ $post->title }}</h3>
                        <p class="text-sm text-gray-500">{{ $post->excerpt }}</p>
                    </a>
                @endforeach
            </div>
        </aside>
    </div>
</x-layouts.app>
