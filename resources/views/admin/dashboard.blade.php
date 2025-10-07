<x-layouts.app :title="__('Dashboard Admin')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700">
                <div class="p-5  text-gray-700 dark:text-gray-400">
                    <h2 class="font-semibold mb-3"> {{ __("Requester Tickets") }} </h2>
                    <div class="text-3xl font-bold">{{ $stats['tickets_total'] }}</div>
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700">
                <div class="p-5  text-gray-700 dark:text-gray-400">
                    <h2 class="font-semibold mb-3"> {{ __("Open / In Progress") }} </h2>
                    <div class="text-3xl font-bold">{{ $stats['tickets_open'] }}</div>
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700">
                <div class="p-5  text-gray-700 dark:text-gray-400">
                    <h2 class="font-semibold mb-3"> {{ __("Unassigned") }} </h2>
                    <div class="text-3xl font-bold">{{ $stats['tickets_non_assignés'] }}</div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold mb-3 p-5 text-gray-700 dark:text-gray-400"> {{ __("Requester Tickets - To Be Processed") }} </h2>
                <a href="{{ route('admin.tickets.index') }}" wire:navigate class="text-sm text-blue-600 hover:underline mr-5">
                    {{ __("View All") }}
                </a>
            </div>

            <table class="text-sm text-left rtl:text-right">
                <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            {{ __("Subject") }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __("Requester") }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __("Status") }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __("Assignee") }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __("Created At") }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __("Resolved At") }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lastTickets as $ticket)
                    <tr class=" text-gray-700 dark:text-gray-400">
                        <td class="px-6 py-4 text-xs">
                            {{ $ticket->subject }}
                        </td>
                        <td class="px-6 py-4 text-xs">
                            {{ $ticket->requester->name }}
                        </td>
                        <td class="px-6 py-4 text-xs">
                            <span class="inline-flex items-center rounded-md @if ($ticket->status === 'open') bg-emerald-300/90 text-emerald-900 @endif @if ($ticket->status === 'in_progress') bg-yellow-300/90 text-yellow-900 @endif @if ($ticket->status === 'resolved') bg-green-500 @endif @if ($ticket->status === 'closed') bg-red-700 text-white @endif px-2 py-1 text-xs font-semibold">
                                {{ __(ucfirst(str_replace('_', ' ', $ticket->status))) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs">
                            {{ $ticket->assignee->name ?? '_' }}
                        </td>
                        <td class="px-6 py-4 text-xs">
                            {{ $ticket->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 text-xs">
                            {{ $ticket->status === 'closed' ? $ticket->resolved_at->format('d/m/Y H:i') : '-' }}
                        </td>
                    </tr>
                    @empty
                        <tr class="border-b border-neutral-200 dark:border-neutral-700"><td class="p-3 text-zinc-500" colspan="6">Aucun ticket pour le moment.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>