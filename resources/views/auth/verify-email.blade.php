<x-layouts.app title="Verify Email">
    <h1 class="text-3xl font-bold mb-4">Verify Your Email</h1>
    <p class="mb-4">Thanks for signing up! Before getting started, please verify your email address by clicking the link we just emailed to you.</p>
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button class="bg-indigo-600 text-white px-4 py-2 rounded">Resend Verification Email</button>
    </form>
</x-layouts.app>
