<x-layouts.app :title="'Jauns pasūtījums — Arhilejas Papēdis'">

    <div class="max-w-2xl mx-auto">

        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="text-sm text-stone-500 hover:text-stone-700">← Atpakaļ uz paneli</a>
            <h1 class="text-2xl font-semibold mt-2">Jauns pasūtījums</h1>
            <p class="text-sm text-stone-500 mt-1">Ievadi informāciju par apaviem un vajadzīgo remontu.</p>
        </div>

        @if (session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('orders.store') }}" class="bg-white rounded-lg border border-stone-200 divide-y divide-stone-100">

            @csrf

            {{-- APAVI INFO --}}
            <div class="p-6 space-y-5">
                <h2 class="text-base font-semibold text-stone-700">Apavu informācija</h2>

                {{-- Zimols --}}
                <div>
                    <label for="zimols" class="block text-sm font-medium text-stone-700 mb-1">
                        Zīmols <span class="text-stone-400 font-normal">(neobligāts)</span>
                    </label>
                    <input
                        type="text"
                        id="zimols"
                        name="zimols"
                        value="{{ old('zimols') }}"
                        placeholder="piem., Nike, Adidas..."
                        maxlength="100"
                        class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent @error('zimols') border-red-400 @enderror"
                    >
                    @error('zimols')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tips --}}
                <div>
                    <label for="tips" class="block text-sm font-medium text-stone-700 mb-1">
                        Apavu tips <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="tips"
                        name="tips"
                        class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent @error('tips') border-red-400 @enderror"
                    >
                        <option value="">— izvēlies veidu —</option>
                        @foreach(['Kedas', 'Zābaki', 'Kurpes', 'Sandales', 'Tupeles', 'Sportsapavi', 'Cits'] as $tips)
                            <option value="{{ $tips }}" {{ old('tips') === $tips ? 'selected' : '' }}>{{ $tips }}</option>
                        @endforeach
                    </select>
                    @error('tips')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Materiāls --}}
                <div>
                    <label for="apavu_materials" class="block text-sm font-medium text-stone-700 mb-1">
                        Apavu materiāls <span class="text-stone-400 font-normal">(neobligāts)</span>
                    </label>
                    <select
                        id="apavu_materials"
                        name="apavu_materials"
                        class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent @error('apavu_materials') border-red-400 @enderror"
                    >
                        <option value="">— nezinu / nav svarīgi —</option>
                        @foreach(['Āda', 'Mākslīgā āda', 'Tekstils', 'Gumija', 'Zamšāda', 'Cits'] as $mat)
                            <option value="{{ $mat }}" {{ old('apavu_materials') === $mat ? 'selected' : '' }}>{{ $mat }}</option>
                        @endforeach
                    </select>
                    @error('apavu_materials')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- REMONTA INFO --}}
            <div class="p-6 space-y-5">
                <h2 class="text-base font-semibold text-stone-700">Remonta informācija</h2>

                {{-- Remonta veids --}}
                <div>
                    <label for="remonta_veids" class="block text-sm font-medium text-stone-700 mb-1">
                        Remonta veids / apraksts <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        id="remonta_veids"
                        name="remonta_veids"
                        rows="3"
                        maxlength="255"
                        placeholder="piem., Nomainīt papēdi, salīmēt zoli, apmest ādu..."
                        class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent resize-none @error('remonta_veids') border-red-400 @enderror"
                    >{{ old('remonta_veids') }}</textarea>
                    @error('remonta_veids')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Termins --}}
                <div>
                    <label for="termins" class="block text-sm font-medium text-stone-700 mb-1">
                        Vēlamais izpildes termiņš <span class="text-stone-400 font-normal">(neobligāts)</span>
                    </label>
                    <input
                        type="date"
                        id="termins"
                        name="termins"
                        value="{{ old('termins') }}"
                        min="{{ now()->addDay()->format('Y-m-d') }}"
                        class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent @error('termins') border-red-400 @enderror"
                    >
                    @error('termins')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- SUBMIT --}}
            <div class="p-6 flex items-center justify-between bg-stone-50 rounded-b-lg">
                <p class="text-xs text-stone-400">Lauki ar <span class="text-red-500">*</span> ir obligāti</p>
                <button
                    type="submit"
                    class="bg-amber-500 hover:bg-amber-400 text-stone-900 font-medium text-sm px-6 py-2 rounded-md transition"
                >
                    Iesniegt pasūtījumu
                </button>
            </div>

        </form>
    </div>

</x-layouts.app>
