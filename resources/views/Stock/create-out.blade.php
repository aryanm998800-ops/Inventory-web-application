
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Out | InventoryPro</title>

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
            max-width: 850px;
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
            font-size: 18px;
            font-weight: 700;
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
            margin-bottom: 20px;
        }

        .card-subtitle {
            margin-top: 6px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .notice {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 18px;
            padding: 14px 15px;
            border: 1px solid #fed7aa;
            border-radius: 10px;
            background: #fff7ed;
            color: #9a3412;
            font-size: 13px;
            line-height: 1.6;
        }

        .notice-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #ffedd5;
            color: #9a3412;
            font-weight: 700;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .field {
            min-width: 0;
            margin-bottom: 17px;
        }

        .full {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: var(--ink);
            font-size: 13px;
            font-weight: 700;
        }

        input,
        select,
        textarea {
            display: block;
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #d7e0ec;
            border-radius: 9px;
            background: #fff;
            color: var(--ink);
            font-family: Arial, sans-serif;
            font-size: 14px;
            transition: border-color .2s, box-shadow .2s;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
        }

        textarea {
            min-height: 95px;
            resize: vertical;
        }

        .help {
            display: block;
            margin-top: 7px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.5;
        }

        .alert {
            margin-bottom: 18px;
            padding: 13px 15px;
            border: 1px solid #fecaca;
            border-radius: 10px;
            background: #fef2f2;
            color: #b91c1c;
            font-size: 14px;
            line-height: 1.6;
        }

        .alert ul {
            margin: 8px 0 0;
            padding-left: 21px;
        }

        .form-footer {
            display: flex;
            flex-wrap: wrap;
            gap: 9px;
            margin-top: 5px;
            padding-top: 18px;
            border-top: 1px solid var(--line);
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

            .grid {
                grid-template-columns: 1fr;
            }

            .full {
                grid-column: auto;
            }

            .card {
                padding: 15px;
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
            <h1>Stock Out</h1>
            <div class="subtitle">
                Record stock issued or removed from inventory
            </div>
        </div>

        <div class="top-actions">
            <a href="{{ route('stock.index') }}" class="btn secondary">
                ← Back to Stock
            </a>

            <button type="button" class="btn logout-btn" data-logout-confirm>
                Logout
            </button>
        </div>
    </header>

    <div class="notice">
        <span class="notice-icon">!</span>
        <div>
            Available stock is checked again on submission.
            You cannot issue more than the available quantity.
        </div>
    </div>

    @if ($errors->any())
        <div class="alert">
            <strong>Please correct these errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="card">

        <div class="card-header">
            <div>
                <h2>Issue Stock</h2>
                <div class="card-subtitle">
                    Enter the quantity and details of the stock being issued.
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('stock.store-out') }}">
            @csrf

            <div class="grid">

                <div class="field full">
                    <label for="product_id">Product *</label>

                    <select id="product_id" name="product_id" required>
                        <option value="">Select a product</option>

                        @foreach ($products as $product)
                            <option
                                value="{{ $product->id }}"
                                @selected(old('product_id') == $product->id)
                            >
                                {{ $product->name }}
                                (Available: {{ $product->current_stock }} {{ $product->unit }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label for="quantity">Quantity Issued *</label>

                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        min="1"
                        step="1"
                        value="{{ old('quantity') }}"
                        required
                    >

                    <small class="help">
                        Must not exceed available stock.
                    </small>
                </div>

                <div class="field">
                    <label for="transaction_date">Transaction Date *</label>

                    <input
                        type="date"
                        id="transaction_date"
                        name="transaction_date"
                        value="{{ old('transaction_date', now()->toDateString()) }}"
                        required
                    >
                </div>

                <div class="field full">
                    <label for="reference_number">Reference Number</label>

                    <input
                        type="text"
                        id="reference_number"
                        name="reference_number"
                        maxlength="255"
                        value="{{ old('reference_number') }}"
                        placeholder="Optional issue or order number"
                    >
                </div>

                <div class="field full">
                    <label for="notes">Notes</label>

                    <textarea
                        id="notes"
                        name="notes"
                        placeholder="Reason for issuing stock..."
                    >{{ old('notes') }}</textarea>
                </div>

            </div>

            <div class="form-footer">
                <button type="submit" class="btn primary">
                    Save Stock Out
                </button>

                <a href="{{ route('stock.index') }}" class="btn secondary">
                    Cancel
                </a>
            </div>
        </form>

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
