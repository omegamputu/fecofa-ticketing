<div>
    <div class="grid grid-flow-row auto-rows-max gap-4 md:grid-cols-2">
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-5">
            <div class="text-xs text-zinc-500">
            #{{ $ticket->id }} • {{ $ticket->created_at->format('d/m/Y H:i') }}
            </div>

            <h1 class="text-xl font-semibold mt-2 text-sky-500">{{ $ticket->subject }}</h1>

            <div class="flex flex-row border-b dark:border-neutral-700 gap-2 md:gap-4 mt-3 text-sm text-zinc-600">
                <p class="text-xs text-zinc-500 block">
                    <span> {{ __("Category") }} :</span> <span class="inline-flex items-center rounded-md bg-green-400/10 px-2 py-1 text-xs font-medium text-green-400 inset-ring inset-ring-green-500/20">{{ $ticket->category->name }}</span> 
                </p>
                <p class="text-xs text-zinc-500">
                    {{ __("Priority") }}: <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium bg-blue-400/10 text-blue-400 inset-ring inset-ring-blue-500/20">{{ ucfirst($ticket->priority) }}</span> 
                </p>
                <p class="text-xs text-zinc-500 mb-4">
                    {{ __("Status") }}: <span class="inline-flex items-center rounded-md @if ($ticket->status === 'open') bg-emerald-300/90 text-emerald-900 @endif @if ($ticket->status === 'in_progress') bg-yellow-300/90 text-yellow-900 @endif @if ($ticket->status === 'resolved') bg-green-500 text-white @endif @if ($ticket->status === 'closed') bg-red-700 text-white @endif px-2 py-1 text-xs font-semibold">{{ str_replace('_',' ',ucfirst($ticket->status)) }}</span>
                </p>
            </div>

            <p class="mt-4 mb-4 text-red-500 whitespace-pre-line">{{ $ticket->description }}</p>

            @if($ticket->attachments->count())
            <div class="mt-4">
                <div class="text-sm font-semibold mb-1">
                    {{ __("Attachments") }}
                </div>
                <ul class="list-disc pl-5 text-sm">
                @foreach($ticket->attachments as $a)
                    <li>
                    <a class="underline" href="{{ asset('storage/'.$a->path) }}" target="_blank">{{ $a->original_name }}</a>
                    <span class="text-xs text-zinc-500">({{ number_format(($a->size ?? 0)/1024,1) }} KB)</span>
                    </li>
                @endforeach
                </ul>
            </div>
            @endif

            @if(in_array($ticket->status, ['open', 'in_progress']))
            <div class="flex flex-col gap-2 mb-2">
                <p class="text-xs text-zinc-500 mb-2">
                    {{ __("Resolution Notes (optional)") }}
                </p>
                <textarea wire:model.defer="resolutionNotes.{{ $ticket->id }}" class="text-xs border border-neutral-200 dark:border-neutral-700 rounded px-2 py-1" rows="4" placeholder="Ce qui a été fait…"></textarea>

                @error('resolutionNotes.'.$ticket->id)
                    <div class="text-red-600 text-xs">{{ $message }}</div>
                @enderror
            </div>

            <button type="button" class="flex items-start cursor-pointer text-white text-xs bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded px-2 py-1.5 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" wire:click="resolve({{ $ticket->id }})">
                {{ __("Mark as Resolved") }}
            </button>
            @else
            <div class="text-xs">
                {{ __("Resolved At") }} {{ $ticket->resolved_at?->format('d/m/Y H:i') }}
                @if($ticket->resolution_note)
                    — <span class="italic">{{ $ticket->resolution_note }}</span>
                @endif
            </div>
            @endif
        </div>

        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-5">
            <h2 class="font-semibold mb-3">
                {{ __("Comments") }}
            </h2>

            <div class="space-y-4 mb-4">
                @foreach($ticket->comments as $c)
                <div class="rounded-lg bg-white/5 p-3">
                    <div class="text-xs text-zinc-500">{{ $c->commenter->name }} — {{ $c->created_at->format('d/m/Y H:i') }}</div>
                    <div class="mt-1 whitespace-pre-line text-sm">{{ $c->comment }}</div>
                </div>
                @endforeach
            </div>

            @if ($ticket->status === 'in_progress' || $ticket->status === 'open' || $ticket->status === 'resolved')
                <button wire:click="toggleCommentForm" class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    {{ $showCommentForm ? __("Cancel") : __("Add Comment") }}
                </button>
            @endif

            @if ($showCommentForm)
            <form wire:submit="addComment" class="mt-4 space-y-3">
                <div>
                    <label for="description" class="text-xs text-zinc-500">
                        {{ __("Your Comment") }}
                    </label>
                    <textarea wire:model.defer="comment" id="description" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Your comment..."></textarea>
                </div>

                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                        </div>
                        <input id="dropzone-file" type="file" wire:model="attachment" class="hidden" />
                    </label>
                </div> 

                <button class="cursor-pointer focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:hover:bg-green-700 dark:focus:ring-green-800">Publish</button>
            </form>
            @endif
        </div>
    </div>
</div>

