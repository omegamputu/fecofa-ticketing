<div>
    <div class="rounded-xl border border-neutral-200 dark:border-neutral-700">
        <h2 class="font-semibold mb-3 p-5">Tickets des Demandeurs</h2>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <div class="flex items-center gap-2 p-4">
            <div>
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="text" id="default-search" wire:model.live="search" class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search by name" required />
                </div>
            </div>

            <div>
                <select wire:model="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="all">Assignés (tous)</option>
                    <option value="open">Ouverts</option>
                    <option value="in_progress">En cours</option>
                    <option value="resolved">Résolus</option>
                </select>
            </div>
        </div>

        <table class="w-full text-sm text-left rtl:text-right">
            <thead class="text-xs text-gray-700 dark:text-gray-400 uppercase">
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
                        Créé le
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Résolu le
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $item)
                <tr wire:key="tech-ticket-{{ $item->id }}" class=" text-gray-700 dark:text-gray-400">
                    <th scope="row" class="px-6 py-4 text-xs text-gray-900 whitespace-nowrap dark:text-white">
                        <a href="{{ route('tech.tickets.show', $item) }}" class="hover:underline">{{ $item->subject }}</a>
                    </th>
                    <td class="px-6 py-4 text-xs">
                        {{ $item->requester->name }}
                    </td>
                    <td class="px-6 py-4 text-xs">
                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium bg-blue-700 text-white @if ($item->status === 'resolved') bg-green-500 @endif @if ($item->status === 'closed') bg-red-600 @endif">
                            {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-xs">
                        {{ $item->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 text-xs">
                        {{ $item->status === 'closed' ? $item->resolved_at->format('d/m/Y H:i') : '-' }}
                    </td>
                    <td class="px-6 py-4">
                        <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline" href="{{ route('tech.tickets.show', $item) }}" wire:navigate>Show</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $tickets->links() }}</div>
</div>
