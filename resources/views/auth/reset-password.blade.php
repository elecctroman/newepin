<x-layouts.app title="Reset Password">
    <h1 class="text-3xl font-bold mb-4">Reset Password</h1>
    <form method="POST" action="{{ route('password.store') }}" class="bg-white rounded shadow p-6 space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div>
            <label class="block text-sm font-semibold">Email</label>
            <input type="email" name="email" value="{{ old('email', $request->email) }}" class="border rounded w-full mt-1" required>
        </div>
        <div>
            <label class="block text-sm font-semibold">Password</label>
            <input type="password" name="password" class="border rounded w-full mt-1" required>
        </div>
        <div>
            <label class="block text-sm font-semibold">Confirm Password</label>
            <input type="password" name="password_confirmation" class="border rounded w-full mt-1" required>
        </div>
        <button class="bg-indigo-600 text-white px-4 py-2 rounded">Reset Password</button>
    </form>
</x-layouts.app>
