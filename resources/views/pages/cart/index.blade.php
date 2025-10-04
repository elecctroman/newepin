<x-layouts.app title="Cart">
    <h1 class="text-3xl font-bold mb-4">Shopping Cart</h1>
    <div class="space-y-4">
        @forelse($cart as $item)
            <div class="bg-white shadow rounded p-4 flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-semibold">{{ $item['product']->title }}</h2>
                    <p class="text-sm text-gray-500">${{ number_format($item['product']->price, 2) }} × {{ $item['quantity'] }}</p>
                </div>
                <form method="POST" action="{{ route('cart.destroy', $item['product']->id) }}">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600">Remove</button>
                </form>
            </div>
        @empty
            <p class="text-gray-600">Your cart is empty.</p>
        @endforelse
    </div>
    @if($cart)
        <div class="mt-6 text-right">
            <a href="{{ route('checkout.index') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">Proceed to checkout</a>
        </div>
    @endif
</x-layouts.app>
