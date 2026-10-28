
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports | InventoryPro</title>

    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            --bg: #f4f7fc;
            --card: #ffffff;
            --ink: #1e293b;
            --muted: #64748b;
            --line: #e2e8f0;
            --brand: #2563eb;
            --brand-soft: #eff6ff;
            --brand-ink: #1d4ed8;
            --purple: #7c3aed;
            --purple-soft: #f3e8ff;
            --red: #ef4444;
            --red-soft: #fee2e2;
            --radius: 16px;
            --shadow: 0 1px 2px rgba(30, 41, 59, .04),
                      0 6px 20px rgba(30, 41, 59, .04);
        }

        body {
            margin: 0;
            padding: 30px 22px;
            background: var(--bg);
            color: var(--ink);
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1150px;
            margin: 0 auto;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
        }

        h1 {
            margin: 0 0 7px;
            font-size: 27px;
            font-weight: 750;
        }

        .subtitle {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.5;
        }

        .top-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 9px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 11px 15px;
            border: 1px solid transparent;
            border-radius: 9px;
            text-decoration: none;
            cursor: pointer;
            font-family: Arial, sans-serif;
            font-size: 13px;
            font-weight: 700;
            white-space: nowrap;
            transition: background .15s ease, border-color .15s ease;
        }

        .primary {
            background: var(--brand);
            color: #fff;
        }

        .primary:hover {
            background: #1d4ed8;
        }

        .secondary {
            background: #fff;
            color: var(--ink);
            border-color: var(--line);
        }

        .secondary:hover {
            background: var(--brand-soft);
            border-color: #bfdbfe;
        }

        .logout-btn {
            background: var(--purple);
            color: #fff;
        }

        .logout-btn:hover {
            background: #6d28d9;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 22px;
            margin-bottom: 22px;
            box-shadow: var(--shadow);
        }

        .section-title {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 22px;
        }

        .stat {
            min-width: 0;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 21px;
            box-shadow: var(--shadow);
        }

        .stat-label {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 12px;
            line-height: 1.5;
        }

        .stat-value {
            font-size: 25px;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .report-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .report-card {
            min-width: 0;
            border: 1px solid var(--line);
            border-radius: 13px;
            padding: 20px;
            transition: border-color .2s, transform .2s;
            background: #fff;
        }

        .report-card:hover {
            border-color: #bfdbfe;
            transform: translateY(-2px);
        }

        .report-card h3 {
            margin: 0 0 9px;
            font-size: 16px;
        }

        .report-card p {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
            margin: 0 0 17px;
        }

        .report-link {
            display: inline-block;
            color: var(--brand-ink);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
        }

        .report-link:hover {
            text-decoration: underline;
        }

        .report-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            margin-bottom: 14px;
            border-radius: 10px;
            background: var(--brand-soft);
            color: var(--brand-ink);
            font-size: 19px;
            font-weight: 700;
        }

        .report-card:nth-child(even) .report-icon {
            background: var(--purple-soft);
            color: #6d28d9;
        }

        .footer-note {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.6;
            margin-top: 20px;
        }

        /* Centered logout confirmation */
        .modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(15, 23, 42, .55);
        }

        .modal-overlay.open {
            display: flex;
        }

        .modal {
            width: 100%;
            max-width: 410px;
            padding: 26px;
            border: 1px solid var(--line);
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 20px 60px rgba(15, 23, 42, .22);
        }

        .modal-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            margin-bottom: 16px;
            border-radius: 12px;
            background: var(--purple-soft);
            color: var(--purple);
            font-size: 22px;
            font-weight: 700;
        }

        .modal h2 {
            margin: 0 0 10px;
            font-size: 21px;
        }

        .modal p {
            margin: 0 0 22px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 9px;
        }

        @media (max-width: 850px) {
            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 600px) {
            body {
                padding: 18px 13px;
            }

            h1 {
                font-size: 24px;
            }

            .topbar {
                align-items: flex-start;
            }

            .top-actions {
                width: 100%;
            }

            .stats,
            .report-grid {
                grid-template-columns: 1fr;
            }

            .card {
                padding: 15px;
            }

            .modal {
                padding: 21px;
            }
        }
    </style>
</head>

