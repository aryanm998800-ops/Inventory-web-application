
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Transactions Report | InventoryPro</title>

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
        .actions,
        .filter-actions {
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
            margin-bottom: 20px;
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

        .filters {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            align-items: end;
        }

        .field {
            min-width: 0;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 700;
            color: var(--ink);
        }

        input,
        select {
            width: 100%;
            min-width: 0;
            padding: 12px 13px;
            border: 1px solid #d7e2ec;
            border-radius: 9px;
            background: #fff;
            color: var(--ink);
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        input:focus,
        select:focus {
            outline: 2px solid #bfdbfe;
            border-color: var(--brand);
        }

        .filter-actions {
            grid-column: 1 / -1;
            margin-top: 2px;
        }

        .errors {
            padding: 13px 15px;
            margin-bottom: 18px;
            border: 1px solid #fecaca;
            border-radius: 10px;
            background: #fef2f2;
            color: #b91c1c;
            font-size: 13px;
            line-height: 1.6;
        }

        .errors ul {
            margin: 8px 0 0;
            padding-left: 20px;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 850px;
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

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #fafcff;
        }

        td .muted {
            margin-top: 4px;
            font-size: 12px;
        }

        .badge {
            display: inline-block;
            padding: 6px 9px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .in {
            background: #dcfce7;
            color: #166534;
        }

        .out {
            background: var(--red-soft);
            color: #b91c1c;
        }

        .empty {
            padding: 35px 18px;
            color: var(--muted);
            text-align: center;
            line-height: 1.8;
        }

        .pagination {
            margin-top: 18px;
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

        @media (max-width: 850px) {
            .filters {
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

            .card {
                padding: 15px;
            }

            .card-header {
                align-items: flex-start;
            }

            .filters {
                grid-template-columns: 1fr;
            }

            .filter-actions {
                grid-column: auto;
            }

            .filter-actions .btn {
                flex: 1;
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
            <h1>Stock Transactions Report</h1>
            <div class="subtitle">
                Filter stock received and issued by product and date
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

    @if($errors->any())
        <div class="errors">
            <strong>Please correct the following:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="card">
        <div class="card-header">
            <div>
                <h2>Filter Transactions</h2>
                <div class="card-subtitle">
                    Narrow the report by product, transaction type or date range.
                </div>
            </div>
        </div>

        <form method="GET" action="{{ route('reports.transactions') }}">
            <div class="filters">

                <div class="field">
                    <label for="product_id">Product</label>
                    <select name="product_id" id="product_id">
                        <option value="">All Products</option>

                        @foreach($products as $product)
                            <option
                                value="{{ $product->id }}"
                                @selected((string)request('product_id') === (string)$product->id)
                            >
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label for="type">Transaction Type</label>
                    <select name="type" id="type">
                        <option value="">All Types</option>
                        <option value="in" @selected(request('type') === 'in')>
                            Stock In
                        </option>
                        <option value="out" @selected(request('type') === 'out')>
                            Stock Out
                        </option>
                    </select>
                </div>

                <div class="field">
                    <label for="date_from">From Date</label>
                    <input
                        type="date"
                        id="date_from"
                        name="date_from"
                        value="{{ request('date_from') }}"
                    >
                </div>

                <div class="field">
                    <label for="date_to">To Date</label>
                    <input
                        type="date"
                        id="date_to"
                        name="date_to"
                        value="{{ request('date_to') }}"
                    >
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn primary">
                        Apply Filters
                    </button>

                    <a href="{{ route('reports.transactions') }}" class="btn secondary">
                        Reset
                    </a>
                </div>

            </div>
        </form>
    </section>

    <section class="card">

        <div class="card-header">
            <div>
                <h2>Transaction History</h2>
                <div class="card-subtitle">
                    Stock-in and stock-out records matching your selected filters.
                </div>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Unit Cost</th>
                        <th>Reference</th>
                        <th>Recorded By</th>
                        <th>Notes</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($transactions as $transaction)
                    <tr>
                        <td>
                            {{ $transaction->transaction_date
                                ? \Illuminate\Support\Carbon::parse($transaction->transaction_date)->format('d M Y')
                                : '—' }}
                        </td>

                        <td>
                            <strong>
                                {{ $transaction->product?->name ?? 'Deleted product' }}
                            </strong>
                        </td>

                        <td>
                            @if($transaction->type === 'in')
                                <span class="badge in">Stock In</span>
                            @else
                                <span class="badge out">Stock Out</span>
                            @endif
                        </td>

                        <td>
                            <strong>{{ number_format($transaction->quantity) }}</strong>
                        </td>

                        <td>
                            @if($transaction->unit_cost !== null)
                                Rs. {{ number_format((float)$transaction->unit_cost, 2) }}
                            @else
                                —
                            @endif
                        </td>

                        <td>{{ $transaction->reference_number ?: '—' }}</td>

                        <td>{{ $transaction->user?->name ?? 'Unknown' }}</td>

                        <td>
                            {{ \Illuminate\Support\Str::limit($transaction->notes ?? '—', 45) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty">
                            No transactions match these filters.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $transactions->links() }}
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
