<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Logo -->
            <div class="flex items-center space-x-8">
                <a href="{{ route('dashboard') }}" class="text-lg font-bold text-stone-800 tracking-tight">
                    Arhilejas Papēdis
                </a>

                <a href="{{ route('dashboard') }}"
                   class="text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-amber-600' : 'text-stone-500 hover:text-stone-800' }} transition">
                    Panelis
                </a>

                @if(Auth::user()->isClient())
                    <a href="{{ route('orders.create') }}"
                       class="text-sm font-medium {{ request()->routeIs('orders.create') ? 'text-amber-600' : 'text-stone-500 hover:text-stone-800' }} transition">
                        Jauns pasūtījums
                    </a>
                @endif

                <a href="{{ route('pricelist') }}"
                   class="text-sm font-medium {{ request()->routeIs('pricelist') ? 'text-amber-600' : 'text-stone-500 hover:text-stone-800' }} transition">
                    Cenrādis
                </a>
            </div>

            <!-- Right side: user name + logout -->
            <div class="flex items-center gap-4">
                <span class="text-sm text-stone-500">{{ Auth::user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="text-sm font-medium text-stone-500 hover:text-red-600 border border-stone-200 hover:border-red-300 px-3 py-1.5 rounded-md transition">
                        Iziet
                    </button>
                </form>
            </div>

        </div>
    </div>
</nav>
