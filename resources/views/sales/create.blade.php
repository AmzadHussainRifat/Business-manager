<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sales</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        button { -webkit-tap-highlight-color: transparent; }
    </style>
</head>
<body class="font-sans antialiased">

    <div class="bg-gray-50" style="height: 100vh; overflow: hidden;">
        <div class="w-full px-6 h-full flex flex-col py-4 box-border">

            <div class="flex items-center gap-3 mb-3 shrink-0">
                <button
                    type="button"
                    id="drawer-toggle"
                    aria-expanded="false"
                    aria-controls="drawer-panel"
                    class="flex items-center justify-center w-11 h-11 shrink-0 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 text-gray-500"
                    aria-label="More options"
                >
                    <span aria-hidden="true" class="text-lg leading-none">&#9776;</span>
                </button>

                <div class="flex-1 min-h-[44px] border border-gray-200 rounded-lg shadow-sm bg-white flex items-center px-3">
                    <label for="product-search" class="sr-only">Search products</label>
                    <input
                        type="search"
                        id="product-search"
                        placeholder="Search in products..."
                        class="flex-1 border-0 focus:ring-0 p-0 text-sm"
                    >
                    <span class="text-sm text-gray-500 whitespace-nowrap select-none pointer-events-none pl-3">
                        Welcome, <span class="font-medium text-gray-900">{{ auth()->user()->name }}</span>
                    </span>
                </div>
            </div>

            <div id="drawer-backdrop" class="hidden fixed inset-0 bg-black/30 z-40"></div>

            <div
                id="drawer-panel"
                class="fixed left-0 top-0 z-50 h-screen w-64 bg-white border-r border-gray-200 shadow-lg pt-6 px-3 pb-3 flex flex-col transition-transform duration-200 -translate-x-full"
            >
                <p class="font-medium text-gray-900 mb-4 px-2">Menu</p>

                <a href="{{ route('sales.history') }}" class="flex items-center gap-3 px-3 py-3 min-h-[44px] rounded-lg hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 text-sm font-medium text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px] text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Sale History
                </a>
                <div class="border-t border-gray-100 my-1"></div>

                <a href="{{ route('stock.index') }}" class="flex items-center gap-3 px-3 py-3 min-h-[44px] rounded-lg hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 text-sm font-medium text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px] text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Stock Level
                </a>
                <div class="border-t border-gray-100 my-1"></div>

                <div class="flex-1"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 min-h-[44px] rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 text-sm font-medium" style="background-color:#dc2626; color:#fecaca;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-[16px] h-[16px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Log out
                    </button>
                </form>
            </div>

            @if($errors->any())
                <div class="mb-3 p-3 bg-red-100 text-red-800 rounded-lg shadow-sm shrink-0" role="alert">
                    @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            @endif

            <div class="flex-1 min-h-0 flex gap-6 items-stretch flex-col lg:flex-row">

                <div class="w-full lg:w-[70%] min-w-0 flex flex-col bg-white border border-gray-200 rounded-xl shadow-sm p-5 min-h-0">

                    <div class="flex gap-2 pb-4 mb-4 border-b border-gray-100 overflow-x-auto shrink-0">
                        <button
                            type="button"
                            class="category-btn transition-none px-4 py-2 min-h-[36px] rounded-full font-medium whitespace-nowrap focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 bg-blue-600 text-white text-sm"
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
                                    class="product-tile transition-none aspect-square flex flex-col items-center justify-center text-center p-2 bg-white border border-gray-200 rounded-lg shadow-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}"
                                    data-price="{{ $product->selling_price }}"
                                    data-stock="{{ $product->quantity }}"
                                    aria-label="Add {{ $product->name }}, {{ number_format($product->selling_price, 2) }}"
                                >
                                    <span class="block font-semibold text-gray-900 text-xs leading-snug">{{ $product->name }}</span>
                                    <span class="block text-xs text-blue-600 font-medium mt-1">{{ number_format($product->selling_price, 2) }}</span>
                                </button>
                            @empty
                                <p class="col-span-full text-gray-500 py-8 text-center">No products available to sell right now.</p>
                            @endforelse
                        </div>
                    </div>

                </div>

                <div class="w-full lg:w-[30%] min-w-0 shrink-0 flex flex-col bg-white border border-gray-200 rounded-xl shadow-sm p-5 min-h-0">
                    <h2 class="font-semibold text-lg mb-3 shrink-0">Current Sale</h2>

                    <div id="cart-items" aria-live="polite" class="flex-1 min-h-0 overflow-y-auto space-y-2 mb-3">
                        <p id="cart-empty-msg" class="text-sm text-gray-400 py-6 text-center">No items added yet.</p>
                    </div>

                    <div class="mb-3 border border-gray-200 rounded-lg p-3 shrink-0" id="customer-info-panel">
                        <div class="flex justify-between items-center">
                            <button type="button" id="customer-info-toggle" class="font-medium text-sm min-h-[44px] flex items-center focus:outline-none">Customer info (optional)</button>
                            <button type="button" id="customer-info-close" aria-label="Collapse customer info" class="hidden w-8 h-8 items-center justify-center rounded-lg hover:bg-gray-100 text-gray-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div id="customer-info-body" class="hidden mt-3 space-y-2">
                            <div>
                                <label for="customer_name" class="block text-xs text-gray-500 mb-1">Name</label>
                                <input type="text" id="customer_name" name="customer_name" class="w-full border border-gray-200 rounded-lg p-2 min-h-[44px]">
                            </div>
                            <div>
                                <label for="customer_phone" class="block text-xs text-gray-500 mb-1">Phone</label>
                                <input type="text" id="customer_phone" name="customer_phone" class="w-full border border-gray-200 rounded-lg p-2 min-h-[44px]">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 border border-gray-200 rounded-lg p-3 shrink-0">
                        <p class="font-medium mb-2 text-xs text-gray-500 uppercase tracking-wide">Discount</p>
                        <div class="flex gap-2">
                            <select id="discount_type" name="discount_type" class="border border-gray-200 rounded-lg p-2 min-h-[44px] flex-1 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                                <option value="">None</option>
                                <option value="flat">Flat</option>
                                <option value="percent">%</option>
                            </select>
                            <input type="number" step="0.01" min="0" id="discount_value" name="discount_value" value="0" class="border border-gray-200 rounded-lg p-2 min-h-[44px] w-24 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                        </div>
                    </div>

                    <div class="mb-3 text-sm space-y-1.5 bg-gray-50 rounded-lg p-3 shrink-0" aria-live="polite">
                        <div class="flex justify-between text-gray-600"><span>Subtotal</span><span id="subtotal-display">0.00</span></div>
                        <div class="flex justify-between text-gray-600"><span>Discount</span><span id="discount-display">0.00</span></div>
                        <div class="flex justify-between font-semibold text-base pt-1.5 border-t border-gray-200"><span>Total</span><span id="total-display">0.00</span></div>
                    </div>

                    <form id="sale-form" action="{{ route('sales.store') }}" method="POST" class="shrink-0">
                        @csrf
                        <div id="hidden-items-container"></div>
                        <button
                            type="submit"
                            id="checkout-btn"
                            disabled
                            class="w-full px-4 py-4 min-h-[44px] bg-blue-600 text-white font-semibold rounded-lg shadow-sm hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
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

        const drawerToggle = document.getElementById('drawer-toggle');
        const drawerPanel = document.getElementById('drawer-panel');
        const drawerBackdrop = document.getElementById('drawer-backdrop');

        function openDrawer() {
            drawerPanel.classList.remove('-translate-x-full');
            drawerBackdrop.classList.remove('hidden');
            drawerToggle.setAttribute('aria-expanded', 'true');
        }

        function closeDrawer() {
            drawerPanel.classList.add('-translate-x-full');
            drawerBackdrop.classList.add('hidden');
            drawerToggle.setAttribute('aria-expanded', 'false');
        }

        drawerToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            const expanded = this.getAttribute('aria-expanded') === 'true';
            expanded ? closeDrawer() : openDrawer();
        });

        drawerBackdrop.addEventListener('click', closeDrawer);

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
                    b.classList.remove('bg-blue-600', 'text-white');
                    b.classList.add('bg-white', 'text-gray-600', 'border', 'border-gray-200');
                    b.setAttribute('aria-pressed', 'false');
                });
                this.classList.remove('bg-white', 'text-gray-600', 'border', 'border-gray-200');
                this.classList.add('bg-blue-600', 'text-white');
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
                    row.className = 'border border-gray-100 rounded-lg p-3';
                    row.innerHTML = `
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="text-sm font-medium text-gray-900">${item.name}</p>
                                <p class="text-xs text-gray-500">${item.price.toFixed(2)} × ${item.quantity} = <span class="text-blue-600 font-medium">${lineTotal}</span></p>
                            </div>
                            <button type="button" aria-label="Remove ${item.name} from cart" class="w-8 h-8 min-w-[36px] min-h-[36px] flex items-center justify-center text-red-500 hover:bg-red-50 rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500" onclick="removeFromCart('${id}')">&times;</button>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" aria-label="Decrease quantity of ${item.name}" class="w-9 h-9 min-w-[44px] min-h-[44px] flex items-center justify-center bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500" onclick="changeQuantity('${id}', -1)">−</button>
                            <span class="w-6 text-center text-sm font-medium">${item.quantity}</span>
                            <button type="button" aria-label="Increase quantity of ${item.name}" class="w-9 h-9 min-w-[44px] min-h-[44px] flex items-center justify-center bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500" onclick="changeQuantity('${id}', 1)">+</button>
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
                    <div class="w-11 h-11 rounded-full bg-green-100 flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-sm font-medium text-gray-900">Sale completed</p>
                    <p class="text-xs text-gray-500 mt-0.5">${itemsList}</p>
                    <p class="text-lg font-medium text-gray-900 mt-2">${parseFloat(sale.total_amount).toFixed(2)}</p>
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