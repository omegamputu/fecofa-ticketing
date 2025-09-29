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
                    <td class="px-6 py-4">
                        {{ $item->subject }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->requester->name }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center rounded-md bg-green-400/10 px-2 py-1 text-xs font-medium @if ($item->status === 'resolved') bg-indigo-500 text-white @endif text-green-400 inset-ring inset-ring-green-500/20">
                            {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-xs">
                        {{ $item->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4">
                        @if(in_array($item->status, ['open', 'in_progress']))
                        <div class="flex flex-col gap-2 mb-2">
                            <p class="text-xs text-zinc-500 mb-2">Note de résolution (optionnel)</p>
                            <textarea wire:model.defer="resolutionNotes.{{ $item->id }}" class="border border-neutral-200 dark:border-neutral-700 rounded px-2 py-1" rows="2" placeholder="Ce qui a été fait…"></textarea>

                            @error('resolutionNotes.'.$item->id)
                                <div class="text-red-600 text-xs">{{ $message }}</div>
                            @enderror
                        </div>
                        @if($item->status === 'open')
                        <button type="button" class="border rounded px-3 py-1" wire:click="start({{ $item->id }})">
                            Passer en cours
                        </button>
                        @endif

                        <button type="button" class="flex items-start text-white text-xs bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded px-2 py-1.5 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" wire:click="resolve({{ $item->id }})">
                            Marquer “Résolu”
                        </button>
                        @else
                            <div class="text-xs">
                            Résolu le {{ $item->resolved_at?->format('d/m/Y H:i') }}
                            @if($item->resolution_note)
                                — <span class="italic">{{ $item->resolution_note }}</span>
                            @endif
                            </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $tickets->links() }}</div>
</div>
