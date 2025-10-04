<x-layouts.app title="Add Product">
    <h1 class="text-2xl font-bold mb-4">Add Product</h1>
    <form method="POST" action="{{ route('admin.products.store') }}" class="bg-white p-6 rounded shadow space-y-4">
        @csrf
        @include('admin.products.partials.form')
        <button class="bg-indigo-600 text-white px-4 py-2 rounded">Save</button>
    </form>
</x-layouts.app>
