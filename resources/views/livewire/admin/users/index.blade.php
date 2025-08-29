<div>
    <div class="flex items-center justify-between mb-4">
        <input type="text" wire:model.live="search" placeholder="Rechercher…" class="border rounded px-3 py-2">
        <a href="{{ route('admin.users.create') }}" wire:navigate class="border rounded px-3 py-2">+ Nouvel
            utilisateur</a>
    </div>

    <table class="w-full border border-gray-400 dark:border-gray-500 text-sm">
        <tr>
            <th class="p-2 text-left">Nom</th>
            <th class="p-2 text-left">Email</th>
            <th class="p-2 text-left">Rôles</th>
            <th class="p-2"></th>
        </tr>
        @foreach($users as $u)
        <tr class="border-t">
            <td class="p-2">{{ $u->name }}</td>
            <td class="p-2">{{ $u->email }}</td>
            <td class="p-2">{{ $u->getRoleNames()->join(', ') }}</td>
            <td class="p-2 text-right space-x-2">
                <a class="underline" href="{{ route('admin.users.edit',$u) }}" wire:navigate>Éditer</a>
                <button wire:click="delete({{ $u->id }})" onclick="return confirm('Supprimer ?')">Supprimer</button>
            </td>
        </tr>
        @endforeach
    </table>

    <div class="mt-4">{{ $users->links() }}</div>
</div>