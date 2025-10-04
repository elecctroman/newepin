<x-layouts.app title="Manage Products">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Products</h1>
        <a href="{{ route('admin.products.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">Add Product</a>
    </div>
    <table class="min-w-full bg-white rounded shadow">
        <thead>
            <tr class="border-b text-left">
                <th class="px-4 py-2">Title</th>
                <th class="px-4 py-2">Type</th>
                <th class="px-4 py-2">Price</th>
                <th class="px-4 py-2">Supplier</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $product->title }}</td>
                    <td class="px-4 py-2">{{ ucfirst($product->type) }}</td>
                    <td class="px-4 py-2">${{ number_format($product->price, 2) }}</td>
                    <td class="px-4 py-2">{{ ucfirst($product->supplier) }}</td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600">Edit</a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</x-layouts.app>
