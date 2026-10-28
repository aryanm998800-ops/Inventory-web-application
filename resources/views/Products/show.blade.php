
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details | InventoryPro</title>

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
            font-family: Arial, sans-serif;
            background: var(--bg);
            color: var(--ink);
        }

        .container {
            max-width: 1000px;
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

        h2 {
            margin: 0;
            font-size: 19px;
            font-weight: 700;
        }

        .subtitle {
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
            font-family: Arial, sans-serif;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
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
            padding: 24px;
            margin-bottom: 20px;
            box-shadow: var(--shadow);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            padding-bottom: 18px;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--line);
        }

        .product-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .product-heading h2 {
            overflow-wrap: anywhere;
        }

        .details {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .detail {
            min-width: 0;
            padding: 15px;
            background: #f8fafc;
            border: 1px solid var(--line);
            border-radius: 10px;
        }

        .detail-label {
            margin-bottom: 8px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .35px;
        }

        .detail-value {
            font-size: 15px;
            font-weight: 700;
            line-height: 1.6;
            overflow-wrap: anywhere;
            white-space: pre-wrap;
        }

        .full {
            grid-column: 1 / -1;
        }

        .badge {
            display: inline-block;
            padding: 6px 9px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .badge-active {
            background: #dcfce7;
            color: #166534;
        }

        .badge-inactive {
            background: #f1f5f9;
            color: #475569;
        }

        .edit {
            background: var(--purple-soft);
            color: #6d28d9;
        }

        .edit:hover {
            background: #e9d5ff;
        }

        .actions {
            margin-top: 22px;
            padding-top: 20px;
            border-top: 1px solid var(--line);
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
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

        tbody tr:last-child td {
            border-bottom: 0;
        }

        tbody tr:hover {
            background: #fafcff;
        }

        .transaction-in {
            display: inline-block;
            padding: 6px 9px;
            border-radius: 20px;
            background: #dcfce7;
            color: #166534;
            font-size: 12px;
            font-weight: 700;
        }

        .transaction-out {
            display: inline-block;
            padding: 6px 9px;
            border-radius: 20px;
            background: var(--red-soft);
            color: #b91c1c;
            font-size: 12px;
            font-weight: 700;
        }

        .empty {
            padding: 28px 12px;
            color: var(--muted);
            text-align: center;
        }

        /* Logout confirmation modal */

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

            .topbar {
                align-items: flex-start;
            }

            .top-actions {
                width: 100%;
            }

            h1 {
                font-size: 24px;
            }

            .card {
                padding: 17px;
            }

            .details {
                grid-template-columns: 1fr;
            }

            .full {
                grid-column: auto;
            }

            .card-header {
                align-items: flex-start;
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
            <h1>Product Details</h1>
            <div class="subtitle">
                InventoryPro · View product information
            </div>
        </div>

        <div class="top-actions">
            <a href="{{ route('products.index') }}" class="btn secondary">
                &larr; Back to Products
            </a>

            <button
                type="button"
                class="btn logout-btn"
                data-logout-confirm
            >
                Logout
            </button>
        </div>
    </header>

    <section class="card">

        <div class="card-header">
            <div class="product-heading">
                <div>
                    <h2>{{ $product->name }}</h2>
                    <div class="subtitle" style="margin-top: 6px;">
                        SKU: {{ $product->sku }}
                    </div>
                </div>
            </div>

            @if ($product->is_active)
                <span class="badge badge-active">Active</span>
            @else
                <span class="badge badge-inactive">Inactive</span>
            @endif
        </div>

        <div class="details">

            <div class="detail">
                <div class="detail-label">Product Name</div>
                <div class="detail-value">{{ $product->name }}</div>
            </div>

            <div class="detail">
                <div class="detail-label">Category</div>
                <div class="detail-value">
                    {{ $product->category?->name ?? '—' }}
                </div>
            </div>

            <div class="detail">
                <div class="detail-label">SKU</div>
                <div class="detail-value">{{ $product->sku }}</div>
            </div>

            <div class="detail">
                <div class="detail-label">Barcode</div>
                <div class="detail-value">{{ $product->barcode ?: '—' }}</div>
            </div>

            <div class="detail">
                <div class="detail-label">Unit</div>
                <div class="detail-value">{{ ucfirst($product->unit) }}</div>
            </div>

            <div class="detail">
                <div class="detail-label">Minimum Stock</div>
                <div class="detail-value">
                    {{ $product->minimum_stock }} {{ $product->unit }}
                </div>
            </div>

            <div class="detail">
                <div class="detail-label">Purchase Price</div>
                <div class="detail-value">
                    Rs. {{ number_format((float) $product->purchase_price, 2) }}
                </div>
            </div>

            <div class="detail">
                <div class="detail-label">Sale Price</div>
                <div class="detail-value">
                    Rs. {{ number_format((float) $product->sale_price, 2) }}
                </div>
            </div>

            <div class="detail">
                <div class="detail-label">Price Difference</div>
                <div class="detail-value">
                    Rs. {{ number_format((float) $product->sale_price - (float) $product->purchase_price, 2) }}
                </div>
            </div>

            <div class="detail">
                <div class="detail-label">Created On</div>
                <div class="detail-value">
                    {{ $product->created_at?->format('d M Y, h:i A') ?? '—' }}
                </div>
            </div>

            <div class="detail full">
                <div class="detail-label">Description</div>
                <div class="detail-value" style="font-weight: 400;">
                    {{ $product->description ?: 'No description provided.' }}
                </div>
            </div>

        </div>

        <div class="actions">
            <a href="{{ route('products.edit', $product) }}" class="btn edit">
                Edit Product
            </a>

            <a href="{{ route('products.index') }}" class="btn secondary">
                Back to Products
            </a>
        </div>

    </section>

    <section class="card">

        <div class="card-header">
            <div>
                <h2>Stock Transaction History</h2>
                <div class="subtitle" style="margin-top: 6px;">
                    Stock movements recorded for this product.
                </div>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Unit Cost</th>
                        <th>Reference</th>
                        <th>Recorded By</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($product->stockTransactions as $transaction)
                        <tr>
                            <td>
                                {{ $transaction->transaction_date
                                    ? \Illuminate\Support\Carbon::parse($transaction->transaction_date)->format('d M Y')
                                    : '—' }}
                            </td>

                            <td>
                                @if ($transaction->type === 'in')
                                    <span class="transaction-in">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                @else
                                    <span class="transaction-out">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                {{ $transaction->quantity }} {{ $product->unit }}
                            </td>

                            <td>
                                {{ $transaction->unit_cost !== null
                                    ? 'Rs. ' . number_format((float) $transaction->unit_cost, 2)
                                    : '—' }}
                            </td>

                            <td>
                                {{ $transaction->reference_number ?: '—' }}
                            </td>

                            <td>
                                {{ $transaction->user?->name ?? '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty">
                                No stock transactions have been recorded for this product yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

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
        <div class="modal-icon">↗</div>

        <h2 id="logoutModalTitle">Logout?</h2>

        <p id="logoutModalDescription">
            Are you sure you want to log out of InventoryPro?
            You will need to sign in again to access your account.
        </p>

        <div class="modal-actions">
            <button
                type="button"
                class="btn secondary"
                data-logout-cancel
            >
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
(() => {
    const modal = document.getElementById('logoutModal');
    const openButton = document.querySelector('[data-logout-confirm]');
    const cancelButton = document.querySelector('[data-logout-cancel]');

    if (!modal || !openButton || !cancelButton) {
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
        openButton.focus();
    }

    openButton.addEventListener('click', openModal);
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
