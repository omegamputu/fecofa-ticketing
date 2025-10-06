<div>
    <div class="rounded-xl border border-neutral-200 dark:border-neutral-700">
        <h2 class="font-semibold mb-3 p-5"> {{ __("Requester Tickets") }} </h2>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <div class="flex items-center gap-2 p-4">
            <div>
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white"> {{ __("Search") }} </label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="text" id="default-search" wire:model.live="search" class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __("Search by name") }}" required />
                </div>
            </div>

            <div>
                <select wire:model="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="all"> {{ __("All status") }} </option>
                    <option value="open"> {{ __("Open") }} </option>
                    <option value="in_progress"> {{ __("In progress") }} </option>
                    <option value="resolved"> {{ __("Resolved") }} </option>
                    <option value="closed"> {{ __("Closed") }} </option>
                </select>
            </div>
        </div>

        <table class="w-full text-sm text-left rtl:text-right">
            <thead class="text-xs text-gray-700 dark:text-gray-400 uppercase">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Subject') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Requester') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Status') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Assignee') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Created at') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Resolved at') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Actions') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $item)
                <tr wire:key="ticket-{{ $item->id }}" class=" text-gray-700 dark:text-gray-400">
                    <td class="px-6 py-4 text-xs">
                        {{ $item->subject }}
                    </td>
                    <td class="px-6 py-4 text-xs">
                        {{ $item->requester->name }}
                    </td>
                    <td class="px-6 py-4 text-xs">
                        <span class="inline-flex items-center rounded-md @if ($item->status === 'open') bg-emerald-300/90 text-emerald-900 @endif @if ($item->status === 'in_progress') bg-yellow-300/90 text-yellow-900 @endif @if ($item->status === 'resolved') bg-green-500 @endif @if ($item->status === 'closed') bg-red-700 text-white @endif px-2 py-1 text-xs font-semibold">
                            {{ __(ucfirst(str_replace('_', ' ', $item->status))) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-xs">
                        {{ $item->assignee->name ?? '_' }}
                    </td>
                    <td class="px-6 py-4 text-xs">
                        {{ $item->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 text-xs">
                        {{ $item->status === 'closed' ? $item->resolved_at->format('d/m/Y H:i') : '-' }}
                    </td>
                    <td class="px-6 py-4">
                        @if ($item->status === 'closed')
                            <span class="text-zinc-500"> {{ __("No action possible") }} </span>
                        @elseif ($item->status === 'resolved')
                        <button wire:click="closed({{ $item->id }})" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 cursor-pointer">
                            Fermé
                        </button>
                        @else
                        <div class="flex gap-2">
                            <div>
                                <select wire:model.lazy="assignees.{{ $item->id }}" id="assigneeTo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">{{ __("Select Assignee") }}</option>
                                    @foreach($techs as $techId => $techName)
                                        <option value="{{ $techId }}">{{ $techName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button wire:click="assign({{ $item->id }})" {{ empty($assignees[$item->id] ?? null) ? 'disabled' : '' }} class="bg-blue-300/90 text-blue-900 rounded-lg focus:ring-4 focus:outline-none text-sm px-5 py-2.5 text-center cursor-pointer">
                                {{ __('Assign') }}
                            </button>
                            @error('assignees.'.$item->id)
                                <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                    <tr class="border-b border-neutral-200 dark:border-neutral-700">
                        <td class="p-3 text-zinc-500" colspan="6"> {{ __("No tickets at this time") }} </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
