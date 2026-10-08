
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HBMS — simple, organized business management.">

    <title>HBMS | Business Management</title>

    <link href="https://fonts.bunny.net/css?family=fraunces:500,600,700|ibm-plex-sans:400,500,600,700&display=swap"
          rel="stylesheet">

    <style>
        :root {
            --paper: #f7f3eb;
            --ink: #202329;
            --ledger: #34465a;
            --green: #3f7d58;
            --hairline: #d9d2c6;
            --muted: #697078;
            --surface: #fffdf8;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--paper);
            color: var(--ink);
            font-family: 'IBM Plex Sans', sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        /* Simple header */

        header {
            padding: 25px 7%;
        }

        .logo {
            font-family: Fraunces, Georgia, serif;
            font-size: 25px;
            font-weight: 700;
            letter-spacing: -1px;
        }

        .logo span {
            color: var(--ledger);
        }

        /* Centered homepage */

        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 60px 24px 100px;
        }

        h1 {
            margin-bottom: 18px;
            font-family: Fraunces, Georgia, serif;
            font-size: clamp(42px, 7vw, 72px);
            font-weight: 600;
            letter-spacing: -2px;
        }

        h1 span {
            color: var(--ledger);
        }

        .slogan {
            max-width: 450px;
            margin-bottom: 36px;
            color: var(--muted);
            font-size: 17px;
            line-height: 1.7;
        }

        .buttons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 14px;
        }

        .button {
            min-width: 165px;
            padding: 15px 26px;
            border: 1px solid var(--ledger);
            border-radius: 6px;
            font-size: 15px;
            font-weight: 600;
            transition: 0.2s ease;
        }

        .button-demo {
            background: var(--ledger);
            color: white;
        }

        .button-demo:hover {
            background: var(--ink);
            border-color: var(--ink);
            transform: translateY(-2px);
        }

        .button-full {
            background: transparent;
            color: var(--ledger);
        }

        .button-full:hover {
            background: var(--surface);
            transform: translateY(-2px);
        }

        /* Footer */

        footer {
            padding: 24px 7%;
            border-top: 1px solid var(--hairline);
        }

        .footer-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 18px;
        }

        .copyright {
            color: var(--muted);
            font-size: 12px;
        }

        .footer-links {
            display: flex;
            flex-wrap: wrap;
            gap: 22px;
        }

        .footer-links a {
            color: var(--muted);
            font-size: 12px;
            transition: color 0.2s ease;
        }

        .footer-links a:hover {
            color: var(--ledger);
        }

        @media (max-width: 520px) {
            header {
                padding: 22px 6%;
            }

            main {
                padding: 50px 20px 75px;
            }

            h1 {
                letter-spacing: -1px;
            }

            .slogan {
                font-size: 15px;
            }

            .buttons {
                width: 100%;
                max-width: 300px;
                flex-direction: column;
            }

            .button {
                width: 100%;
            }

            footer {
                padding: 24px 6%;
            }

            .footer-inner {
                flex-direction: column;
                text-align: center;
            }

            .footer-links {
                justify-content: center;
                gap: 16px;
            }
        }
    </style>
</head>

<body>

    <header>
        <a href="#" class="logo">HB<span>MS</span></a>
    </header>

    <main>
        <h1>HB<span>MS</span></h1>

        <p class="slogan">
            Smarter management. Simpler operations.
        </p>

        <div class="buttons">
            <a href="/demo" class="button button-demo">
                Demo
            </a>

            <a href="/login" class="button button-full">
                Full Version
            </a>
        </div>
    </main>

    <footer>
        <div class="footer-inner">
            <p class="copyright">
                &copy; <span id="year"></span> HBMS. All rights reserved.
            </p>

            <nav class="footer-links" aria-label="Footer navigation">
                <a href="/privacy-policy">Privacy Policy</a>
                <a href="/terms">Terms &amp; Conditions</a>
                <a href="/contact">Contact</a>
            </nav>
        </div>
    </footer>

    <script>
        document.getElementById('year').textContent =
            new Date().getFullYear();
    </script>

</body>
</html>
