<x-layouts.app :title="'Mani pasūtījumi — Arhilejas Papēdis'">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">
            Sveiks, {{ $klients->Vards ?? auth()->user()->name }}!
        </h1>
        <a href="{{ route('orders.create') }}"
            class="bg-amber-500 text-stone-900 px-4 py-2 rounded-md font-medium hover:bg-amber-400 transition text-sm">
            + Jauns pasūtījums
        </a>
    </div>

    @if ($pasutijumi->isEmpty())
        <div class="bg-white rounded-lg border border-stone-200 p-6 text-center text-stone-500">
            Tev pašlaik nav neviena pasūtījuma.
            <a href="{{ route('orders.create') }}" class="text-amber-600 hover:underline">Izveidot pirmo!</a>
        </div>
    @else
        <div class="grid gap-4">
            @foreach ($pasutijumi as $p)
                <a href="{{ route('orders.show', $p->Pasutijumi_ID) }}"
                    class="bg-white rounded-lg border border-stone-200 p-4 hover:border-amber-400 transition flex items-center justify-between">
                    <div>
                        <p class="font-semibold">
                            #{{ $p->Pasutijumi_ID }} &mdash; {{ $p->apavi->Zimols ?? '' }} {{ $p->apavi->Tips ?? '' }}
                        </p>
                        <p class="text-sm text-stone-600 mt-1">{{ $p->RemontaVeids }}</p>
                        <p class="text-xs text-stone-500 mt-1">
                            Pieņemts: {{ \Illuminate\Support\Carbon::parse($p->Pienemsanas_Datums)->format('d.m.Y') }}
                            @if($p->meistars?->filiale)
                                &middot; {{ $p->meistars->filiale->Nosaukums }}
                            @endif
                        </p>
                    </div>

                    <div class="text-right">
                        @php
                            $statusColors = [
                                'Jauns' => 'bg-blue-100 text-blue-700',
                                'Procesā' => 'bg-amber-100 text-amber-700',
                                'Gatavs' => 'bg-green-100 text-green-700',
                                'Atcelts' => 'bg-red-100 text-red-700',
                            ];
                        @endphp
                        <span class="inline-block px-2 py-1 rounded text-xs font-medium {{ $statusColors[$p->Statuss] ?? 'bg-stone-100 text-stone-700' }}">
                            {{ $p->Statuss }}
                        </span>
                        <p class="text-sm font-semibold mt-2">{{ number_format($p->Cena, 2) }} &euro;</p>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</x-layouts.app>