<x-layouts.app :title="__('Dashboard Admin')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700">
                <div class="p-5  text-gray-700 dark:text-gray-400">
                    <h2 class="font-semibold mb-3">Tickets (Demandeurs)</h2>
                    <div class="text-3xl font-bold">{{ $stats['tickets_total'] }}</div>
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700">
                <div class="p-5  text-gray-700 dark:text-gray-400">
                    <h2 class="font-semibold mb-3">Ouverts / En cours</h2>
                    <div class="text-3xl font-bold">{{ $stats['tickets_open'] }}</div>
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700">
                <div class="p-5  text-gray-700 dark:text-gray-400">
                    <h2 class="font-semibold mb-3">Non assignés</h2>
                    <div class="text-3xl font-bold">{{ $stats['tickets_non_assignés'] }}</div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold mb-3 p-5 text-gray-700 dark:text-gray-400">Tickets des Demandeurs - à traiter</h2>
                <a href="{{ route('admin.tickets.index') }}" wire:navigate class="text-sm text-blue-600 hover:underline mr-5">Voir tout</a>
            </div>

            <table class="text-sm text-left rtl:text-right">
                <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Sujet
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Demandeur
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Statut
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Technicien
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Crée le
                        </th>
                        <th scope="col" class="px-6 py-3">
                            
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lastTickets as $ticket)
                    <tr class=" text-gray-700 dark:text-gray-400">
                        <td class="px-6 py-4">
                            {{ $ticket->subject }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $ticket->requester->name }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-md bg-green-400/10 px-2 py-1 text-xs font-medium @if ($ticket->status === 'resolved') bg-indigo-500 text-white @endif text-green-400 inset-ring inset-ring-green-500/20">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-md bg-blue-400/10 px-2 py-1 text-xs font-medium text-blue-400 inset-ring inset-ring-blue-500/20">
                                {{ $ticket->assignee->name ?? '_' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            {{ $ticket->created_at->format('d/m/Y H:i') }}
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