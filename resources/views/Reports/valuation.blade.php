
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Valuation Report | InventoryPro</title>

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
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
        }

        h1 {
            margin: 0 0 7px;
            font-size: 27px;
            font-weight: 750;
        }

        .subtitle,
        .muted {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.5;
        }

        .top-actions,
        .actions {
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
            transition: .2s ease;
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
            box-shadow: var(--shadow);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 18px;
        }

        .card-header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
        }

        .card-subtitle {
            margin-top: 6px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .summary {
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #bfdbfe;
            border-radius: 12px;
            background: var(--brand-soft);
        }

        .summary-label {
            margin-bottom: 8px;
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
        }

        .summary-value {
            color: var(--brand-ink);
            font-size: 27px;
            font-weight: 750;
            overflow-wrap: anywhere;
        }

        .summary-note {
            margin-top: 8px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 750px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 15px 12px;
            border-bottom: 1px solid var(--line);
            text-align: left;
            font-size: 14px;
            vertical-align: middle;
        }

        th {
            background: #f8fafc;
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .35px;
        }

        td.numeric,
        th.numeric {
            text-align: right;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #fafcff;
        }

        tfoot td {
            background: #f8fafc;
            font-weight: 700;
            border-top: 1px solid var(--line);
            border-bottom: none;
        }

        .empty {
            padding: 35px 18px;
            color: var(--muted);
            text-align: center;
        }

        .pagination {
            margin-top: 18px;
        }

        .note {
            margin: 18px 0 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.7;
        }

        /* Logout confirmation modal — same as Categories */

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
            box-shadow: 0 20px 60px rgba(15, 23, 42, .2);
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

            .card {
                padding: 15px;
            }

            .card-header {
                align-items: flex-start;
            }

            .summary {
                padding: 16px;
            }

            .summary-value {
                font-size: 22px;
            }

            .pagination {
                display: flex;
                flex-direction: column;
                gap: 10px;
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
            <h1>Inventory Valuation</h1>
            <div class="subtitle">
                Estimated inventory value based on recorded purchase prices
            </div>
        </div>

        <div class="top-actions">
            <a href="{{ route('reports.index') }}" class="btn secondary">
                ← Reports
            </a>

            <a href="{{ route('dashboard') }}" class="btn secondary">
                ← Dashboard
            </a>

            <button type="button" class="btn logout-btn" data-logout-confirm>
                Logout
            </button>
        </div>
    </header>

    <section class="card">

        <div class="card-header">
            <div>
                <h2>Product Valuation</h2>
                <div class="card-subtitle">
                    Purchase-price valuation of the products on the current page.
                </div>
            </div>
        </div>

        <div class="summary">
            <div class="summary-label">
                Estimated Value of Products on This Page
            </div>

            <div class="summary-value">
                Rs. {{ number_format($products->getCollection()->sum('stock_value'), 2) }}
            </div>

            <div class="summary-note">
                The figure above covers the current page only.
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th class="numeric">Purchase Price</th>
                        <th class="numeric">Current Quantity</th>
                        <th class="numeric">Estimated Value</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            <strong>{{ $product->name }}</strong>
                        </td>

                        <td>{{ $product->sku }}</td>

                        <td>
                            {{ $product->category?->name ?? 'Unassigned' }}
                        </td>

                        <td class="numeric">
                            Rs. {{ number_format((float) $product->purchase_price, 2) }}
                        </td>

                        <td class="numeric">
                            {{ number_format($product->current_stock) }}
                        </td>

                        <td class="numeric">
                            <strong>
                                Rs. {{ number_format($product->stock_value, 2) }}
                            </strong>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty">
                            No products found.
                        </td>
                    </tr>
                @endforelse
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="5">Current Page Total</td>

                        <td class="numeric">
                            Rs. {{ number_format($products->getCollection()->sum('stock_value'), 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="pagination">
            {{ $products->links() }}
        </div>

        <p class="note">
            Valuation formula: current stock quantity × recorded purchase price.
            This is an estimate, not a complete accounting valuation. The total
            shown here is for the current page; change pages to view other products.
        </p>

    </section>
</div>

<!-- Logout Confirmation Modal -->
<div
    class="modal-overlay"
    id="logoutModal"
    aria-hidden="true"
>
    <div
        class="modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="logoutModalTitle"
        aria-describedby="logoutModalDescription"
    >
        <div class="modal-icon">!</div>

        <h2 id="logoutModalTitle">Confirm Logout</h2>

        <p id="logoutModalDescription">
            Are you sure you want to log out of your account?
        </p>

        <div class="modal-actions">
            <button type="button" class="btn secondary" id="cancelLogout">
                Cancel
            </button>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn logout-btn">
                    Yes, Logout
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    (function () {
        const modal = document.getElementById('logoutModal');
        const logoutButton = document.querySelector('[data-logout-confirm]');
        const cancelButton = document.getElementById('cancelLogout');

        if (!modal || !logoutButton || !cancelButton) {
            return;
        }

        function openModal() {
            modal.classList.add('open');
            modal.setAttribute('aria-hidden', 'false');
            cancelButton.focus();
        }

        function closeModal() {
            modal.classList.remove('open');
            modal.setAttribute('aria-hidden', 'true');
            logoutButton.focus();
        }

        logoutButton.addEventListener('click', openModal);
        cancelButton.addEventListener('click', closeModal);

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
