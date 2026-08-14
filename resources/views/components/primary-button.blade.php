<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-ledger border border-transparent rounded-md font-semibold text-xs text-paper uppercase tracking-widest hover:bg-ink focus:bg-ink active:bg-ink focus:outline-none focus:ring-2 focus:ring-ledger focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>