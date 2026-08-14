@php
    $isStaff = auth()->user()->role === 'staff';
    $user = auth()->user();
@endphp
<nav x-data="{ open: false }" class="bg-paper border-b border-hairline">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-1 sm:px-2 lg:px-3">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ $isStaff ? route('sales.index') : route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-ledger" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:ms-8 sm:flex">
                    @unless($isStaff)
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endunless

                    @if($user->canManage('products'))
                        <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                            {{ __('Products') }}
                        </x-nav-link>
                    @endif

                    @if($user->canManage('stock'))
                        <x-nav-link :href="route('stock.index')" :active="request()->routeIs('stock.index')">
                            {{ __('Stock') }}
                        </x-nav-link>
                        <x-nav-link :href="route('stock.history')" :active="request()->routeIs('stock.history')">
                            {{ __('Stock history') }}
                        </x-nav-link>
                    @endif

                    @if($user->canManage('sales'))
                        <x-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.index')">
                            {{ __('Sales') }}
                        </x-nav-link>
                        <x-nav-link :href="route('sales.history')" :active="request()->routeIs('sales.history')">
                            {{ __('Sale history') }}
                        </x-nav-link>
                    @endif

                    @if($user->canManage('customers'))
                        <x-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')">
                            {{ __('Customers') }}
                        </x-nav-link>
                    @endif

                    @if($user->canManage('expenses'))
                        <x-nav-link :href="route('expenses.index')" :active="request()->routeIs('expenses.*')">
                            {{ __('Expenses') }}
                        </x-nav-link>
                    @endif

                    @if($user->canManage('reports'))
                        <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
                            {{ __('Reports') }}
                        </x-nav-link>
                    @endif

                    @if($user->canManage('settings'))
                        <x-nav-link :href="route('settings.index')" :active="request()->routeIs('settings.*')">
                            {{ __('Settings') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Logout -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex items-center justify-center w-10 h-10 rounded-md text-gray-500 hover:text-negative hover:bg-paper focus:outline-none transition ease-in-out duration-150"
                            aria-label="Log out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @unless($isStaff)
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endunless

            @if($user->canManage('products'))
                <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                    {{ __('Products') }}
                </x-responsive-nav-link>
            @endif

            @if($user->canManage('stock'))
                <x-responsive-nav-link :href="route('stock.index')" :active="request()->routeIs('stock.index')">
                    {{ __('Stock') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('stock.history')" :active="request()->routeIs('stock.history')">
                    {{ __('Stock history') }}
                </x-responsive-nav-link>
            @endif

            @if($user->canManage('sales'))
                <x-responsive-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.index')">
                    {{ __('Sales') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('sales.history')" :active="request()->routeIs('sales.history')">
                    {{ __('Sale history') }}
                </x-responsive-nav-link>
            @endif

            @if($user->canManage('customers'))
                <x-responsive-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')">
                    {{ __('Customers') }}
                </x-responsive-nav-link>
            @endif

            @if($user->canManage('expenses'))
                <x-responsive-nav-link :href="route('expenses.index')" :active="request()->routeIs('expenses.*')">
                    {{ __('Expenses') }}
                </x-responsive-nav-link>
            @endif

            @if($user->canManage('reports'))
                <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
                    {{ __('Reports') }}
                </x-responsive-nav-link>
            @endif

            @if($user->canManage('settings'))
                <x-responsive-nav-link :href="route('settings.index')" :active="request()->routeIs('settings.*')">
                    {{ __('Settings') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Logout -->
        <div class="pt-4 pb-1 border-t border-hairline">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-negative text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</nav>