<x-layouts.app title="Checkout">
    <h1 class="text-3xl font-bold mb-4">Checkout</h1>
    <form method="POST" action="{{ route('checkout.process') }}" class="bg-white shadow rounded p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-semibold">Payment Method</label>
            <select name="payment_method" class="border rounded w-full mt-1">
                <option value="shopier">Shopier</option>
                <option value="iyzico">İyzico</option>
                <option value="paytr">PayTR</option>
                <option value="wallet">Wallet Balance</option>
            </select>
        </div>
        <button class="bg-indigo-600 text-white px-4 py-2 rounded">Confirm Payment</button>
    </form>
</x-layouts.app>
