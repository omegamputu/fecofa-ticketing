<div>
    <div class="grid auto-rows-min gap-3 md:grid-cols-4">
        <div>
            <h1 class="text-xl font-semibold mb-4">
                {{ __("Add new user") }}
            </h1>

            <form wire:submit="save" class="space-y-4">
                <div class="mb-5">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        {{ __("Name") }}
                    </label>
                    <input type="text" wire:model.defer="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John Doe" required />
                </div>
                
                <div class="mb-5">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        {{ __("Email") }}
                    </label>
                    <input type="email" wire:model.defer="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="john.doe@fecofa.cd" required />
                </div>
                
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        {{ __("Role") }}
                    </label>
                    <select wire:model="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value=""> {{ __("Select Role") }} </option>
                        @foreach($roles as $r)
                        <option value="{{ $r }}">{{ $r }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="text-white bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    {{ __("Save") }}
                </button>
            </form>
        </div>
    </div>
</div>