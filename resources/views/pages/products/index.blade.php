<x-layouts.app title="Products">
    <div class="flex flex-col lg:flex-row gap-6">
        <aside class="lg:w-1/4 bg-white p-4 rounded shadow">
            <h3 class="font-semibold mb-2">Categories</h3>
            <ul class="space-y-2">
                @foreach($categories as $category)
                    <li><a href="?category={{ $category->slug }}" class="text-indigo-600">{{ $category->name }}</a></li>
                @endforeach
            </ul>
        </aside>
        <section class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($products as $product)
                <div class="bg-white shadow rounded p-4">
                    <h3 class="text-lg font-semibold">{{ $product->title }}</h3>
                    <p class="text-sm text-gray-500">{{ $product->category?->name }}</p>
                    <p class="text-xl font-bold mt-2">${{ number_format($product->price, 2) }}</p>
                    <form method="POST" action="{{ route('cart.store') }}" class="mt-4 space-y-2">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="number" name="quantity" value="1" min="1" class="border rounded w-full">
                        <button class="w-full bg-indigo-600 text-white py-2 rounded">Add to cart</button>
                    </form>
                </div>
            @endforeach
        </section>
    </div>
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</x-layouts.app>
