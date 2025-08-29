<div>
    <div class="grid auto-rows-min gap-3 md:grid-cols-4">
        <div>
            <h1 class="text-xl font-semibold mb-4">Créer un utilisateur</h1>

            <form wire:submit="save" class="space-y-4">
                <div>
                    <label class="block text-sm">Nom</label>
                    <input type="text" wire:model.defer="name" class="border rounded px-3 py-2 w-full">
                    @error('name') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="block text-sm">Email</label>
                    <input type="email" wire:model.defer="email" class="border rounded px-3 py-2 w-full">
                    @error('email') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="block text-sm">Rôle</label>
                    <select wire:model="role" class="border rounded px-3 py-2 w-full">
                        <option value="">— Choisir —</option>
                        @foreach($roles as $r)
                        <option value="{{ $r }}">{{ $r }}</option>
                        @endforeach
                    </select>
                    @error('role')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <button class="border cursor-pointer rounded px-4 py-2">Créer & envoyer
                    l’invitation</button>
            </form>
        </div>
    </div>
</div>