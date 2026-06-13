<x-guest-layout>
    <h2 class="text-xl font-semibold text-stone-800 mb-6">Reģistrācija</h2>

    @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm space-y-1">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-stone-700 mb-1">Lietotājvārds</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 @error('name') border-red-400 @enderror">
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label for="vards" class="block text-sm font-medium text-stone-700 mb-1">Vārds</label>
                <input id="vards" type="text" name="vards" value="{{ old('vards') }}" required
                       class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 @error('vards') border-red-400 @enderror">
            </div>
            <div>
                <label for="uzvards" class="block text-sm font-medium text-stone-700 mb-1">Uzvārds</label>
                <input id="uzvards" type="text" name="uzvards" value="{{ old('uzvards') }}" required
                       class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 @error('uzvards') border-red-400 @enderror">
            </div>
        </div>

        <div>
            <label for="telnr" class="block text-sm font-medium text-stone-700 mb-1">
                Tālrunis <span class="text-stone-400 font-normal">(neobligāts)</span>
            </label>
            <input id="telnr" type="text" name="telnr" value="{{ old('telnr') }}"
                   placeholder="piem., 29123456"
                   class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-stone-700 mb-1">E-pasts</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                   class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 @error('email') border-red-400 @enderror">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-stone-700 mb-1">Parole</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 @error('password') border-red-400 @enderror">
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-stone-700 mb-1">Atkārtot paroli</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
        </div>

        <button type="submit"
                class="w-full bg-amber-500 hover:bg-amber-400 text-stone-900 font-semibold py-2.5 rounded-md transition text-sm mt-2">
            Reģistrēties
        </button>

        <p class="text-center text-sm text-stone-500">
            Jau ir konts?
            <a href="{{ route('login') }}" class="text-amber-600 hover:text-amber-700 font-medium">Ieiet</a>
        </p>
    </form>
</x-guest-layout>
