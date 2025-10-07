<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        @can('admin.access')
            <a href="{{ route('admin.dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>
        @endcan
        
        @role('Technicien')
            <a href="{{ route('tech.dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>
        @endrole

        @role('Demandeur')
            <a href="{{ route('tickets.index') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>
        @endrole

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')" class="grid">
                {{-- Dashboard Admin : visible UNIQUEMENT si admin.access --}}
                @hasanyrole('Admin|Super-Admin')
                    @can('admin.access')
                        <flux:navlist.item icon="home" :href="route('admin.dashboard')" :current="request()->routeIs('admin.dashboard')"
                        wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                        <flux:navlist.item icon="ticket" :href="route('admin.tickets.index')" :current="request()->routeIs('admin.tickets.index')"
                        wire:navigate>{{ __('All Tickets') }}</flux:navlist.item>
                    @endcan

                    {{-- Users : visible UNIQUEMENT si users.manage --}}
                    @can('users.manage')
                        <flux:navlist.item icon="user" :href="route('admin.users.index')"
                        :current="request()->routeIs('admin.users.index')" wire:navigate>{{ __('Users') }}
                        </flux:navlist.item>
                    @endcan

                    @can('categories.manage')
                        <flux:navlist.item icon="tag" :href="route('admin.categories.index')"
                        :current="request()->routeIs('admin.categories.index')" wire:navigate>{{ __('Categories') }}
                        </flux:navlist.item>
                    @endcan
                @endhasanyrole

                @role('Technicien')
                    <flux:navlist.item icon="home" :href="route('tech.dashboard')" :current="request()->routeIs('tech.dashboard')"
                        wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                    <flux:navlist.item icon="wrench" :href="route('tech.tickets.index')" :current="request()->routeIs('tech.tickets.index')"
                    wire:navigate>{{ __('Ticket assigned') }}</flux:navlist.item>
                @endrole

                @role('Demandeur')
                    <flux:navlist.item icon="ticket" :href="route('tickets.index')" :current="request()->routeIs('tickets.index')"
                    wire:navigate>{{ __('My Tickets') }}</flux:navlist.item>
                @endrole
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        <livewire:language-switcher />

        <!-- Desktop User Menu -->
        <flux:dropdown class="hidden lg:block" position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon:trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @fluxScripts
</body>

</html>