<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>{{ $title ?? config('app.name') }}</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxAppearance

    </head>
    <body>
        <main class="relative min-h-screen bg-black text-white">
            <header class="absolute inset-x-0 top-0 z-20">
                <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-6 py-5 lg:px-10">
                    <div>
                        <h1 class="text-xl font-bold tracking-tight">FECOFA Ticketing</h1>
                        <p class="text-xs text-zinc-300"> {{ __("Incident management platform") }} </p>
                    </div>

                    <nav class="hidden md:block">
                        <ul class="flex items-center">
                            <li class="ml-10">
                                <a href="#features" class="group block">
                                <div class="flex items-center justify-end">
                                    <div class="w-10 border-b border-white/60 transition-all group-hover:w-12"></div>
                                    <span class="ml-3 text-2xl font-extrabold">1</span>
                                </div>
                                <div class="text-right text-sm text-zinc-300"> {{ __("Submit a ticket") }} </div>
                                </a>
                            </li>
                            <li class="ml-10">
                                <a href="#features" class="group block">
                                <div class="flex items-center justify-end">
                                    <div class="w-10 border-b border-white/60 transition-all group-hover:w-12"></div>
                                    <span class="ml-3 text-2xl font-extrabold">2</span>
                                </div>
                                <div class="text-right text-sm text-zinc-300"> {{ __("Follow-up and priorities") }} </div>
                                </a>
                            </li>
                            <li class="ml-10">
                                <a href="#features" class="group block">
                                <div class="flex items-center justify-end">
                                    <div class="w-10 border-b border-white/60 transition-all group-hover:w-12"></div>
                                    <span class="ml-3 text-2xl font-extrabold">3</span>
                                </div>
                                <div class="text-right text-sm text-zinc-300"> {{ __("Technician assignment") }} </div>
                                </a>
                            </li>
                            <li class="ml-10">
                                <a href="#features" class="group block">
                                <div class="flex items-center justify-end">
                                    <div class="w-10 border-b border-white/60 transition-all group-hover:w-12"></div>
                                    <span class="ml-3 text-2xl font-extrabold">4</span>
                                </div>
                                <div class="text-right text-sm text-zinc-300"> {{ __("Reports") }} </div>
                                </a>
                            </li>
                        </ul>
                    </nav>

                    <div class="flex items-center gap-3">
                        <livewire:language-switcher />
                    </div>
                </div>
            </header>

            <section class="relative z-10 mx-auto grid max-w-7xl grid-cols-1 items-center gap-10 px-6 pt-36 pb-16 lg:grid-cols-2 lg:px-10 lg:pt-40">
                <div class="w-full">
                    <span class="mb-2 inline-block text-xs font-bold uppercase tracking-widest text-zinc-300">FECOFA • IT Service Desk</span>
                    <h2 class="text-4xl font-extrabold tracking-tight sm:text-5xl">
                        {{ __("Manage your") }} <span class="text-emerald-400"> {{ __("incidents") }} </span><br class="hidden sm:block"> {{ __("and requests with ease") }}
                    </h2>

                    <p class="mt-4 max-w-xl text-zinc-300">
                        {{ __("Report your problems (netword, printers, access, applications...) track progress in real time, collaborate with technicians, and improve service quality at FECOFA.") }}
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('login') }}" class="inline-flex items-center rounded-xl bg-white px-5 py-3 text-sm font-semibold text-black hover:bg-zinc-100">
                            {{ __("Log in") }}
                        </a>
                    </div>
                </div>

                <div class="relative">
                    <div class="mx-auto w-full max-w-xl rounded-2xl bg-white/5 p-6 shadow-xl ring-1 ring-white/10">
                        <div class="mb-3 flex items-center justify-between">
                            <span class="text-sm font-semibold"> {{ __("Ticket overview") }} </span>
                            <span class="rounded-full bg-white/10 px-2 py-0.5 text-xs"> {{ __("Live") }} </span>
                        </div>

                        <ul class="space-y-2 text-sm">
                            <li class="flex items-center justify-between rounded-lg bg-white/5 p-3">
                                <span class="truncate">{{ __("Access issue Email - Password") }}</span>
                                <span class="rounded-md bg-yellow-300/90 px-2 py-0.5 text-xs font-semibold text-yellow-900"> {{ __("In Progress") }} </span>
                            </li>
                            <li class="flex items-center justify-between rounded-lg bg-white/5 p-3">
                                <span class="truncate"> {{ __("Printer - Paper jam") }} </span>
                                <span class="rounded-md bg-emerald-300/90 px-2 py-0.5 text-xs font-semibold text-emerald-900"> {{ __('Open') }} </span>
                            </li>
                            <li class="flex items-center justify-between rounded-lg bg-white/5 p-3">
                                <span class="truncate"> {{ __("Network - No internet access") }} </span>
                                <span class="rounded-md bg-blue-300/90 px-2 py-0.5 text-xs font-semibold text-blue-900"> {{ __("Assigned") }} </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <footer class="relative z-10 mx-auto w-full max-w-7xl px-6 pb-10 lg:px-10">
                <p class="text-sm font-medium"> {{ __("IT Service") }} — FECOFA</p>
                <p class="text-xs text-zinc-400">Support : it@fecofa.cd</p>
            </footer>
        </main>
    </body>
</html>
