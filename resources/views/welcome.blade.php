<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Manage inventory, sales, expenses and reporting in one organized business system.">
    <title>HBMS | Hybrid Business Management System</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=fraunces:500,600,700|ibm-plex-sans:400,500,600,700|ibm-plex-mono:400,500&display=swap"
        rel="stylesheet"
    >
    <style>
        :root {
            color-scheme: light;
            --paper: #f7f3eb;
            --ink: #202329;
            --ledger: #34465a;
            --positive: #3f7d58;
            --negative: #a44d3f;
            --hairline: #d9d2c6;
            --surface: #fffdf8;
            --surface-muted: #eee9df;
            --muted: #697078;
            --shadow: 0 20px 54px rgb(32 35 41 / 8%);
        }
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background: var(--paper);
            color: var(--ink);
            font-family: 'IBM Plex Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        a:focus-visible {
            outline: 3px solid var(--positive);
            outline-offset: 3px;
        }

        .site {
            min-height: 100vh;
            overflow: hidden;
        }

        .wrap {
            width: min(1180px, calc(100% - 48px));
            margin-inline: auto;
        }

        .nav {
            min-height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .brand {
            flex: 0 0 auto;
            font-family: Fraunces, Georgia, serif;
            font-size: 22px;
            font-weight: 700;
        }

        .brand span {
            color: var(--ledger);
        }

        .nav-links,
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 26px;
        }

        .nav-links {
            color: var(--muted);
            font-size: 14px;
        }

        .nav-links a:hover,
        .footer a:hover {
            color: var(--ledger);
        }

        .nav-actions {
            gap: 10px;
        }

        .button {
            min-height: 42px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            border: 1px solid transparent;
            border-radius: 6px;
            padding: 10px 16px;
            font: 600 14px 'IBM Plex Sans', sans-serif;
            cursor: pointer;
            transition: transform 160ms ease, background-color 160ms ease;
        }

        .button:hover {
            transform: translateY(-1px);
        }

        .button-primary {
            background: var(--ink);
            color: var(--surface);
        }

        .button-primary:hover {
            background: var(--ledger);
        }

        .button-ledger {
            background: var(--ledger);
            color: white;
        }

        .button-ledger:hover {
            background: #26384a;
        }

        .button-soft {
            background: var(--surface-muted);
            color: var(--ink);
        }

        .button-soft:hover {
            background: #e4ded2;
        }

        .hero {
            padding: 40px 0 32px;
            text-align: center;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            border: 1px solid var(--hairline);
            border-radius: 999px;
            padding: 7px 12px;
            background: var(--surface);
            color: var(--muted);
            font-size: 12px;
            font-weight: 600;
        }

        .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--positive);
        }

        .hero h1 {
            max-width: 900px;
            margin: 22px auto 18px;
            font: 600 66px/1 Fraunces, Georgia, serif;
        }

        .hero h1 em {
            color: var(--ledger);
            font-style: normal;
        }

        .hero-copy {
            max-width: 680px;
            margin: 0 auto;
            color: var(--muted);
            font-size: 17px;
            line-height: 1.65;
        }

        .hero-actions {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin: 24px 0 30px;
        }

        .dashboard {
            max-width: 1030px;
            margin: 0 auto;
            border: 1px solid var(--hairline);
            border-radius: 8px;
            padding: 12px;
            background: var(--surface);
            box-shadow: var(--shadow);
            text-align: left;
            animation: arrive 550ms ease both;
        }

        .dashbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 10px 14px;
            font-weight: 600;
        }

        .status,
        .tag {
            border-radius: 999px;
            padding: 6px 9px;
            background: rgb(63 125 88 / 9%);
            color: var(--positive);
            font-size: 11px;
            font-weight: 600;
        }

        .dashgrid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 12px;
        }

        .panel {
            min-width: 0;
            border-radius: 6px;
            padding: 18px;
            background: var(--surface-muted);
        }

        .panel h2 {
            margin: 0 0 15px;
            font-size: 14px;
        }

        .numbers {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .metric {
            min-width: 0;
            border-radius: 5px;
            padding: 12px;
            background: var(--surface);
        }

        .metric small {
            color: var(--muted);
            font-size: 11px;
        }

        .metric b {
            display: block;
            margin-top: 4px;
            font: 500 20px 'IBM Plex Mono', monospace;
        }

        .chart {
            height: 82px;
            display: flex;
            align-items: end;
            gap: 7px;
            margin-top: 13px;
        }

        .bar {
            flex: 1;
            min-height: 12px;
            border-radius: 3px 3px 0 0;
            background: var(--ledger);
        }

        .stockrow {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid var(--hairline);
            padding: 9px 0;
            font-size: 12px;
        }

        .stockrow:last-child {
            border: 0;
        }

        .tag {
            flex: 0 0 auto;
            padding: 4px 7px;
        }

        .tag.warn {
            background: rgb(164 77 63 / 9%);
            color: var(--negative);
        }

        .section {
            padding: 72px 0;
        }

        .section-heading {
            max-width: 760px;
            margin: 0 auto 36px;
            text-align: center;
        }

        .section h2 {
            margin: 0 auto 14px;
            font: 600 44px/1.08 Fraunces, Georgia, serif;
        }

        .section-heading p {
            max-width: 640px;
            margin: 0 auto;
            color: var(--muted);
            line-height: 1.7;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        .card {
            min-height: 205px;
            border: 1px solid var(--hairline);
            border-radius: 6px;
            padding: 22px;
            background: var(--surface);
        }

        .icon {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            margin-bottom: 24px;
            border-radius: 6px;
            background: var(--surface-muted);
            color: var(--ledger);
            font-size: 19px;
        }

        .card h3 {
            margin: 0 0 8px;
            font-size: 17px;
        }

        .card p {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        .fifo {
            display: grid;
            grid-template-columns: 1fr 0.9fr;
            align-items: center;
            gap: 44px;
            overflow: hidden;
            border-radius: 8px;
            padding: 44px;
            background: var(--ledger);
            color: white;
        }

        .fifo .eyebrow {
            border-color: rgb(255 255 255 / 25%);
            background: rgb(255 255 255 / 8%);
            color: #e5e9ed;
        }

        .fifo h2 {
            margin: 20px 0 12px;
            font: 600 44px/1.05 Fraunces, Georgia, serif;
        }

        .fifo p {
            margin: 0 0 22px;
            color: #d8dde3;
            line-height: 1.7;
        }

        .queue {
            min-width: 0;
        }

        .sku {
            display: flex;
            align-items: center;
            gap: 11px;
            border-bottom: 1px solid rgb(255 255 255 / 15%);
            padding: 12px 0;
        }

        .cube {
            width: 32px;
            height: 32px;
            flex: 0 0 auto;
            display: grid;
            place-items: center;
            border-radius: 5px;
            background: rgb(255 255 255 / 12%);
            font: 500 12px 'IBM Plex Mono', monospace;
        }

        .sku b {
            font-size: 13px;
        }

        .sku small {
            display: block;
            margin-top: 3px;
            color: #c1c8d0;
            font-size: 11px;
        }

        .sku-status {
            margin-left: auto;
            color: #c8dfce;
            font: 500 11px 'IBM Plex Mono', monospace;
        }

        .insights {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .quote {
            min-height: 185px;
            border-radius: 6px;
            padding: 26px;
            background: var(--surface-muted);
        }

        .quote p {
            margin: 0 0 18px;
            font: 500 21px/1.4 Fraunces, Georgia, serif;
        }

        .quote small {
            color: var(--muted);
        }

        .plans {
            max-width: 820px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin: 0 auto;
        }

        .plan {
            border: 1px solid var(--hairline);
            border-radius: 6px;
            padding: 28px;
            background: var(--surface);
        }

        .plan.featured {
            border-color: var(--ledger);
            box-shadow: var(--shadow);
        }

        .plan h3 {
            margin: 0 0 8px;
            font: 600 22px Fraunces, Georgia, serif;
        }

        .plan p {
            min-height: 44px;
            margin: 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.55;
        }

        .plan ul {
            margin: 20px 0;
            padding: 0;
            list-style: none;
        }

        .plan li {
            padding: 7px 0;
            color: var(--muted);
            font-size: 14px;
        }

        .plan li::before {
            content: '✓';
            margin-right: 9px;
            color: var(--positive);
        }

        .plan .button {
            width: 100%;
        }

        .footer {
            border-top: 1px solid var(--hairline);
            padding: 42px 0 20px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.6fr repeat(3, 1fr);
            gap: 28px;
        }

        .footer h2 {
            margin: 0 0 12px;
            font-size: 14px;
        }

        .footer p,
        .footer a {
            display: block;
            margin: 8px 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.55;
        }

        .copyright {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            margin-top: 34px;
            border-top: 1px solid var(--hairline);
            padding-top: 16px;
            color: var(--muted);
            font-size: 12px;
        }

        @keyframes arrive {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @media (max-width: 800px) {
            .nav-links {
                display: none;
            }

            .dashgrid,
            .fifo {
                grid-template-columns: 1fr;
            }

            .features {
                grid-template-columns: repeat(2, 1fr);
            }

            .fifo {
                gap: 24px;
                padding: 30px;
            }

            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .hero {
                padding-top: 30px;
            }

            .hero h1 {
                font-size: 54px;
            }

            .section h2,
            .fifo h2 {
                font-size: 38px;
            }
        }

        @media (max-width: 540px) {
            .wrap {
                width: min(calc(100% - 32px), 1180px);
            }

            .nav {
                min-height: 62px;
                gap: 12px;
            }

            .nav-actions {
                gap: 6px;
            }

            .nav-actions .button {
                min-height: 38px;
                padding: 8px 10px;
                font-size: 12px;
            }

            .brand {
                font-size: 20px;
            }

            .hero {
                padding: 28px 0 22px;
            }

            .hero h1 {
                margin-top: 18px;
                font-size: 42px;
            }

            .hero-copy {
                font-size: 15px;
            }

            .hero-actions {
                margin: 20px 0 22px;
            }

            .dashboard {
                padding: 8px;
            }

            .dashbar {
                padding: 7px 5px 11px;
                font-size: 13px;
            }

            .panel {
                padding: 13px;
            }

            .numbers {
                gap: 6px;
            }

            .metric {
                padding: 9px 7px;
            }

            .metric small {
                font-size: 10px;
            }

            .metric b {
                font-size: 15px;
            }

            .stockrow {
                font-size: 11px;
            }

            .section {
                padding: 52px 0;
            }

            .section h2,
            .fifo h2 {
                font-size: 34px;
            }

            .features,
            .insights,
            .plans {
                grid-template-columns: 1fr;
            }

            .card {
                min-height: 0;
            }

            .fifo {
                padding: 24px 20px;
            }

            .quote {
                min-height: 0;
            }

            .plan {
                padding: 22px;
            }

            .footer-grid {
                gap: 20px 14px;
            }

            .copyright {
                display: block;
                line-height: 1.7;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>
<body>
    <main class="site" id="top">
        <header class="wrap nav">
            <a class="brand" href="#top" aria-label="HBMS home">HB<span>MS</span></a>

            <nav class="nav-links" aria-label="Main navigation">
                <a href="#features">Features</a>
                <a href="#fifo">FIFO stock</a>
                <a href="#insights">Insights</a>
                <a href="#plans">Access</a>
            </nav>

            <div class="nav-actions">
                @auth
                    <a
                        class="button button-ledger"
                        href="{{ auth()->user()->role === 'staff' ? route('sales.index') : route('dashboard') }}"
                    >
                        Open workspace
                    </a>
                @else
                    <a class="button button-soft" href="{{ route('login') }}">Log in</a>
                    @if (Route::has('register'))
                        <a class="button button-ledger" href="{{ route('register') }}">Get started</a>
                    @endif
                @endauth
            </div>
        </header>

        <section class="wrap hero" aria-labelledby="hero-title">
            <span class="eyebrow">
                <i class="dot" aria-hidden="true"></i>
                Built for small and growing businesses
            </span>
            <h1 id="hero-title">Run the business.<br><em>Not the paperwork.</em></h1>
            <p class="hero-copy">
                A hybrid business management system for inventory, sales, expenses and reporting,
                bringing everyday workflows into one organized digital space.
            </p>
            <div class="hero-actions">
                @auth
                    <a
                        class="button button-primary"
                        href="{{ auth()->user()->role === 'staff' ? route('sales.index') : route('dashboard') }}"
                    >
                        Explore the workspace <span aria-hidden="true">→</span>
                    </a>
                @else
                    <a class="button button-primary" href="{{ route('login') }}">
                        Explore the workspace <span aria-hidden="true">→</span>
                    </a>
                @endauth
                <a class="button button-ledger" href="{{ route('register') }}">Get started</a>
            </div>

            <section class="dashboard" aria-label="Illustrative business dashboard preview">
                <div class="dashbar">
                    <span>Business overview</span>
                    <span class="status">Preview data</span>
                </div>
                <div class="dashgrid">
                    <div class="panel">
                        <h2>Business performance</h2>
                        <div class="numbers">
                            <div class="metric"><small>Sales today</small><b>£4,820</b></div>
                            <div class="metric"><small>Expenses</small><b>£1,260</b></div>
                            <div class="metric"><small>Profit</small><b>£3,560</b></div>
                        </div>
                        <div class="chart" role="img" aria-label="Illustrative weekly sales chart">
                            <span class="bar" style="height: 35%"></span>
                            <span class="bar" style="height: 52%"></span>
                            <span class="bar" style="height: 44%"></span>
                            <span class="bar" style="height: 68%"></span>
                            <span class="bar" style="height: 58%"></span>
                            <span class="bar" style="height: 82%"></span>
                            <span class="bar" style="height: 72%"></span>
                            <span class="bar" style="height: 94%"></span>
                        </div>
                    </div>
                    <div class="panel">
                        <h2>Inventory</h2>
                        <div class="stockrow"><span>Product A · 48 units</span><span class="tag">Healthy</span></div>
                        <div class="stockrow"><span>Product B · 12 units</span><span class="tag warn">Low stock</span></div>
                        <div class="stockrow"><span>Product C · 76 units</span><span class="tag">Healthy</span></div>
                        <div class="stockrow"><span>Product D · 5 units</span><span class="tag warn">Low stock</span></div>
                    </div>
                </div>
            </section>
        </section>

        <section class="wrap section" id="features">
            <div class="section-heading">
                <h2>Everything your operation needs, in one place.</h2>
                <p>Replace scattered paperwork with organized digital records while keeping familiar business workflows at the center.</p>
            </div>
            <div class="features">
                <article class="card">
                    <div class="icon" aria-hidden="true">▣</div>
                    <h3>Inventory control</h3>
                    <p>Add and update stock, monitor quantities, and automatically adjust inventory when sales are recorded.</p>
                </article>
                <article class="card">
                    <div class="icon" aria-hidden="true">↗</div>
                    <h3>Sales tracking</h3>
                    <p>Record sales in one place and turn transactions into useful daily and weekly performance summaries.</p>
                </article>
                <article class="card">
                    <div class="icon" aria-hidden="true">£</div>
                    <h3>Expense monitoring</h3>
                    <p>Keep operating costs organized alongside sales to understand the relationship between earnings and expenses.</p>
                </article>
                <article class="card">
                    <div class="icon" aria-hidden="true">◎</div>
                    <h3>Customer management</h3>
                    <p>Keep customer information structured and accessible as part of your everyday sales workflow.</p>
                </article>
                <article class="card">
                    <div class="icon" aria-hidden="true">⌁</div>
                    <h3>Business reporting</h3>
                    <p>Review daily, weekly, monthly and yearly performance without rebuilding the numbers by hand.</p>
                </article>
                <article class="card">
                    <div class="icon" aria-hidden="true">▤</div>
                    <h3>Centralized records</h3>
                    <p>Keep business records in a database-backed system instead of relying entirely on paper documents.</p>
                </article>
            </div>
        </section>

        <section class="wrap section" id="fifo">
            <div class="fifo">
                <div>
                    <span class="eyebrow">Inventory intelligence</span>
                    <h2>FIFO stock.<br>Less guesswork.</h2>
                    <p>
                        Structure inventory movement around a first-in, first-out workflow so older stock is used first.
                        Track stock batches and bring more clarity to product costs.
                    </p>
                    @auth
                        <a
                            class="button button-soft"
                            href="{{ auth()->user()->role === 'staff' ? route('sales.index') : route('stock.index') }}"
                        >
                            Open inventory <span aria-hidden="true">→</span>
                        </a>
                    @else
                        <a class="button button-soft" href="{{ route('login') }}">
                            Explore the system <span aria-hidden="true">→</span>
                        </a>
                    @endauth
                </div>
                <div class="queue" aria-label="Illustrative stock batch order">
                    <div class="sku">
                        <span class="cube">01</span>
                        <span><b>Batch A</b><small>Received first · 18 units</small></span>
                        <span class="sku-status">Next</span>
                    </div>
                    <div class="sku">
                        <span class="cube">02</span>
                        <span><b>Batch B</b><small>Received second · 32 units</small></span>
                        <span class="sku-status">Queued</span>
                    </div>
                    <div class="sku">
                        <span class="cube">03</span>
                        <span><b>Batch C</b><small>Received latest · 50 units</small></span>
                        <span class="sku-status">Queued</span>
                    </div>
                    <div class="sku">
                        <span class="cube">!</span>
                        <span><b>Stock to review</b><small>Check the current quantity</small></span>
                        <span class="sku-status">Flagged</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="wrap section" id="insights">
            <div class="section-heading">
                <h2>From raw records to useful insight.</h2>
                <p>Understand profitability, popular products and stock movement with clear operational summaries.</p>
            </div>
            <div class="insights">
                <article class="quote">
                    <p>“Know what sold, what it cost, what remains, and what deserves attention.”</p>
                    <small>Daily and weekly business summaries</small>
                </article>
                <article class="quote">
                    <p>Spot popular products and review stock patterns without digging through paperwork.</p>
                    <small>Operational visibility</small>
                </article>
            </div>
        </section>

        <section class="wrap section" id="plans">
            <div class="section-heading">
                <h2>Get your business moving.</h2>
                <p>Sign in to continue, or create the initial administrator account to set up your workspace.</p>
            </div>
            <div class="plans">
                <article class="plan">
                    <h3>Returning user</h3>
                    <p>Continue to your business workspace and manage your daily operations.</p>
                    <ul>
                        <li>Inventory and stock movements</li>
                        <li>Sales and customer records</li>
                        <li>Expenses and reporting</li>
                    </ul>
                    <a class="button button-primary" href="{{ route('login') }}">Log in</a>
                </article>
                <article class="plan featured">
                    <h3>New workspace</h3>
                    <p>Set up an administrator account to start organizing your business records.</p>
                    <ul>
                        <li>Products and stock tracking</li>
                        <li>Sales and expenses</li>
                        <li>Business performance reports</li>
                    </ul>
                    <a class="button button-ledger" href="{{ route('register') }}">Create account</a>
                </article>
            </div>
        </section>

        <footer class="footer">
            <div class="wrap">
                <div class="footer-grid">
                    <div>
                        <a class="brand" href="#top">HB<span>MS</span></a>
                        <p>A practical digital backbone for inventory, sales, expenses and business reporting.</p>
                    </div>
                    <div>
                        <h2>Product</h2>
                        <a href="#features">Features</a>
                        <a href="#fifo">FIFO stock</a>
                        <a href="#insights">Reports</a>
                    </div>
                    <div>
                        <h2>Workspace</h2>
                        <a href="{{ route('login') }}">Log in</a>
                        <a href="{{ route('register') }}">Create account</a>
                    </div>
                    <div>
                        <h2>Explore</h2>
                        <a href="#plans">Get started</a>
                        <a href="#top">Back to top</a>
                    </div>
                </div>
                <div class="copyright">
                    <span>© {{ now()->year }} HBMS. All rights reserved.</span>
                    <span>Designed for clearer business operations.</span>
                </div>
            </div>
        </footer>
    </main>
</body>
</html>
</main>
</body>
</html>