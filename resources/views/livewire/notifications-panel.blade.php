<div>
    <div class="px-4 py-6 lg:px-8 text-white min-h-screen bg-zinc-900">
        <div class="mb-6 flex items-start justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-xl font-semibold text-white flex items-center gap-2">
                    Notifications
                    @if($unreadCount > 0)
                        <span class="rounded-full bg-emerald-600 text-xs font-semibold px-2 py-0.5">
                            {{ $unreadCount }} non lue{{ $unreadCount > 1 ? 's' : '' }}
                        </span>
                    @endif
                </h1>

                <p class="text-sm text-zinc-400 mt-1">
                    Activité liée aux tickets : création, assignation, résolution.
                </p>
            </div>

            @if($unreadCount > 0)
                <button
                    wire:click="markAllAsRead"
                    class="inline-flex items-center rounded-lg bg-zinc-800 hover:bg-zinc-700 border border-zinc-600 px-3 py-2 text-xs font-medium text-zinc-200 cursor-pointer"
                >
                    Marquer tout comme lu
                </button>
            @endif
        </div>

        <div class="space-y-3">
            @forelse ($notifications as $n)
                <div class="rounded-lg border border-zinc-700/60 bg-zinc-800/70 p-4 text-sm flex flex-col gap-2">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            {{-- Message principal --}}
                            <div class="font-medium text-emerald-400">
                                {{ $n['data']['message'] ?? 'Notification' }}
                            </div>

                            {{-- Détails contextuels --}}
                            <div class="text-xs text-zinc-400 mt-1 leading-relaxed">
                                @if($n['data']['ticket_id'])
                                    Ticket #{{ $n['data']['ticket_id'] }}
                                @endif

                                @if($n['data']['subject'])
                                    — <span class="text-zinc-200 font-medium">{{ $n['data']['subject'] }}</span>
                                @endif

                                @if($n['data']['status'])
                                    — Statut : <span class="text-zinc-300">{{ $n['data']['status'] }}</span>
                                @endif

                                @if($n['data']['assigned_by'])
                                    — Assigné par : <span class="text-zinc-300">{{ $n['data']['assigned_by'] }}</span>
                                @endif

                                @if($n['data']['created_by'])
                                    — Créé par : <span class="text-zinc-300">{{ $n['data']['created_by'] }}</span>
                                @endif

                                @if($n['data']['resolved_by'])
                                    — Résolu par : <span class="text-zinc-300">{{ $n['data']['resolved_by'] }}</span>
                                @endif
                            </div>

                            {{-- Horodatage --}}
                            <div class="text-[11px] text-zinc-500 mt-2">
                                Reçu {{ $n['created_at'] }}
                            </div>
                        </div>

                        {{-- Badge non lu --}}
                        @if($n['is_unread'])
                            <span class="text-[10px] font-semibold bg-emerald-600 text-white px-2 py-1 rounded-md">
                                Non lu
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center flex-wrap gap-3 text-[11px]">
                        {{-- Bouton Voir le ticket, si tu as une route --}}
                        @if($n['data']['ticket_id'])
                            <a
                                href="{{ route('tickets.show', $n['data']['ticket_id']) ?? '#' }}"
                                class="inline-flex items-center rounded bg-zinc-700 hover:bg-zinc-600 px-2 py-1 font-medium text-zinc-100 border border-zinc-600"
                            >
                                Voir le ticket
                            </a>
                        @endif

                        {{-- Bouton lire --}}
                        @if($n['is_unread'])
                            <button
                                wire:click="markAsRead('{{ $n['id'] }}')"
                                class="inline-flex items-center rounded bg-emerald-600 hover:bg-emerald-500 px-2 py-1 font-medium text-white"
                            >
                                Marquer comme lu
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center text-sm text-zinc-500 py-16">
                    Aucune notification pour l’instant.
                </div>
            @endforelse
        </div>
    </div>
</div>
