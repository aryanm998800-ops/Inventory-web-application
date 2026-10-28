
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product | InventoryPro</title>

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
            padding: 25px;
            box-shadow: var(--shadow);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            padding-bottom: 18px;
            margin-bottom: 22px;
            border-bottom: 1px solid var(--line);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .field {
            min-width: 0;
            margin-bottom: 3px;
        }

        .full {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 700;
        }

        input,
        select,
        textarea {
            width: 100%;
            min-width: 0;
            padding: 12px 13px;
            border: 1px solid #d7e2ec;
            border-radius: 9px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: var(--ink);
            background: #fff;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: 2px solid #bfdbfe;
            border-color: var(--brand);
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

        .error-text {
            color: #b91c1c;
            font-size: 12px;
            line-height: 1.5;
            margin-top: 6px;
        }

        .alert {
            padding: 13px 15px;
            margin-bottom: 18px;
            border: 1px solid #fecaca;
            border-radius: 10px;
            background: #fff0ef;
            color: #a32d27;
            font-size: 14px;
            line-height: 1.6;
        }

        .status-options {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            padding: 12px 13px;
            border: 1px solid var(--line);
            border-radius: 9px;
            background: #fff;
        }

        .status-options label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            font-weight: 400;
            cursor: pointer;
        }

        .status-options input {
            width: auto;
            margin: 0;
            accent-color: var(--brand);
        }

        .actions {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid var(--line);
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
                padding: 18px;
            }

            .grid {
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
            <h1>Edit Product</h1>
            <div class="subtitle">
                InventoryPro · Update product information
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

    @if ($errors->any())
        <div class="alert">
            <strong>Please correct the following errors:</strong>
            <ul style="margin-bottom: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="card">

        <div class="card-header">
            <h2>Product Information</h2>
            <span class="subtitle">* Required fields</span>
        </div>

        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid">

                <div class="field full">
                    <label for="name">Product Name *</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $product->name) }}"
                        maxlength="255"
                        required
                    >
                    @error('name')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="category_id">Category *</label>
                    <select id="category_id" name="category_id" required>
                        <option value="">Select a category</option>

                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected(old('category_id', $product->category_id) == $category->id)
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="sku">SKU *</label>
                    <input
                        type="text"
                        id="sku"
                        name="sku"
                        value="{{ old('sku', $product->sku) }}"
                        maxlength="255"
                        required
                    >
                    @error('sku')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="barcode">Barcode</label>
                    <input
                        type="text"
                        id="barcode"
                        name="barcode"
                        value="{{ old('barcode', $product->barcode) }}"
                        maxlength="255"
                    >
                    @error('barcode')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="unit">Unit *</label>
                    <select id="unit" name="unit" required>
                        @foreach ([
                            'piece' => 'Piece',
                            'kg' => 'Kilogram (kg)',
                            'gram' => 'Gram',
                            'liter' => 'Liter',
                            'meter' => 'Meter',
                            'box' => 'Box',
                            'pack' => 'Pack',
                            'dozen' => 'Dozen'
                        ] as $value => $label)
                            <option
                                value="{{ $value }}"
                                @selected(old('unit', $product->unit) === $value)
                            >
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('unit')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="purchase_price">Purchase Price (Rs.) *</label>
                    <input
                        type="number"
                        id="purchase_price"
                        name="purchase_price"
                        value="{{ old('purchase_price', $product->purchase_price) }}"
                        min="0"
                        step="0.01"
                        required
                    >
                    @error('purchase_price')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="sale_price">Sale Price (Rs.) *</label>
                    <input
                        type="number"
                        id="sale_price"
                        name="sale_price"
                        value="{{ old('sale_price', $product->sale_price) }}"
                        min="0"
                        step="0.01"
                        required
                    >
                    @error('sale_price')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="minimum_stock">Minimum Stock *</label>
                    <input
                        type="number"
                        id="minimum_stock"
                        name="minimum_stock"
                        value="{{ old('minimum_stock', $product->minimum_stock) }}"
                        min="0"
                        step="1"
                        required
                    >
                    <small class="help">
                        Used as the low-stock threshold.
                    </small>
                    @error('minimum_stock')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field full">
                    <label>Product Status *</label>

                    <div class="status-options">
                        <label>
                            <input
                                type="radio"
                                name="is_active"
                                value="1"
                                required
                                @checked((string) old('is_active', (int) $product->is_active) === '1')
                            >
                            Active
                        </label>

                        <label>
                            <input
                                type="radio"
                                name="is_active"
                                value="0"
                                @checked((string) old('is_active', (int) $product->is_active) === '0')
                            >
                            Inactive
                        </label>
                    </div>

                    @error('is_active')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field full">
                    <label for="description">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        maxlength="2000"
                        placeholder="Optional product details..."
                    >{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="actions">
                <button type="submit" class="btn primary">
                    Update Product
                </button>

                <a href="{{ route('products.index') }}" class="btn secondary">
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
