<x-layouts.app title="Confirm Password">
    <h1 class="text-3xl font-bold mb-4">Confirm Password</h1>
    <form method="POST" action="{{ route('password.confirm') }}" class="bg-white rounded shadow p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-semibold">Password</label>
            <input type="password" name="password" class="border rounded w-full mt-1" required>
        </div>
        <button class="bg-indigo-600 text-white px-4 py-2 rounded">Confirm</button>
    </form>
</x-layouts.app>
