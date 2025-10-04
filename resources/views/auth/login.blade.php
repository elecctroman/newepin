<x-layouts.app title="Login">
    <h1 class="text-3xl font-bold mb-4">Login</h1>
    <form method="POST" action="{{ route('login') }}" class="bg-white rounded shadow p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-semibold">Email</label>
            <input type="email" name="email" class="border rounded w-full mt-1" required>
        </div>
        <div>
            <label class="block text-sm font-semibold">Password</label>
            <input type="password" name="password" class="border rounded w-full mt-1" required>
        </div>
        <div class="flex items-center justify-between">
            <label class="inline-flex items-center">
                <input type="checkbox" name="remember">
                <span class="ml-2">Remember me</span>
            </label>
            <a href="{{ route('password.request') }}" class="text-indigo-600">Forgot password?</a>
        </div>
        <button class="bg-indigo-600 text-white px-4 py-2 rounded">Login</button>
    </form>
</x-layouts.app>
