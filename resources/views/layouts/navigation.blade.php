<nav class="bg-white border-b border-stone-200">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-center h-14">

            {{-- LEFT: Logo --}}
            <a href="{{ auth()->check() ? route('dashboard') : route('pricelist') }}" class="shrink-0 flex items-center gap-2">
                <img src="/logo.png" alt="Arhilejas Papēdis" class="h-8 w-auto">
                <span class="text-base font-bold text-stone-900 tracking-tight">Arhilejas Papēdis</span>
            </a>

            {{-- CENTRE: Nav links --}}
            <div class="flex items-center gap-1">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-3 py-1.5 rounded-md text-sm font-medium transition
                              {{ request()->routeIs('dashboard') ? 'bg-amber-50 text-amber-700' : 'text-stone-500 hover:bg-stone-100 hover:text-stone-800' }}">
                        Panelis
                    </a>

                    @if(Auth::user()->isClient())
                        <a href="{{ route('orders.create') }}"
                           class="px-3 py-1.5 rounded-md text-sm font-medium transition
                                  {{ request()->routeIs('orders.create') ? 'bg-amber-50 text-amber-700' : 'text-stone-500 hover:bg-stone-100 hover:text-stone-800' }}">
                            Jauns pasūtījums
                        </a>
                    @endif

                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.users') }}"
                           class="px-3 py-1.5 rounded-md text-sm font-medium transition
                                  {{ request()->routeIs('admin.users*') ? 'bg-amber-50 text-amber-700' : 'text-stone-500 hover:bg-stone-100 hover:text-stone-800' }}">
                            Lietotāji
                        </a>
                    @endif
                @endauth

                <a href="{{ route('pricelist') }}"
                   class="px-3 py-1.5 rounded-md text-sm font-medium transition
                          {{ request()->routeIs('pricelist') ? 'bg-amber-50 text-amber-700' : 'text-stone-500 hover:bg-stone-100 hover:text-stone-800' }}">
                    Cenrādis
                </a>
            </div>

            {{-- RIGHT: logged in = user + iziet, guest = ieiet + reģistrēties --}}
            <div class="flex items-center gap-3 shrink-0">
                @auth
                    <span class="text-sm text-stone-400">{{ Auth::user()->name }}</span>
                    <div class="w-px h-4 bg-stone-200"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-stone-500 hover:text-red-600 transition">
                            Iziet
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="text-sm font-medium text-stone-600 hover:text-stone-900 transition">
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
