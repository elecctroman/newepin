<x-layouts.app title="Register">
    <h1 class="text-3xl font-bold mb-4">Create Account</h1>
    <form method="POST" action="{{ route('register') }}" class="bg-white rounded shadow p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-semibold">Name</label>
            <input type="text" name="name" class="border rounded w-full mt-1" required>
        </div>
        <div>
            <label class="block text-sm font-semibold">Email</label>
            <input type="email" name="email" class="border rounded w-full mt-1" required>
        </div>
        <div>
            <label class="block text-sm font-semibold">Password</label>
            <input type="password" name="password" class="border rounded w-full mt-1" required>
        </div>
        <div>
            <label class="block text-sm font-semibold">Confirm Password</label>
            <input type="password" name="password_confirmation" class="border rounded w-full mt-1" required>
        </div>
        <button class="bg-indigo-600 text-white px-4 py-2 rounded">Register</button>
    </form>
</x-layouts.app>
