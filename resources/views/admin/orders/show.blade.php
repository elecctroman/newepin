<x-layouts.app title="Order Details">
    <h1 class="text-2xl font-bold mb-4">Order {{ $order->reference }}</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white rounded shadow p-4">
            <h2 class="font-semibold mb-2">Customer</h2>
            <p>{{ $order->user->name }} ({{ $order->user->email }})</p>
        </div>
        <div class="bg-white rounded shadow p-4">
            <h2 class="font-semibold mb-2">Product</h2>
            <p>{{ $order->product->title }} · {{ ucfirst($order->product->type) }}</p>
        </div>
    </div>
    <section class="mt-6">
        <h2 class="font-semibold mb-2">Status</h2>
        <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="flex items-center space-x-2">
            @csrf
            @method('PUT')
            <select name="status" class="border rounded">
                @foreach(['pending','processing','paid','failed','delivered'] as $status)
                    <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            <button class="bg-indigo-600 text-white px-4 py-2 rounded">Update</button>
        </form>
    </section>
    <section class="mt-6">
        <h2 class="font-semibold mb-2">E-Pins</h2>
        <ul class="list-disc list-inside">
            @forelse($order->epins as $pin)
                <li>{{ $pin->code }} · {{ $pin->supplier_name }}</li>
            @empty
                <li>No delivery data yet.</li>
            @endforelse
        </ul>
    </section>
</x-layouts.app>
