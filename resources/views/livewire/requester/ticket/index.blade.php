<div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
            <div class="flex gap-4">
                <select wire:model="status"   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="all">{{ __("Status") }}</option>
                    <option value="open">{{ __("Open") }}</option>
                    <option value="in_progress">{{ __("In progress") }}</option>
                    <option value="resolved">{{ __("Resolved") }}</option>
                    <option value="closed">{{ __("Closed") }}</option>
                </select>
                <select wire:model="priority" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="all">{{ __("Priority") }}</option>
                    <option value="urgent">Urgent</option>
                    <option value="normal">Normal</option>
                    <option value="bas">Bas</option>
                </select>
                <select wire:model="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="all">{{ __("Category") }}</option>
                    <option>Réseau</option>
                    <option>Imprimantes</option>
                    <option>Applications</option>
                    <option>Accès utilisateurs</option>
                    <option>Téléphonie interne</option>
                </select>
            </div>
            <div class="flex gap-4">
                <div>
                    <label for="table-search" class="sr-only"> {{ __("Search") }} </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input type="text" id="table-search" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for items">
                    </div>
                </div>
                <a href="{{ route('tickets.create') }}" wire:navigate class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 px-3 py-2">
                    {{ __("Create Ticket") }}
                </a>
            </div>
        </div>
        <div class="border border-neutral-200 dark:border-neutral-700 rounded-lg p-4">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Subject') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Category') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Priority') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Status') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Created At') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Resolved At') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $ticket)
                        <tr class="border-b border-neutral-200 dark:border-neutral-700">
                            <th scope="row" class="px-6 py-4 text-xs text-gray-900 whitespace-nowrap dark:text-white">
                                <a href="{{ route('tickets.show', $ticket) }}" class="hover:underline">{{ $ticket->subject }}</a>
                            </th>
                            <td class="px-6 py-4 text-xs">
                                {{ $ticket->category->name }}
                            </td>
                            <td class="px-6 py-4 text-xs">
                                <span class="inline-flex items-center rounded-md bg-blue-400/10 px-2 py-1 text-xs font-medium text-blue-400 inset-ring inset-ring-blue-500/20">
                                    {{ ucfirst(str_replace('_', ' ', $ticket->priority)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs">
                                <span class="inline-flex items-center rounded-md @if ($ticket->status === 'open') bg-emerald-300/90 text-emerald-900 @endif @if ($ticket->status === 'in_progress') bg-yellow-300/90 text-yellow-900 @endif @if ($ticket->status === 'resolved') bg-green-500 @endif @if ($ticket->status === 'closed') bg-red-700 text-white @endif px-2 py-1 text-xs font-semibold">
                                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs">
                                {{ $ticket->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-xs">
                                {{ $ticket->status === 'closed' ? $ticket->resolved_at->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline" href="{{ route('tickets.show',$ticket) }}" wire:navigate>Show</a>
                            </td>
                        </tr>
                        
                    @empty
                        {{ __("No tickets at this time") }}
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
