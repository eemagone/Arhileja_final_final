<x-guest-layout>
    <h2 class="text-xl font-semibold text-stone-800 mb-6">Ieiet</h2>

    @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm space-y-1">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if(session('status'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-stone-700 mb-1">E-pasts</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 @error('email') border-red-400 @enderror">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-stone-700 mb-1">Parole</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="w-full rounded-md border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
        </div>

        <button type="submit"
                class="w-full bg-amber-500 hover:bg-amber-400 text-stone-900 font-semibold py-2.5 rounded-md transition text-sm mt-2">
            Ieiet
        </button>

        <p class="text-center text-sm text-stone-500">
            Nav konta?
            <a href="{{ route('register') }}" class="text-amber-600 hover:text-amber-700 font-medium">Reģistrēties</a>
        </p>
    </form>
</x-guest-layout>
