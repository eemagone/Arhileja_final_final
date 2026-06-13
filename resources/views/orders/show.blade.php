<x-layouts.app :title="'Pasūtījums #' . $pasutijums->Pasutijumi_ID . ' — Arhilejas Papēdis'">

    @php
        $statusColors = [
            'Jauns' => 'bg-blue-100 text-blue-700',
            'Procesā' => 'bg-amber-100 text-amber-700',
            'Gatavs' => 'bg-green-100 text-green-700',
            'Atcelts' => 'bg-red-100 text-red-700',
        ];
        $user = auth()->user();
        $isClosed = $pasutijums->atsauksme !== null || in_array($pasutijums->Statuss, ['Atcelts']);
        $canManage = ($user->isMaster() || $user->isAdmin()) && !$isClosed;
    @endphp

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Pasūtījums #{{ $pasutijums->Pasutijumi_ID }}</h1>
        <span class="inline-block px-3 py-1 rounded text-sm font-medium {{ $statusColors[$pasutijums->Statuss] ?? 'bg-stone-100 text-stone-700' }}">
            {{ $pasutijums->Statuss }}
        </span>
    </div>

    <div class="grid md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg border border-stone-200 p-4">
            <h2 class="text-sm font-semibold text-stone-600 mb-3">Apavi</h2>
            <dl class="space-y-1 text-sm">
                <div class="flex justify-between"><dt class="text-stone-500">Zīmols</dt><dd>{{ $pasutijums->apavi->Zimols ?? '—' }}</dd></div>
                <div class="flex justify-between"><dt class="text-stone-500">Tips</dt><dd>{{ $pasutijums->apavi->Tips ?? '—' }}</dd></div>
                <div class="flex justify-between"><dt class="text-stone-500">Materiāls</dt><dd>{{ $pasutijums->apavi->ApavuMaterials ?? '—' }}</dd></div>
                <div class="flex justify-between"><dt class="text-stone-500">Klients</dt><dd>{{ $pasutijums->apavi->klients->Vards ?? '' }} {{ $pasutijums->apavi->klients->Uzvards ?? '' }}</dd></div>
                @if($canManage)
                    <div class="flex justify-between"><dt class="text-stone-500">Tālrunis</dt><dd>{{ $pasutijums->apavi->klients->TelNr ?? '—' }}</dd></div>
                @endif
            </dl>
        </div>

        <div class="bg-white rounded-lg border border-stone-200 p-4">
            <h2 class="text-sm font-semibold text-stone-600 mb-3">Pasūtījums</h2>
            <dl class="space-y-1 text-sm">
                <div class="flex justify-between"><dt class="text-stone-500">Remonta veids</dt><dd class="text-right">{{ $pasutijums->RemontaVeids }}</dd></div>
                <div class="flex justify-between"><dt class="text-stone-500">Pieņemts</dt><dd>{{ \Illuminate\Support\Carbon::parse($pasutijums->Pienemsanas_Datums)->format('d.m.Y') }}</dd></div>
                <div class="flex justify-between"><dt class="text-stone-500">Termiņš</dt><dd>{{ $pasutijums->Termins ? \Illuminate\Support\Carbon::parse($pasutijums->Termins)->format('d.m.Y') : '—' }}</dd></div>
                @if($pasutijums->Garantijas_Termins)
                    <div class="flex justify-between"><dt class="text-stone-500">Garantija līdz</dt><dd>{{ \Illuminate\Support\Carbon::parse($pasutijums->Garantijas_Termins)->format('d.m.Y') }}</dd></div>
                @endif
                <div class="flex justify-between"><dt class="text-stone-500">Meistars</dt>
                    <dd>
                        @if($pasutijums->meistars)
                            {{ $pasutijums->meistars->Vards }} {{ $pasutijums->meistars->Uzvards }}
                            ({{ $pasutijums->meistars->filiale->Nosaukums ?? '—' }})
                        @else
                            <span class="text-stone-400">Nav piesaistīts</span>
                        @endif
                    </dd>
                </div>
                <div class="flex justify-between pt-2 border-t border-stone-100 mt-2">
                    <dt class="font-semibold">Kopējā cena</dt>
                    <dd class="font-semibold">{{ number_format($pasutijums->Cena, 2) }} &euro;</dd>
                </div>
            </dl>
        </div>
    </div>

    {{-- Izmantotie materiāli --}}
    <div class="bg-white rounded-lg border border-stone-200 p-4 mb-6">
        <h2 class="text-sm font-semibold text-stone-600 mb-3">Izmantotie materiāli</h2>

        @if ($pasutijums->materiali->isEmpty())
            <p class="text-sm text-stone-500">Materiāli šim pasūtījumam vēl nav pievienoti.</p>
        @else
            <table class="w-full text-sm">
                <thead class="text-stone-500">
                    <tr>
                        <th class="text-left font-medium pb-1">Materiāls</th>
                        <th class="text-right font-medium pb-1">Daudzums</th>
                        <th class="text-right font-medium pb-1">Cena / vien.</th>
                        <th class="text-right font-medium pb-1">Summa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach ($pasutijums->materiali as $m)
                        <tr>
                            <td class="py-1">{{ $m->Nosaukums }}</td>
                            <td class="py-1 text-right">{{ $m->pivot->Daudzums }} {{ $m->Mervieniba }}</td>
                            <td class="py-1 text-right">{{ number_format($m->Cena, 2) }} &euro;</td>
                            <td class="py-1 text-right">{{ number_format($m->Cena * $m->pivot->Daudzums, 2) }} &euro;</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    @if (($user->isMaster() || $user->isAdmin()) && $isClosed)
        <div class="bg-stone-50 border border-stone-200 rounded-lg px-4 py-3 mb-6 text-sm text-stone-500 flex items-center gap-2">
            <span></span>
            <span>Pasūtījums ir slēgts! Klients ir atstājis atsauksmi. Rediģēšana nav iespējama.</span>
        </div>
    @endif

    @if ($canManage)
        {{-- Materiālu pievienošana / cenas pārrēķins --}}
        <div class="bg-white rounded-lg border border-stone-200 p-4 mb-6">
            <h2 class="text-sm font-semibold text-stone-600 mb-3">Pievienot materiālus un pārrēķināt cenu</h2>

            <form method="POST" action="{{ route('orders.calculatePrice', $pasutijums->Pasutijumi_ID) }}" class="space-y-3">
                @csrf

                <div id="materiali-rows" class="space-y-2">
                    <div class="flex gap-2 items-center">
                        <select name="materiali[0][materiali_id]" class="flex-1 rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                            @foreach ($materiali as $m)
                                <option value="{{ $m->Materiali_ID }}">{{ $m->Nosaukums }} ({{ number_format($m->Cena, 2) }} &euro; / {{ $m->Mervieniba }})</option>
                            @endforeach
                        </select>
                        <input type="number" name="materiali[0][daudzums]" min="1" value="1" placeholder="Daudzums"
                            class="w-24 rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                <button type="button" onclick="addMaterialRow()" class="text-sm text-amber-600 hover:underline">
                    + Pievienot vēl materiālu
                </button>

                <div>
                    <label class="block text-sm font-medium mb-1" for="darba_cena">Darba izmaksas (EUR)</label>
                    <input type="number" step="0.01" min="0" name="darba_cena" id="darba_cena" value="0"
                        class="w-40 rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <p class="text-xs text-stone-500 mt-1">Pievienots materiālu summai, lai izveidotu galīgo cenu.</p>
                </div>

                <button type="submit"
                    class="bg-stone-900 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-stone-700 transition">
                    Norakstīt materiālus un pārrēķināt cenu
                </button>
            </form>
        </div>

        <script>
            let materialRowIndex = 1;
            function addMaterialRow() {
                const container = document.getElementById('materiali-rows');
                const row = container.children[0].cloneNode(true);
                row.querySelectorAll('select, input').forEach(el => {
                    el.name = el.name.replace(/\[\d+\]/, `[${materialRowIndex}]`);
                    if (el.tagName === 'INPUT') el.value = 1;
                });
                container.appendChild(row);
                materialRowIndex++;
            }
        </script>

        {{-- Statusa maiņa --}}
        <div class="bg-white rounded-lg border border-stone-200 p-4 mb-6">
            <h2 class="text-sm font-semibold text-stone-600 mb-3">Mainīt statusu</h2>

            <form method="POST" action="{{ route('orders.updateStatus', $pasutijums->Pasutijumi_ID) }}" class="flex items-center gap-3">
                @csrf
                <select name="statuss" class="rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                    @foreach (['Jauns', 'Procesā', 'Gatavs', 'Atcelts'] as $status)
                        <option value="{{ $status }}" @selected($pasutijums->Statuss === $status)>{{ $status }}</option>
                    @endforeach
                </select>
                <button type="submit"
                    class="bg-amber-500 text-stone-900 px-4 py-2 rounded-md text-sm font-medium hover:bg-amber-400 transition">
                    Atjaunināt
                </button>
            </form>
        </div>
    @endif

    {{-- Atsauksme --}}
    <div class="bg-white rounded-lg border border-stone-200 p-4">
        <h2 class="text-sm font-semibold text-stone-600 mb-3">Atsauksme</h2>

        @if ($pasutijums->atsauksme)
            {{-- Show review to everyone --}}
            <div class="text-sm space-y-1">
                <div class="flex items-center gap-2">
                    <span class="font-medium">Vērtējums:</span>
                    <span class="font-semibold text-amber-600">{{ $pasutijums->atsauksme->Vertejums }} / 5</span>
                    <span class="text-stone-400">
                        @for ($i = 1; $i <= 5; $i++)
                            {{ $i <= $pasutijums->atsauksme->Vertejums ? '★' : '☆' }}
                        @endfor
                    </span>
                </div>
                @if ($pasutijums->atsauksme->Komentars)
                    <p class="text-stone-600 mt-1">{{ $pasutijums->atsauksme->Komentars }}</p>
                @endif
            </div>
        @elseif ($user->isClient() && $pasutijums->Statuss === 'Gatavs')
            {{-- Review form only for the client --}}
            <form method="POST" action="{{ route('reviews.store', $pasutijums->Pasutijumi_ID) }}" class="space-y-3">
                @csrf

                <div>
                    <label class="block text-sm font-medium mb-1" for="vertejums">Vērtējums (1–5)</label>
                    <select name="vertejums" id="vertejums" class="rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                        @for ($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1" for="komentars">Komentārs</label>
                    <textarea name="komentars" id="komentars" rows="3"
                        class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"></textarea>
                </div>

                <button type="submit"
                    class="bg-amber-500 text-stone-900 px-4 py-2 rounded-md text-sm font-medium hover:bg-amber-400 transition">
                    Iesniegt atsauksmi
                </button>
            </form>
        @else
            <p class="text-sm text-stone-500">
                @if($user->isClient())
                    Atsauksmi varēsi sniegt, kad pasūtījums būs pabeigts.
                @else
                    Klients vēl nav atstājis atsauksmi.
                @endif
            </p>
        @endif
    </div>

</x-layouts.app>