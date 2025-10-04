<x-layouts.app title="Dashboard">
    <h1 class="text-3xl font-bold mb-4">Welcome, {{ $user->name }}</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-sm uppercase text-gray-500">Balance</h2>
            <p class="text-2xl font-semibold mt-2">${{ number_format($user->balance, 2) }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-sm uppercase text-gray-500">Orders</h2>
            <p class="text-2xl font-semibold mt-2">{{ $user->orders->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-sm uppercase text-gray-500">Role</h2>
            <p class="text-2xl font-semibold mt-2">{{ ucfirst($user->role) }}</p>
        </div>
    </div>
</x-layouts.app>
