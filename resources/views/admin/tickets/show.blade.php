<x-layouts.app title="Ticket">
    <h1 class="text-2xl font-bold mb-4">{{ $ticket->subject }}</h1>
    <p class="text-sm text-gray-500 mb-4">Opened by {{ $ticket->user->name }}</p>
    <div class="bg-white rounded shadow p-4 mb-4">
        <p>{{ $ticket->message }}</p>
    </div>
    <section class="space-y-4">
        @foreach($ticket->replies as $reply)
            <div class="bg-white rounded shadow p-4">
                <p class="text-sm text-gray-500 mb-2">{{ $reply->user->name }} · {{ $reply->created_at->diffForHumans() }}</p>
                <p>{{ $reply->message }}</p>
            </div>
        @endforeach
    </section>
    <form method="POST" action="{{ route('admin.tickets.update', $ticket) }}" class="mt-6 space-y-4 bg-white rounded shadow p-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-semibold">Status</label>
            <select name="status" class="border rounded w-full mt-1">
                @foreach(['open','pending','closed'] as $status)
                    <option value="{{ $status }}" @selected($ticket->status === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-semibold">Reply</label>
            <textarea name="reply" class="border rounded w-full mt-1" rows="4"></textarea>
        </div>
        <button class="bg-indigo-600 text-white px-4 py-2 rounded">Update Ticket</button>
    </form>
</x-layouts.app>
