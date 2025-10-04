<x-layouts.app title="Support Tickets">
    <h1 class="text-2xl font-bold mb-4">Support Tickets</h1>
    <table class="min-w-full bg-white rounded shadow">
        <thead>
            <tr class="border-b text-left">
                <th class="px-4 py-2">Subject</th>
                <th class="px-4 py-2">User</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $ticket->subject }}</td>
                    <td class="px-4 py-2">{{ $ticket->user->name }}</td>
                    <td class="px-4 py-2">{{ ucfirst($ticket->status) }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.tickets.show', $ticket) }}" class="text-indigo-600">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-6">
        {{ $tickets->links() }}
    </div>
</x-layouts.app>
