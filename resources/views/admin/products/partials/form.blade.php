<div>
    <label class="block text-sm font-semibold">Title</label>
    <input type="text" name="title" value="{{ old('title', $product->title ?? '') }}" class="border rounded w-full mt-1">
</div>
<div>
    <label class="block text-sm font-semibold">SKU</label>
    <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}" class="border rounded w-full mt-1">
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-semibold">Type</label>
        <select name="type" class="border rounded w-full mt-1">
            @foreach(['epin', 'account', 'license'] as $type)
                <option value="{{ $type }}" @selected(old('type', $product->type ?? '') === $type)>{{ ucfirst($type) }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold">Supplier</label>
        <select name="supplier" class="border rounded w-full mt-1">
            @foreach(['turkpin', 'pinabi', 'manual'] as $supplier)
                <option value="{{ $supplier }}" @selected(old('supplier', $product->supplier ?? '') === $supplier)>{{ ucfirst($supplier) }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-semibold">Price</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}" class="border rounded w-full mt-1">
    </div>
    <div>
        <label class="block text-sm font-semibold">Stock</label>
        <input type="number" name="stock_count" value="{{ old('stock_count', $product->stock_count ?? '') }}" class="border rounded w-full mt-1">
    </div>
</div>
<div>
    <label class="block text-sm font-semibold">Category</label>
    <select name="category_id" class="border rounded w-full mt-1">
        @foreach($categories as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)>{{ $category->name }}</option>
        @endforeach
    </select>
</div>
<div>
    <label class="inline-flex items-center">
        <input type="checkbox" name="auto_deliver" value="1" @checked(old('auto_deliver', $product->auto_deliver ?? false))>
        <span class="ml-2">Auto deliver</span>
    </label>
</div>
<div>
    <label class="block text-sm font-semibold">API Product ID</label>
    <input type="text" name="api_product_id" value="{{ old('api_product_id', $product->api_product_id ?? '') }}" class="border rounded w-full mt-1">
</div>
