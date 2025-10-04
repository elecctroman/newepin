<x-layouts.app :title="$product->title">
    <div class="bg-white shadow rounded p-6">
        <h1 class="text-3xl font-bold mb-2">{{ $product->title }}</h1>
        <p class="text-gray-500 mb-4">SKU: {{ $product->sku }} · {{ ucfirst($product->type) }}</p>
        <p class="text-2xl font-semibold">${{ number_format($product->price, 2) }}</p>
        <form method="POST" action="{{ route('cart.store') }}" class="mt-4 space-y-2">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <label class="block">
                <span class="text-sm text-gray-600">Quantity</span>
                <input type="number" name="quantity" value="1" min="1" class="border rounded w-full">
            </label>
            <button class="w-full bg-indigo-600 text-white py-2 rounded">Add to cart</button>
        </form>
    </div>
    <section class="mt-8">
        <h2 class="text-2xl font-semibold mb-4">Reviews</h2>
        <div class="space-y-4">
            @forelse($product->reviews as $review)
                <article class="bg-white rounded shadow p-4">
                    <h3 class="font-semibold">{{ $review->title }}</h3>
                    <p class="text-sm text-gray-500">Rating: {{ $review->rating }}/5</p>
                    <p class="mt-2">{{ $review->body }}</p>
                </article>
            @empty
                <p class="text-gray-600">No reviews yet.</p>
            @endforelse
        </div>
    </section>
</x-layouts.app>
