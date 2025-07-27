<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-xl font-semibold mb-4">My Invitees</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date Invited</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Task Invited To</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Expiry</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($referrals as $ref)
                        <tr>
                            <td class="px-4 py-2">{{ $ref->email }}</td>
                            <td class="px-4 py-2">{{ $ref->created_at ? $ref->created_at->format('Y-m-d H:i') : '-' }}</td>
                            <td class="px-4 py-2">
                                @if($ref->task_id && $ref->task)
                                    {{ $ref->task->title }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $ref->expire_at ? \Carbon\Carbon::parse($ref->expire_at)->format('Y-m-d H:i') : '-' }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-block px-2 py-1 rounded text-xs font-semibold
                                    @if($ref->invitee_status === 'Completed') bg-green-100 text-green-800
                                    @elseif($ref->invitee_status === 'Pending Completion') bg-yellow-100 text-yellow-800
                                    @elseif($ref->invitee_status === 'Pending Registration') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $ref->invitee_status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">No invitees found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $referrals->links() }}
        </div>
    </div>
</div>
