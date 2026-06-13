<x-layouts.app :title="'Administratora panelis — Arhilejas Papēdis'">
    <h1 class="text-2xl font-semibold mb-6">Administratora panelis</h1>

    <section>
        <h2 class="text-lg font-semibold mb-3">Visi pasūtījumi</h2>

        @if ($pasutijumi->isEmpty())
            <div class="bg-white rounded-lg border border-stone-200 p-4 text-center text-stone-500 text-sm">
                Pašlaik nav neviena pasūtījuma sistēmā.
            </div>
        @else
            <div class="bg-white rounded-lg border border-stone-200 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-stone-100 text-stone-600">
                        <tr>
                            <th class="text-left px-4 py-2 font-medium">#</th>
                            <th class="text-left px-4 py-2 font-medium">Klients</th>
                            <th class="text-left px-4 py-2 font-medium">Apavi</th>
                            <th class="text-left px-4 py-2 font-medium">Meistars / filiāle</th>
                            <th class="text-left px-4 py-2 font-medium">Statuss</th>
                            <th class="text-right px-4 py-2 font-medium">Cena</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @php
                            $statusColors = [
                                'Jauns' => 'bg-blue-100 text-blue-700',
                                'Procesā' => 'bg-amber-100 text-amber-700',
                                'Gatavs' => 'bg-green-100 text-green-700',
                                'Atcelts' => 'bg-red-100 text-red-700',
                            ];
                        @endphp
                        @foreach ($pasutijumi as $p)
                            <tr class="hover:bg-stone-50 cursor-pointer" onclick="window.location='{{ route('orders.show', $p->Pasutijumi_ID) }}'">
                                <td class="px-4 py-2 font-medium">{{ $p->Pasutijumi_ID }}</td>
                                <td class="px-4 py-2">
                                    {{ $p->apavi->klients->Vards ?? '—' }} {{ $p->apavi->klients->Uzvards ?? '' }}
                                </td>
                                <td class="px-4 py-2 text-stone-600">
                                    {{ $p->apavi->Zimols ?? '' }} {{ $p->apavi->Tips ?? '' }}
                                </td>
                                <td class="px-4 py-2 text-stone-600">
                                    @if ($p->meistars)
                                        {{ $p->meistars->Vards }} {{ $p->meistars->Uzvards }}
                                        <span class="text-stone-400">({{ $p->meistars->filiale->Nosaukums ?? '—' }})</span>
                                    @else
                                        <span class="text-stone-400">Nav piesaistīts</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    <span class="inline-block px-2 py-1 rounded text-xs font-medium {{ $statusColors[$p->Statuss] ?? 'bg-stone-100 text-stone-700' }}">
                                        {{ $p->Statuss }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-right font-semibold">{{ number_format($p->Cena, 2) }} &euro;</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
</x-layouts.app>