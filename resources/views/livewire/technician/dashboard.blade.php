<div>
     <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl mb-4">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="rounded-xl p-4 border border-neutral-200 dark:border-neutral-700">
                <h3 class="mb-2"> {{ __("To be assigned") }} </h3>
                @foreach ($unassigned as $ticket)
                    <div class="flex items-start pb-2 mb-3 @if(!$loop->last) border-b border-neutral-200 dark:border-neutral-700 @endif">
                        <p class="text-sm mt-2 text-gray-500 dark:text-gray-400">#{{ $ticket->id }} - {{ $ticket->subject }} - {{ $ticket->priority }} - Assigné : - </p>
                    </div>
                @endforeach
            </div>
            <div class="rounded-xl p-4 border border-neutral-200 dark:border-neutral-700">
                <h3 class="mb-2"> {{ __("In progress") }} </h3>

                @foreach ($assigned as $ticket)
                <div class="flex items-start pb-2 mb-3 @if(!$loop->last) border-b border-neutral-200 dark:border-neutral-700 @endif">
                    <p class="text-sm text-gray-500 dark:text-gray-400">#{{ $ticket->id }} - {{ $ticket->subject }} - {{ $ticket->priority }} - <span class="rounded-md bg-blue-300/90 px-2 py-0.5 text-xs font-semibold text-blue-900">Assigné: </span> <span class="font-semibold text-white">{{ $ticket->assignee->name ? $ticket->assignee->name : "Non assigné" }}</span> </p>                    
                </div>
                @endforeach
            </div>
            <div class="rounded-xl p-4 border border-neutral-200 dark:border-neutral-700">
                <h3 class="mb-2"> {{ __("Resolved") }} </h3>

                @foreach ($resolved as $ticket)
                    <div class="flex items-start pb-2 mb-3 @if(!$loop->last) border-b border-neutral-200 dark:border-neutral-700 @endif">
                        <p class="text-sm mt-2 text-gray-500 dark:text-gray-400">#{{ $ticket->id }} - {{ $ticket->subject }} - <span class="font-semibold text-green-400">{{ $ticket->resolved_info }}</span> </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 pt-3">
        <table class="w-full text-sm text-left rtl:text-right">
            <thead class="text-xs text-gray-700 dark:text-gray-400 uppercase">
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
                        {{ __("Created At") }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __("Resolved At") }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __("Actions") }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($closed as $item)
                <tr wire:key="tech-ticket-{{ $item->id }}" class=" text-gray-700 dark:text-gray-400">
                    <th scope="row" class="px-6 py-4 text-xs text-gray-900 whitespace-nowrap dark:text-white">
                        <a href="{{ route('tech.tickets.show', $item) }}" class="hover:underline">{{ $item->subject }}</a>
                    </th>
                    <td class="px-6 py-4 text-xs">
                        {{ $item->requester->name }}
                    </td>
                    <td class="px-6 py-4 text-xs">
                        <span class="inline-flex items-center rounded-md @if ($item->status === 'open') bg-emerald-300/90 text-emerald-900 @endif @if ($item->status === 'in_progress') bg-yellow-300/90 text-yellow-900 @endif @if ($item->status === 'resolved') bg-green-500 @endif @if ($item->status === 'closed') bg-red-700 text-white @endif px-2 py-1 text-xs font-semibold">
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
                        <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline" href="{{ route('tech.tickets.show', $item) }}" wire:navigate>
                            {{ __("View") }}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
