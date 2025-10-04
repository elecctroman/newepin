<x-layouts.app title="Edit Product">
    <h1 class="text-2xl font-bold mb-4">Edit Product</h1>
    <form method="POST" action="{{ route('admin.products.update', $product) }}" class="bg-white p-6 rounded shadow space-y-4">
        @csrf
        @method('PUT')
        @include('admin.products.partials.form')
        <button class="bg-indigo-600 text-white px-4 py-2 rounded">Update</button>
    </form>
</x-layouts.app>
