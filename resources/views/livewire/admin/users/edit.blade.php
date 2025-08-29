<div>
    <div class="grid auto-rows-min gap-3 md:grid-cols-4">
        <div>
            <h1 class="text-xl font-semibold mb-4">Éditer {{ $user->name }}</h1>

            <form wire:submit="save" class="space-y-4">
                <div>
                    <label class="block text-sm">Nom</label>
                    <input type="text" wire:model.defer="name" class="border rounded px-3 py-2 w-full">
                    @error('name')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm">Email</label>
                    <input type="email" wire:model.defer="email" class="border rounded px-3 py-2 w-full">
                    @error('email')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm">Rôles</label>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($roles as $r)
                        <label class="flex items-center gap-2">
                            <input type="checkbox" value="{{ $r }}" wire:model="selectedRoles">
                            <span>{{ $r }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <button class="border rounded px-4 py-2">Enregistrer</button>
            </form>
        </div>
    </div>
</div>