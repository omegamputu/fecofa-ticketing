<div>
    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />
    
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-5 md:grid-cols-3">
            <div>
                <h1 class="text-xl font-semibold mb-4"> {{ __("Edit") }} <span class=" text-blue-700">{{ $user->name }}</span> </h1>
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
                        <label for="jobTitle" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            {{ __("Job Title") }}
                        </label>
                        <input type="text" wire:model.defer="job_title" id="jobTitle" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>

                    @foreach($roles as $r)
                    <div class="flex items-center mb-5">
                        <input checked id="checkbox-1" type="checkbox" value="{{ $r }}" wire:model="selectedRoles" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkbox-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            {{ $r }}
                        </label>
                    </div>
                    @endforeach
                    
                    <button class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 cursor-pointer">
                        {{ __("Save") }}
                    </button>
                </form>
            </div>

            <div>
                {{-- Statut --}}
                <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
                    <div class="text-sm text-zinc-500 dark:text-zinc-300">
                        <span class="font-semibold">{{ __("Status") }} :</span> {{ $statusLabel }}
                    </div>
                    <div class="text-sm text-zinc-500 dark:text-zinc-300">
                        <span class="font-semibold mb-3"> {{ __("Invitation Sent") }} </span> : {{ $user->invitation_sent_count ?? 0 }} </br>
                        
                        @if($user->invited_at)
                            <span class="font-semibold">{{ __("Last Sent") }}</span> : {{ optional($user->invited_at)->format('d/m/Y H:i') }}
                        @endif
                    </div>
                    <div class="mt-3">
                        <button wire:click="resendInvitation" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer">
                            {{ __("Resend Invitation") }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>