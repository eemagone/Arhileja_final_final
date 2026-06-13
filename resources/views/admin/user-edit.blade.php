<x-layouts.app :title="'Rediģēt lietotāju — Arhilejas Papēdis'">

    <div class="max-w-xl mx-auto">

        <div class="mb-6">
            <a href="{{ route('admin.users') }}" class="text-sm text-stone-500 hover:text-stone-700">← Atpakaļ uz lietotājiem</a>
            <h1 class="text-2xl font-semibold mt-2">Rediģēt lietotāju</h1>
            <p class="text-sm text-stone-500 mt-1">ID #{{ $user->id }} · reģistrēts kā <strong>{{ $user->email }}</strong></p>
        </div>

        @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.update', $user->id) }}"
              class="bg-white rounded-lg border border-stone-200 divide-y divide-stone-100">
            @csrf
            @method('PUT')

            {{-- Konta dati --}}
            <div class="p-6 space-y-4">
                <h2 class="text-sm font-semibold text-stone-500 uppercase tracking-wide">Konta dati</h2>

                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">Displeja vārds</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">E-pasts</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                           class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">Loma</label>
                    <select name="role" id="roleSelect"
                            class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                        <option value="klients"        {{ old('role', $user->role) === 'klients'        ? 'selected' : '' }}>Klients</option>
                        <option value="meistars"       {{ old('role', $user->role) === 'meistars'       ? 'selected' : '' }}>Meistars</option>
                        <option value="administrators" {{ old('role', $user->role) === 'administrators' ? 'selected' : '' }}>Administrators</option>
                    </select>
                </div>
            </div>

            {{-- Profila dati (klients / meistars) --}}
            <div class="p-6 space-y-4" id="profileSection">
                <h2 class="text-sm font-semibold text-stone-500 uppercase tracking-wide">Profila dati</h2>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Vārds</label>
                        <input type="text" name="vards"
                               value="{{ old('vards', $klients->Vards ?? $meistars->Vards ?? '') }}"
                               class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Uzvārds</label>
                        <input type="text" name="uzvards"
                               value="{{ old('uzvards', $klients->Uzvards ?? $meistars->Uzvards ?? '') }}"
                               class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">Tālrunis</label>
                    <input type="text" name="telnr"
                           value="{{ old('telnr', $klients->TelNr ?? $meistars->TelNr ?? '') }}"
                           placeholder="piem., 29123456"
                           class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                </div>

                {{-- Filiāle — tikai meistariem --}}
                <div id="filialeSection" class="{{ old('role', $user->role) !== 'meistars' ? 'hidden' : '' }}">
                    <label class="block text-sm font-medium text-stone-700 mb-1">
                        Filiāle <span class="text-red-500">*</span>
                    </label>
                    <select name="filiales_id"
                            class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                        <option value="">— izvēlies filiāli —</option>
                        @foreach($filiales as $f)
                            <option value="{{ $f->Filiales_ID }}"
                                {{ old('filiales_id', $meistars->Filiales_ID ?? '') == $f->Filiales_ID ? 'selected' : '' }}>
                                {{ $f->Nosaukums }} ({{ $f->Pilseta }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Admin notice --}}
                <div id="adminNotice" class="{{ old('role', $user->role) !== 'administrators' ? 'hidden' : '' }}">
                    <p class="text-sm text-stone-400 italic">Administratoriem nav nepieciešami profila dati.</p>
                </div>
            </div>

            {{-- Submit --}}
            <div class="p-6 flex items-center justify-between bg-stone-50 rounded-b-lg">
                <a href="{{ route('admin.users') }}" class="text-sm text-stone-500 hover:text-stone-700">Atcelt</a>
                <button type="submit"
                        class="bg-amber-500 hover:bg-amber-400 text-stone-900 font-medium text-sm px-6 py-2 rounded-md transition">
                    Saglabāt izmaiņas
                </button>
            </div>
        </form>
    </div>

    <script>
        const roleSelect = document.getElementById('roleSelect');
        const filialeSection = document.getElementById('filialeSection');
        const adminNotice = document.getElementById('adminNotice');
        const profileSection = document.getElementById('profileSection');

        function updateVisibility() {
            const role = roleSelect.value;
            filialeSection.classList.toggle('hidden', role !== 'meistars');
            adminNotice.classList.toggle('hidden', role !== 'administrators');
        }

        roleSelect.addEventListener('change', updateVisibility);
        updateVisibility();
    </script>

</x-layouts.app>
