<div>
     <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="rounded-xl p-4 border border-neutral-200 dark:border-neutral-700">
                <h3 class="mb-2">A affecter</h3>
                @foreach ($unassigned as $ticket)
                    <div class="flex items-start pb-2 mb-3 border-b border-neutral-200 dark:border-neutral-700">
                        <p class="text-sm mt-2 text-gray-500 dark:text-gray-400">#{{ $ticket->id }} - {{ $ticket->subject }} - {{ $ticket->priority }} - Assigné : - </p>
                    </div>
                @endforeach
            </div>
            <div class="rounded-xl p-4 border border-neutral-200 dark:border-neutral-700">
                <h3 class="mb-2">En cours</h3>

                @foreach ($assigned as $ticket)
                <div class="flex items-start pb-2 mb-3 border-b border-neutral-200 dark:border-neutral-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400">#{{ $ticket->id }} - {{ $ticket->subject }} - {{ $ticket->priority }} - Assigné : <span class="font-semibold text-white">{{ $ticket->assignee->name ? $ticket->assignee->name : "Non assigné" }}</span> </p>                    
                </div>
                @endforeach
            </div>
            <div class="rounded-xl p-4 border border-neutral-200 dark:border-neutral-700">
                <h3 class="mb-2">Résolus</h3>

                @foreach ($resolved as $ticket)
                    <div class="flex items-start pb-2 mb-3 border-b border-neutral-200 dark:border-neutral-700">
                        <p class="text-sm mt-2 text-gray-500 dark:text-gray-400">#{{ $ticket->id }} - {{ $ticket->subject }} - <span class="font-semibold text-green-400">{{ $ticket->resolved_info }}</span> </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
