<main class="container mx-auto px-4 py-12">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">My Transactions</h1>
        <div class="bg-white rounded-lg shadow-lg p-8">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($transactions as $transaction)
                    <tr>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $transaction['date'] }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $transaction['type'] }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $transaction['description'] }}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-right font-semibold">{{ $transaction['currency'] }} {{ number_format($transaction['amount'], 2) }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <span class="inline-block px-2 py-1 rounded-full text-xs {{ $transaction['status'] === 'Completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $transaction['status'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main> 