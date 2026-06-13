<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cenrādis — Arhilejas Papēdis</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-stone-50">

    <nav class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">

                <!-- Logo -->
                <div class="flex items-center space-x-8">
                    <a href="{{ route('pricelist') }}" class="text-lg font-bold text-stone-800 tracking-tight">
                        Arhilejas Papēdis
                    </a>
                    <a href="{{ route('pricelist') }}" class="text-sm font-medium text-amber-600 transition">
                        Cenrādis
                    </a>
                </div>

                <!-- Right side -->
                <div class="flex items-center gap-3">
                    @auth
                        <span class="text-sm text-stone-500">{{ Auth::user()->name }}</span>
                        <a href="{{ route('dashboard') }}"
                           class="text-sm font-medium text-stone-500 hover:text-stone-800 border border-stone-200 hover:border-stone-400 px-3 py-1.5 rounded-md transition">
                            Panelis
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="text-sm font-medium text-stone-500 hover:text-red-600 border border-stone-200 hover:border-red-300 px-3 py-1.5 rounded-md transition">
                                Iziet
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                           class="text-sm font-medium text-stone-600 hover:text-stone-900 border border-stone-200 hover:border-stone-400 px-4 py-1.5 rounded-md transition">
                            Ieiet
                        </a>
                        <a href="{{ route('register') }}"
                           class="text-sm font-medium bg-amber-500 hover:bg-amber-400 text-stone-900 px-4 py-1.5 rounded-md transition">
                            Reģistrēties
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <h1 class="text-2xl font-semibold mb-8">Cenrādis un kontakti</h1>

        <section class="mb-10">
            <h2 class="text-lg font-semibold mb-3">Mūsu filiāles</h2>
            <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3">
                @forelse ($filiales as $filiale)
                    <div class="bg-white rounded-lg border border-stone-200 p-4">
                        <h3 class="font-semibold">{{ $filiale->Nosaukums }}</h3>
                        <p class="text-sm text-stone-600 mt-1">{{ $filiale->Adrese }}</p>
                        <p class="text-sm text-stone-600">{{ $filiale->Pilseta }}</p>
                    </div>
                @empty
                    <p class="text-stone-500 text-sm">Filiāles pašlaik nav pieejamas.</p>
                @endforelse
            </div>
        </section>

        <section>
            <h2 class="text-lg font-semibold mb-3">Pakalpojumu un materiālu cenrādis</h2>
            <div class="bg-white rounded-lg border border-stone-200 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-stone-100 text-stone-600">
                        <tr>
                            <th class="text-left px-4 py-2 font-medium">Materiāls / pakalpojums</th>
                            <th class="text-left px-4 py-2 font-medium">Mērvienība</th>
                            <th class="text-right px-4 py-2 font-medium">Cena (EUR)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse ($materiali ?? [] as $materials)
                            <tr>
                                <td class="px-4 py-2">{{ $materials->Nosaukums }}</td>
                                <td class="px-4 py-2 text-stone-500">{{ $materials->Mervieniba }}</td>
                                <td class="px-4 py-2 text-right">{{ number_format($materials->Cena, 2) }} &euro;</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-stone-500">Cenrādis pašlaik nav pieejams.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <p class="text-xs text-stone-500 mt-2">
                Piezīme: galīgā pasūtījuma cena ietver darba izmaksas un izmantotos materiālus, ko nosaka meistars remonta procesā.
            </p>
        </section>

    </main>

</body>
</html>
