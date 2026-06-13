<x-layouts.app :title="'Darba galds — Arhilejas Papēdis'">
    <h1 class="text-2xl font-semibold mb-2">
        Sveiks, {{ $meistars->Vards ?? auth()->user()->name }}!
    </h1>
    <p class="text-sm text-stone-500 mb-6">
        Filiāle: {{ $meistars->filiale->Nosaukums ?? '—' }} ({{ $meistars->filiale->Pilseta ?? '—' }})
    </p>

    <section class="mb-10">
        <h2 class="text-lg font-semibold mb-3">Jauni pasūtījumu pieprasījumi</h2>

        @if ($jauniePasutijumi->isEmpty())
            <div class="bg-white rounded-lg border border-stone-200 p-4 text-center text-stone-500 text-sm">
                Pašlaik nav jaunu nepiesaistītu pasūtījumu.
            </div>
        @else
            <div class="grid gap-3">
                @foreach ($jauniePasutijumi as $p)
                    <a href="{{ route('orders.show', $p->Pasutijumi_ID) }}"
                        class="bg-white rounded-lg border border-stone-200 p-4 hover:border-amber-400 transition flex items-center justify-between">
                        <div>
                            <p class="font-semibold">
                                #{{ $p->Pasutijumi_ID }} &mdash; {{ $p->apavi->Zimols ?? '' }} {{ $p->apavi->Tips ?? '' }}
                            </p>
                            <p class="text-sm text-stone-600 mt-1">{{ $p->RemontaVeids }}</p>
                            <p class="text-xs text-stone-500 mt-1">
                                Klients: {{ $p->apavi->klients->Vards ?? '' }} {{ $p->apavi->klients->Uzvards ?? '' }}
                            </p>
                        </div>
                        <span class="inline-block px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-700">
                            Jauns
                        </span>
                    </a>
                @endforeach
            </div>
        @endif
    </section>

    <section>
        <h2 class="text-lg font-semibold mb-3">Mani aktīvie pasūtījumi</h2>

        @if ($maniPasutijumi->isEmpty())
            <div class="bg-white rounded-lg border border-stone-200 p-4 text-center text-stone-500 text-sm">
                Tev pašlaik nav piesaistītu pasūtījumu.
            </div>
        @else
            <div class="grid gap-3">
                @foreach ($maniPasutijumi as $p)
                    @php
                        $statusColors = [
                            'Jauns' => 'bg-blue-100 text-blue-700',
                            'Procesā' => 'bg-amber-100 text-amber-700',
                            'Gatavs' => 'bg-green-100 text-green-700',
                            'Atcelts' => 'bg-red-100 text-red-700',
                        ];
                    @endphp
                    <a href="{{ route('orders.show', $p->Pasutijumi_ID) }}"
                        class="bg-white rounded-lg border border-stone-200 p-4 hover:border-amber-400 transition flex items-center justify-between">
                        <div>
                            <p class="font-semibold">
                                #{{ $p->Pasutijumi_ID }} &mdash; {{ $p->apavi->Zimols ?? '' }} {{ $p->apavi->Tips ?? '' }}
                            </p>
                            <p class="text-sm text-stone-600 mt-1">{{ $p->RemontaVeids }}</p>
                            <p class="text-xs text-stone-500 mt-1">
                                Klients: {{ $p->apavi->klients->Vards ?? '' }} {{ $p->apavi->klients->Uzvards ?? '' }}
                                @if($p->Termins)
                                    &middot; Termiņš: {{ \Illuminate\Support\Carbon::parse($p->Termins)->format('d.m.Y') }}
                                @endif
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-2 py-1 rounded text-xs font-medium {{ $statusColors[$p->Statuss] ?? 'bg-stone-100 text-stone-700' }}">
                                {{ $p->Statuss }}
                            </span>
                            <p class="text-sm font-semibold mt-2">{{ number_format($p->Cena, 2) }} &euro;</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>

    <section class="mt-10">
        <h2 class="text-lg font-semibold mb-3">Filiāles materiālu krājumi</h2>

        @php
            $krajumi = $meistars->filiale?->krajumi ?? collect();
        @endphp

        @if ($krajumi->isEmpty())
            <div class="bg-white rounded-lg border border-stone-200 p-4 text-center text-stone-500 text-sm">
                Krājumu informācija nav pieejama.
            </div>
        @else
            <div class="bg-white rounded-lg border border-stone-200 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-stone-100 text-stone-600">
                        <tr>
                            <th class="text-left px-4 py-2 font-medium">Materiāls</th>
                            <th class="text-left px-4 py-2 font-medium">Mērvienība</th>
                            <th class="text-right px-4 py-2 font-medium">Pieejams</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach ($krajumi as $k)
                            <tr>
                                <td class="px-4 py-2">{{ $k->materiali->Nosaukums ?? '—' }}</td>
                                <td class="px-4 py-2 text-stone-500">{{ $k->materiali->Mervieniba ?? '—' }}</td>
                                <td class="px-4 py-2 text-right {{ $k->Apjoms < 10 ? 'text-red-600 font-semibold' : '' }}">
                                    {{ $k->Apjoms }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
</x-layouts.app>