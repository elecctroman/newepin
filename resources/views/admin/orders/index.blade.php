<x-layouts.app title="Manage Orders">
    <h1 class="text-2xl font-bold mb-4">Orders</h1>
    <table class="min-w-full bg-white rounded shadow">
        <thead>
            <tr class="border-b text-left">
                <th class="px-4 py-2">Reference</th>
                <th class="px-4 py-2">Customer</th>
                <th class="px-4 py-2">Product</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $order->reference }}</td>
                    <td class="px-4 py-2">{{ $order->user->name }}</td>
                    <td class="px-4 py-2">{{ $order->product->title }}</td>
                    <td class="px-4 py-2">{{ ucfirst($order->status) }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</x-layouts.app>
