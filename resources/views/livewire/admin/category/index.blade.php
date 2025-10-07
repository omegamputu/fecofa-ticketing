<div>
    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <div class="flex justify-end mb-5">
        <a href="{{ route('admin.categories.create') }}" wire:navigate class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 px-3 py-2">
            {{ __("Create Category") }}
        </a>
    </div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-1">
            <div class="border border-neutral-200 dark:border-neutral-700 rounded-lg p-4">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Id
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __("Name") }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __("Description") }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ __("Actions") }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr class="border-b border-neutral-200 dark:border-neutral-700 rounded-lg">
                            <th scope="row" class="px-6 py-4">
                                {{ $category->id }}
                            <td class="px-6 py-4">
                                {{ $category->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $category->description }}
                            </td>
                            <td class="px-6 py-4">
                                <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline" href="{{ route('admin.categories.edit',$category) }}" wire:navigate>
                                    {{ __("Edit") }}
                                </a>
                                <button class="font-medium text-red-600 dark:text-red-500 cursor-pointer hover:underline" wire:click="delete({{ $category->id }})" onclick="return confirm({{ __('Are you sure you want to delete this category?') }})">
                                    {{ __("Delete") }}
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
