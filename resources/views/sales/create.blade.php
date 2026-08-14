<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sales</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:500,600|ibm-plex-sans:400,500,600|ibm-plex-mono:400,500&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        button { -webkit-tap-highlight-color: transparent; }
    </style>
</head>
<body class="font-sans antialiased">

    <div class="h-screen flex flex-col overflow-hidden bg-paper">

        @include('layouts.navigation')

        <div class="flex-1 min-h-0 px-6 flex flex-col py-4 box-border">

            <div class="flex items-center gap-3 mb-3 shrink-0">
                <div class="flex-1 min-h-[44px] border border-hairline rounded-lg shadow-sm bg-white flex items-center px-3">
                    <label for="product-search" class="sr-only">Search products</label>
                    <input
                        type="search"
                        id="product-search"
                        placeholder="Search in products..."
                        class="flex-1 border-0 focus:ring-0 p-0 text-sm"
                    >
                    <span class="text-sm text-gray-500 whitespace-nowrap select-none pointer-events-none pl-3">
                        Welcome, <span class="font-medium text-ink">{{ auth()->user()->name }}</span>
                    </span>
                </div>
            </div>

            @if($errors->any())
                <div class="mb-3 p-3 bg-white border border-negative text-negative rounded-lg shadow-sm shrink-0" role="alert">
                    @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            @endif

            <div class="flex-1 min-h-0 flex gap-6 items-stretch flex-col lg:flex-row">

                <div class="w-full lg:w-[70%] min-w-0 flex flex-col bg-white border border-hairline rounded-xl shadow-sm p-5 min-h-0">

                    <div class="flex gap-2 pb-4 mb-4 border-b border-hairline overflow-x-auto shrink-0">
                        <button
                            type="button"
                            class="category-btn transition-none px-4 py-2 min-h-[36px] rounded-full font-medium whitespace-nowrap focus:outline-none focus-visible:ring-2 focus-visible:ring-ledger bg-ledger text-paper text-sm"
                            data-category="general"
                            aria-pressed="true"
                        >
                            General
                        </button>
                    </div>

                    <div class="flex-1 min-h-0 overflow-y-auto">
                        <div class="grid grid-cols-4 sm:grid-cols-5 lg:grid-cols-6 gap-2" id="product-grid">
                            @forelse($products as $product)
                                <button
                                    type="button"
                                    class="product-tile transition-none aspect-square flex flex-col items-center justify-center text-center p-2 bg-white border border-hairline rounded-lg shadow-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-ledger"
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}"
                                    data-price="{{ $product->selling_price }}"
                                    data-stock="{{ $product->quantity }}"
                                    aria-label="Add {{ $product->name }}, {{ number_format($product->selling_price, 2) }}"
                                >
                                    <span class="block font-semibold text-ink text-xs leading-snug">{{ $product->name }}</span>
                                    <span class="block text-xs text-ledger font-mono font-medium mt-1">{{ number_format($product->selling_price, 2) }}</span>
                                </button>
                            @empty
                                <p class="col-span-full text-gray-500 py-8 text-center">No products available to sell right now.</p>
                            @endforelse
                        </div>
                    </div>

                </div>

                <div class="w-full lg:w-[30%] min-w-0 shrink-0 flex flex-col bg-white border border-hairline rounded-xl shadow-sm p-5 min-h-0">
                    <h2 class="font-serif text-lg text-ink mb-3 shrink-0">Current Sale</h2>

                    <div id="cart-items" aria-live="polite" class="flex-1 min-h-0 overflow-y-auto space-y-2 mb-3">
                        <p id="cart-empty-msg" class="text-sm text-gray-400 py-6 text-center">No items added yet.</p>
                    </div>

                    <div class="mb-3 border border-hairline rounded-lg p-3 shrink-0" id="customer-info-panel">
                        <div class="flex justify-between items-center">
                            <button type="button" id="customer-info-toggle" class="font-medium text-sm text-ink min-h-[44px] flex items-center focus:outline-none">Customer info (optional)</button>
                            <button type="button" id="customer-info-close" aria-label="Collapse customer info" class="hidden w-8 h-8 items-center justify-center rounded-lg hover:bg-paper text-gray-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-ledger">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div id="customer-info-body" class="hidden mt-3 space-y-2">
                            <div>
                                <label for="customer_name" class="block text-xs text-gray-500 mb-1">Name</label>
                                <input type="text" id="customer_name" name="customer_name" class="w-full border border-hairline rounded-lg p-2 min-h-[44px] focus:outline-none focus-visible:ring-2 focus-visible:ring-ledger">
                            </div>
                            <div>
                                <label for="customer_phone" class="block text-xs text-gray-500 mb-1">Phone</label>
                                <input type="text" id="customer_phone" name="customer_phone" class="w-full border border-hairline rounded-lg p-2 min-h-[44px] focus:outline-none focus-visible:ring-2 focus-visible:ring-ledger">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 border border-hairline rounded-lg p-3 shrink-0">
                        <p class="font-medium mb-2 text-xs text-gray-500 uppercase tracking-wide">Discount</p>
                        <div class="flex gap-2">
                            <select id="discount_type" name="discount_type" class="border border-hairline rounded-lg pl-2 pr-8 py-2 min-h-[44px] flex-1 focus:outline-none focus-visible:ring-2 focus-visible:ring-ledger">
                                <option value="">None</option>
                                <option value="flat">Flat</option>
                                <option value="percent">%</option>
                            </select>
                            <input type="number" step="0.01" min="0" id="discount_value" name="discount_value" value="0" class="border border-hairline rounded-lg p-2 min-h-[44px] w-24 focus:outline-none focus-visible:ring-2 focus-visible:ring-ledger">
                        </div>
                    </div>

                    <div class="mb-3 text-sm space-y-1.5 bg-paper rounded-lg p-3 shrink-0 font-mono" aria-live="polite">
                        <div class="flex justify-between text-gray-600"><span class="font-sans">Subtotal</span><span id="subtotal-display">0.00</span></div>
                        <div class="flex justify-between text-gray-600"><span class="font-sans">Discount</span><span id="discount-display">0.00</span></div>
                        <div class="flex justify-between font-semibold text-base text-ink pt-1.5 border-t border-hairline"><span class="font-sans">Total</span><span id="total-display">0.00</span></div>
                    </div>

                    <form id="sale-form" action="{{ route('sales.store') }}" method="POST" class="shrink-0">
                        @csrf
                        <div id="hidden-items-container"></div>
                        <button
                            type="submit"
                            id="checkout-btn"
                            disabled
                            class="w-full px-4 py-4 min-h-[44px] bg-ledger text-paper font-semibold rounded-lg shadow-sm hover:bg-ink disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none focus-visible:ring-2 focus-visible:ring-ledger"
                        >
                            Checkout
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    @if(session('completedSale'))
        <script id="completed-sale-data" type="application/json">{!! json_encode(session('completedSale')) !!}</script>
    @endif

    <script>
        const cart = {};

        const customerToggle = document.getElementById('customer-info-toggle');
        const customerClose = document.getElementById('customer-info-close');
        const customerBody = document.getElementById('customer-info-body');

        customerToggle.addEventListener('click', function () {
            const isOpen = !customerBody.classList.contains('hidden');
            customerBody.classList.toggle('hidden');
            customerClose.classList.toggle('hidden', isOpen);
            customerClose.classList.toggle('flex', !isOpen);
        });

        customerClose.addEventListener('click', function () {
            customerBody.classList.add('hidden');
            customerClose.classList.add('hidden');
            customerClose.classList.remove('flex');
        });

        document.querySelectorAll('.category-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.category-btn').forEach(function (b) {
                    b.classList.remove('bg-ledger', 'text-paper');
                    b.classList.add('bg-white', 'text-ink', 'border', 'border-hairline');
                    b.setAttribute('aria-pressed', 'false');
                });
                this.classList.remove('bg-white', 'text-ink', 'border', 'border-hairline');
                this.classList.add('bg-ledger', 'text-paper');
                this.setAttribute('aria-pressed', 'true');
            });
        });

        document.getElementById('product-search').addEventListener('input', function () {
            const term = this.value.toLowerCase();
            document.querySelectorAll('.product-tile').forEach(function (tile) {
                const name = tile.dataset.name.toLowerCase();
                tile.style.display = name.includes(term) ? '' : 'none';
            });
        });

        document.querySelectorAll('.product-tile').forEach(function (tile) {
            tile.addEventListener('click', function () {
                addToCart(this.dataset.id, this.dataset.name, parseFloat(this.dataset.price), parseInt(this.dataset.stock));
            });
        });

        function addToCart(id, name, price, maxStock) {
            if (cart[id]) {
                cart[id].quantity++;
            } else {
                cart[id] = { name: name, price: price, quantity: 1, maxStock: maxStock };
            }
            renderCart();
        }

        function changeQuantity(id, delta) {
            if (!cart[id]) return;
            cart[id].quantity += delta;
            if (cart[id].quantity <= 0) {
                delete cart[id];
            }
            renderCart();
        }

        function removeFromCart(id) {
            delete cart[id];
            renderCart();
        }

        function renderCart() {
            const container = document.getElementById('cart-items');
            const ids = Object.keys(cart);

            container.innerHTML = '';

            if (ids.length === 0) {
                const emptyMsg = document.createElement('p');
                emptyMsg.id = 'cart-empty-msg';
                emptyMsg.className = 'text-sm text-gray-400 py-6 text-center';
                emptyMsg.textContent = 'No items added yet.';
                container.appendChild(emptyMsg);
            } else {
                ids.forEach(function (id) {
                    const item = cart[id];
                    const lineTotal = (item.price * item.quantity).toFixed(2);
                    const row = document.createElement('div');
                    row.className = 'border border-hairline rounded-lg p-3';
                    row.innerHTML = `
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="text-sm font-medium text-ink">${item.name}</p>
                                <p class="text-xs text-gray-500 font-mono">${item.price.toFixed(2)} × ${item.quantity} = <span class="text-ledger font-medium">${lineTotal}</span></p>
                            </div>
                            <button type="button" aria-label="Remove ${item.name} from cart" class="w-8 h-8 min-w-[36px] min-h-[36px] flex items-center justify-center text-negative hover:bg-paper rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-negative" onclick="removeFromCart('${id}')">&times;</button>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" aria-label="Decrease quantity of ${item.name}" class="w-9 h-9 min-w-[44px] min-h-[44px] flex items-center justify-center bg-paper rounded-lg hover:bg-hairline focus:outline-none focus-visible:ring-2 focus-visible:ring-ledger" onclick="changeQuantity('${id}', -1)">−</button>
                            <span class="w-6 text-center text-sm font-medium font-mono">${item.quantity}</span>
                            <button type="button" aria-label="Increase quantity of ${item.name}" class="w-9 h-9 min-w-[44px] min-h-[44px] flex items-center justify-center bg-paper rounded-lg hover:bg-hairline focus:outline-none focus-visible:ring-2 focus-visible:ring-ledger" onclick="changeQuantity('${id}', 1)">+</button>
                        </div>
                    `;
                    container.appendChild(row);
                });
            }

            updateTotals();
        }

        function updateTotals() {
            let subtotal = 0;
            Object.values(cart).forEach(function (item) {
                subtotal += item.price * item.quantity;
            });

            const discountType = document.getElementById('discount_type').value;
            const discountValue = parseFloat(document.getElementById('discount_value').value || 0);
            let discountAmount = 0;

            if (discountType === 'flat') {
                discountAmount = Math.min(discountValue, subtotal);
            } else if (discountType === 'percent') {
                discountAmount = subtotal * (Math.min(discountValue, 100) / 100);
            }

            const total = subtotal - discountAmount;

            document.getElementById('subtotal-display').textContent = subtotal.toFixed(2);
            document.getElementById('discount-display').textContent = discountAmount.toFixed(2);
            document.getElementById('total-display').textContent = total.toFixed(2);

            document.getElementById('checkout-btn').disabled = Object.keys(cart).length === 0;
        }

        document.getElementById('discount_type').addEventListener('change', updateTotals);
        document.getElementById('discount_value').addEventListener('input', updateTotals);

        document.getElementById('sale-form').addEventListener('submit', function (e) {
            const ids = Object.keys(cart);
            if (ids.length === 0) {
                e.preventDefault();
                return;
            }

            const container = document.getElementById('hidden-items-container');
            container.innerHTML = '';

            ids.forEach(function (id, index) {
                const productInput = document.createElement('input');
                productInput.type = 'hidden';
                productInput.name = `items[${index}][product_id]`;
                productInput.value = id;
                container.appendChild(productInput);

                const qtyInput = document.createElement('input');
                qtyInput.type = 'hidden';
                qtyInput.name = `items[${index}][quantity]`;
                qtyInput.value = cart[id].quantity;
                container.appendChild(qtyInput);
            });

            const nameValue = document.getElementById('customer_name').value;
            const phoneValue = document.getElementById('customer_phone').value;

            const nameInput = document.createElement('input');
            nameInput.type = 'hidden';
            nameInput.name = 'customer_name';
            nameInput.value = nameValue;
            container.appendChild(nameInput);

            const phoneInput = document.createElement('input');
            phoneInput.type = 'hidden';
            phoneInput.name = 'customer_phone';
            phoneInput.value = phoneValue;
            container.appendChild(phoneInput);

            const btn = document.getElementById('checkout-btn');
            btn.disabled = true;
            btn.textContent = 'Processing...';
        });

        const completedSaleEl = document.getElementById('completed-sale-data');
        if (completedSaleEl) {
            const sale = JSON.parse(completedSaleEl.textContent);
            const itemsList = sale.items.map(function (item) {
                return item.product_name + ' ×' + item.quantity;
            }).join(', ');

            const cartItemsEl = document.getElementById('cart-items');
            cartItemsEl.innerHTML = `
                <div class="flex flex-col items-center text-center py-5">
                    <div class="w-11 h-11 rounded-full bg-paper border border-positive flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-positive" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-sm font-medium text-ink">Sale completed</p>
                    <p class="text-xs text-gray-500 mt-0.5">${itemsList}</p>
                    <p class="text-lg font-mono font-medium text-ink mt-2">${parseFloat(sale.total_amount).toFixed(2)}</p>
                    <p class="text-xs text-gray-400 mt-3">Ready for next sale...</p>
                </div>
            `;

            setTimeout(function () {
                renderCart();
            }, 2500);
        }
    </script>
</body>
</html>