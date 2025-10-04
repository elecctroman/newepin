<x-layouts.app title="Forgot Password">
    <h1 class="text-3xl font-bold mb-4">Forgot Password</h1>
    <form method="POST" action="{{ route('password.email') }}" class="bg-white rounded shadow p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-semibold">Email</label>
            <input type="email" name="email" class="border rounded w-full mt-1" required>
        </div>
        <button class="bg-indigo-600 text-white px-4 py-2 rounded">Send Reset Link</button>
    </form>
</x-layouts.app>
