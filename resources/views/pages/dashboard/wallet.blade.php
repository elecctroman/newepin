<x-layouts.app title="Wallet">
    <h1 class="text-3xl font-bold mb-4">Wallet Transactions</h1>
    <table class="min-w-full bg-white rounded shadow">
        <thead>
            <tr class="text-left border-b">
                <th class="px-4 py-2">Date</th>
                <th class="px-4 py-2">Type</th>
                <th class="px-4 py-2">Amount</th>
                <th class="px-4 py-2">Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $transaction->created_at->format('d M Y H:i') }}</td>
                    <td class="px-4 py-2 capitalize">{{ $transaction->type }}</td>
                    <td class="px-4 py-2">${{ number_format($transaction->amount, 2) }}</td>
                    <td class="px-4 py-2">{{ $transaction->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-6">
        {{ $transactions->links() }}
    </div>
</x-layouts.app>