<body>
<div class="container">

    <header class="topbar">
        <div>
            <h1>Reports</h1>
            <div class="subtitle">
                Inventory Management System · Reports &amp; Analytics
            </div>
        </div>

        <div class="top-actions">
            <a href="{{ route('dashboard') }}" class="btn secondary">
                ← Dashboard
            </a>

            <button type="button"
                    class="btn logout-btn"
                    data-logout-confirm>
                Logout
            </button>
        </div>
    </header>

    <section class="stats">
        <div class="stat">
            <div class="stat-label">Total Products</div>
            <div class="stat-value">
                {{ number_format($totalProducts) }}
            </div>
        </div>

        <div class="stat">
            <div class="stat-label">Low Stock Products</div>
            <div class="stat-value">
                {{ number_format($lowStockCount) }}
            </div>
        </div>

        <div class="stat">
            <div class="stat-label">Estimated Stock Value</div>
            <div class="stat-value">
                Rs. {{ number_format($totalStockValue, 2) }}
            </div>
        </div>

        <div class="stat">
            <div class="stat-label">Total Transactions</div>
            <div class="stat-value">
                {{ number_format($totalTransactions) }}
            </div>
        </div>
    </section>

    <section class="card">

        <div style="margin-bottom: 18px;">
            <h2 class="section-title">Available Reports</h2>
            <div class="subtitle" style="margin-top: 5px;">
                Choose a report to review your inventory.
            </div>
        </div>

        <div class="report-grid">

            <div class="report-card">
                <div class="report-icon">▤</div>
                <h3>Current Stock Report</h3>
                <p>
                    View products, categories, available quantities,
                    and minimum-stock levels.
                </p>
                <a href="{{ route('reports.stock') }}" class="report-link">
                    View Stock Report →
                </a>
            </div>

            <div class="report-card">
                <div class="report-icon">↔</div>
                <h3>Stock Transactions</h3>
                <p>
                    Review stock received and issued, with filters
                    for product and transaction date.
                </p>
                <a href="{{ route('reports.transactions') }}" class="report-link">
                    View Transactions →
                </a>
            </div>

            <div class="report-card">
                <div class="report-icon">▦</div>
                <h3>Inventory Valuation</h3>
                <p>
                    Review estimated inventory value using current
                    stock quantity and recorded purchase prices.
                </p>
                <a href="{{ route('reports.valuation') }}" class="report-link">
                    View Valuation →
                </a>
            </div>

            <div class="report-card">
                <div class="report-icon">!</div>
                <h3>Low Stock Report</h3>
                <p>
                    Find active products whose available stock has
                    reached or fallen below the minimum level.
                </p>
                <a href="{{ route('reports.low-stock') }}" class="report-link">
                    View Low Stock →
                </a>
            </div>

        </div>

        <div class="footer-note">
            Stock values are estimates based on recorded transactions
            and product purchase prices. Check transaction history
            before making inventory adjustments.
        </div>
    </section>

</div>

<!-- Logout confirmation modal -->
<div class="modal-overlay"
     id="logoutModal"
     aria-hidden="true">

    <div class="modal"
         role="dialog"
         aria-modal="true"
         aria-labelledby="logoutModalTitle"
         aria-describedby="logoutModalMessage">

        <div class="modal-icon">!</div>

        <h2 id="logoutModalTitle">Confirm Logout</h2>

        <p id="logoutModalMessage">
            Are you sure you want to log out of InventoryPro?
        </p>

        <div class="modal-actions">
            <button type="button"
                    class="btn secondary"
                    id="cancelLogout">
                Cancel
            </button>

            <button type="button"
                    class="btn logout-btn"
                    id="confirmLogout">
                Yes, Logout
            </button>
        </div>
    </div>
</div>

<form id="logoutForm"
      method="POST"
      action="{{ route('logout') }}"
      hidden>
    @csrf
</form>

<script>
    (function () {
        const modal = document.getElementById('logoutModal');
        const cancelButton = document.getElementById('cancelLogout');
        const confirmButton = document.getElementById('confirmLogout');
        const logoutForm = document.getElementById('logoutForm');
        const logoutButtons = document.querySelectorAll('[data-logout-confirm]');

        let lastFocusedElement = null;

        function openModal(event) {
            lastFocusedElement = event.currentTarget;
            modal.classList.add('open');
            modal.setAttribute('aria-hidden', 'false');
            cancelButton.focus();
        }

        function closeModal() {
            modal.classList.remove('open');
            modal.setAttribute('aria-hidden', 'true');

            if (lastFocusedElement) {
                lastFocusedElement.focus();
            }
        }

        logoutButtons.forEach(function (button) {
            button.addEventListener('click', openModal);
        });

        cancelButton.addEventListener('click', closeModal);

        confirmButton.addEventListener('click', function () {
            logoutForm.submit();
        });

        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && modal.classList.contains('open')) {
                closeModal();
            }
        });
    })();
</script>

</body>
</html>
