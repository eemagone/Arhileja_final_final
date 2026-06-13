<x-layouts.app :title="'Lietotāju pārvaldība — Arhilejas Papēdis'">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold">Lietotāju pārvaldība</h1>
            <p class="text-sm text-stone-500 mt-1">{{ $users->count() }} lietotāji sistēmā</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->has('delete'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
            {{ $errors->first('delete') }}
        </div>
    @endif

    {{-- Group by role --}}
    @foreach([
        'administrators' => ['label' => 'Administratori', 'color' => 'bg-purple-100 text-purple-700'],
        'meistars'       => ['label' => 'Meistari',       'color' => 'bg-amber-100 text-amber-700'],
        'klients'        => ['label' => 'Klienti',        'color' => 'bg-blue-100 text-blue-700'],
    ] as $role => $meta)
        @php $group = $users->where('role', $role); @endphp
        @if($group->isNotEmpty())
            <section class="mb-8">
                <h2 class="text-base font-semibold text-stone-600 mb-3">
                    {{ $meta['label'] }}
                    <span class="text-stone-400 font-normal">({{ $group->count() }})</span>
                </h2>
                <div class="bg-white rounded-lg border border-stone-200 overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="bg-stone-50 text-stone-500 border-b border-stone-200">
                            <tr>
                                <th class="text-left px-4 py-2 font-medium">Vārds</th>
                                <th class="text-left px-4 py-2 font-medium">E-pasts</th>
                                <th class="text-left px-4 py-2 font-medium">Profils</th>
                                <th class="text-left px-4 py-2 font-medium">Loma</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @foreach($group as $u)
                                <tr class="hover:bg-stone-50">
                                    <td class="px-4 py-3 font-medium">{{ $u->name }}</td>
                                    <td class="px-4 py-3 text-stone-500">{{ $u->email }}</td>
                                    <td class="px-4 py-3 text-stone-600">
                                        @if($u->klients)
                                            {{ $u->klients->Vards }} {{ $u->klients->Uzvards }}
                                            @if($u->klients->TelNr)
                                                <span class="text-stone-400"> · {{ $u->klients->TelNr }}</span>
                                            @endif
                                        @elseif($u->meistars)
                                            {{ $u->meistars->Vards }} {{ $u->meistars->Uzvards }}
                                            @if($u->meistars->filiale)
                                                <span class="text-stone-400"> · {{ $u->meistars->filiale->Nosaukums }}</span>
                                            @endif
                                        @else
                                            <span class="text-stone-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-block px-2 py-0.5 rounded text-xs font-medium {{ $meta['color'] }}">
                                            {{ $meta['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('admin.users.edit', $u->id) }}"
                                               class="text-sm text-amber-600 hover:text-amber-700 font-medium">
                                                Rediģēt
                                            </a>
                                            @if($u->id !== auth()->id())
                                                <form method="POST" action="{{ route('admin.users.delete', $u->id) }}"
                                                      onsubmit="return confirm('Dzēst lietotāju {{ addslashes($u->name) }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-sm text-red-500 hover:text-red-700 font-medium">
                                                        Dzēst
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-xs text-stone-300">Tu</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        @endif
    @endforeach

</x-layouts.app>
