
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Add Product | InventoryPro</title>

    <style>
        * { box-sizing: border-box; }

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
            max-width: 760px;
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

        .top-actions, .actions {
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

        .primary:hover { background: #1d4ed8; }

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

        .logout-btn:hover { background: #6d28d9; }

        .card {
            padding: 25px;
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: var(--radius);
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
            gap: 20px 18px;
        }

        .field { min-width: 0; }
        .full { grid-column: 1 / -1; }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 700;
        }

        input, select {
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

        input:focus, select:focus {
            outline: 2px solid #bfdbfe;
            border-color: var(--brand);
        }

        .help {
            display: block;
            margin-top: 7px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.5;
        }

        .error-text {
            margin-top: 6px;
            color: #b91c1c;
            font-size: 12px;
            line-height: 1.5;
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

        .success-message {
            display: none;
            margin-top: 9px;
            padding: 10px 12px;
            border-radius: 9px;
            background: #dcfce7;
            color: #166534;
            font-size: 12px;
            line-height: 1.5;
        }

        .category-control {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .category-control select { flex: 1; }

        .add-category-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 43px;
            height: 43px;
            border: 1px solid transparent;
            border-radius: 9px;
            background: var(--brand);
            color: #fff;
            font-size: 25px;
            cursor: pointer;
        }

        .add-category-btn:hover { background: #1d4ed8; }

        .actions {
            margin-top: 26px;
            padding-top: 20px;
            border-top: 1px solid var(--line);
        }

        button:disabled {
            opacity: .65;
            cursor: not-allowed;
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(15, 23, 42, .55);
        }

        .modal-overlay.open { display: flex; }

        .modal {
            width: 100%;
            max-width: 420px;
            padding: 26px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(15, 23, 42, .2);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .modal-header h2 { font-size: 21px; }

        .modal-close {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border: 0;
            border-radius: 9px;
            background: var(--brand-soft);
            color: var(--brand-ink);
            font-size: 22px;
            cursor: pointer;
        }

        .modal-description {
            margin: 0 0 20px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 9px;
            margin-top: 20px;
        }

        .modal-message {
            display: none;
            margin-top: 12px;
            padding: 10px 12px;
            border-radius: 9px;
            font-size: 13px;
            line-height: 1.5;
        }

        .modal-message.error {
            display: block;
            color: #a32d27;
            background: #fff0ef;
        }

        .logout-modal-icon {
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

        .logout-modal h2 {
            margin: 0 0 10px;
            font-size: 21px;
        }

        .logout-modal p {
            margin: 0 0 22px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        @media (max-width: 600px) {
            body { padding: 18px 13px; }
            .topbar { align-items: flex-start; }
            .top-actions { width: 100%; }
            h1 { font-size: 24px; }
            .card { padding: 18px; }
            .grid { grid-template-columns: 1fr; }
            .full { grid-column: auto; }
            .card-header { align-items: flex-start; }
            .modal { padding: 21px; }
        }
    </style>
</head>

<body>
<div class="container">

    <header class="topbar">
        <div>
            <h1>Add Product</h1>
            <div class="subtitle">
                InventoryPro · Register a new product
            </div>
        </div>

        <div class="top-actions">
            <a href="{{ route('products.index') }}" class="btn secondary">
                &larr; Back to Products
            </a>

            <button type="button" class="btn logout-btn" data-logout-confirm>
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

        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="grid">

                {{-- Product Name is selected from the category list. --}}
                <div class="field full">
                    <label for="category_id">Product Name *</label>

                    <div class="category-control">
                        <select id="category_id" name="category_id" required>
                            <option value="">Select a product name</option>

                            @foreach ($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    @selected(old('category_id') == $category->id)
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        @can('create categories')
                            <button
                                type="button"
                                class="add-category-btn"
                                id="openCategoryModal"
                                title="Add category"
                                aria-label="Add category"
                            >+</button>
                        @endcan
                    </div>

                    <input
                        type="hidden"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                    >

                    @error('category_id')
                        <div class="error-text">{{ $message }}</div>
                    @enderror

                    <div
                        id="categorySuccess"
                        class="success-message"
                        role="status"
                        aria-live="polite"
                    ></div>
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
                                @selected(old('unit', 'piece') === $value)
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
                        value="{{ old('purchase_price', '0.00') }}"
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
                        value="{{ old('sale_price', '0.00') }}"
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
                        value="{{ old('minimum_stock', '0') }}"
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

            </div>

            <div class="actions">
                <button type="submit" class="btn primary">
                    Save Product
                </button>

                <a href="{{ route('products.index') }}" class="btn secondary">
                    Cancel
                </a>
            </div>
        </form>
    </section>
</div>

@can('create categories')
<div
    class="modal-overlay"
    id="categoryModal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="categoryModalTitle"
    aria-hidden="true"
>
    <div class="modal">
        <div class="modal-header">
            <h2 id="categoryModalTitle">Add Category</h2>

            <button
                type="button"
                class="modal-close"
                id="closeCategoryModal"
                aria-label="Close popup"
            >&times;</button>
        </div>

        <p class="modal-description">
            Enter a name. It will be saved and added to the Product Name dropdown.
        </p>

        <form id="quickCategoryForm">
            <label for="quickCategoryName">Product Name *</label>

            <input
                type="text"
                id="quickCategoryName"
                name="name"
                maxlength="255"
                placeholder="e.g. Shampoo"
                autocomplete="off"
                required
            >

            <div
                id="categoryModalMessage"
                class="modal-message"
                role="status"
                aria-live="polite"
            ></div>

            <div class="modal-actions">
                <button
                    type="button"
                    class="btn secondary"
                    id="cancelCategoryModal"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="btn primary"
                    id="saveCategoryBtn"
                >
                    Save Product Name
                </button>
            </div>
        </form>
    </div>
</div>

<script>
(() => {
    const modal = document.getElementById('categoryModal');
    const openBtn = document.getElementById('openCategoryModal');
    const closeBtn = document.getElementById('closeCategoryModal');
    const cancelBtn = document.getElementById('cancelCategoryModal');
    const form = document.getElementById('quickCategoryForm');
    const nameInput = document.getElementById('quickCategoryName');
    const saveBtn = document.getElementById('saveCategoryBtn');
    const categorySelect = document.getElementById('category_id');
    const productNameInput = document.getElementById('name');
    const message = document.getElementById('categoryModalMessage');
    const successMessage = document.getElementById('categorySuccess');

    const csrfToken = document.querySelector(
        'meta[name="csrf-token"]'
    ).getAttribute('content');

    const storeUrl = @json(route('products.categories.quick-store'));

    function syncProductName() {
        const selectedOption =
            categorySelect.options[categorySelect.selectedIndex];

        productNameInput.value = categorySelect.value
            ? selectedOption.textContent.trim()
            : '';
    }

    categorySelect.addEventListener('change', syncProductName);

    function showError(text) {
        message.textContent = text;
        message.className = 'modal-message error';
    }

    function clearMessage() {
        message.textContent = '';
        message.className = 'modal-message';
    }

    function openModal() {
        form.reset();
        clearMessage();
        successMessage.style.display = 'none';
        modal.classList.add('open');
        modal.setAttribute('aria-hidden', 'false');
        nameInput.focus();
    }

    function closeModal() {
        if (saveBtn.disabled) return;

        modal.classList.remove('open');
        modal.setAttribute('aria-hidden', 'true');
        clearMessage();
        openBtn.focus();
    }

    openBtn.addEventListener('click', openModal);
    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (
            event.key === 'Escape' &&
            modal.classList.contains('open') &&
            !saveBtn.disabled
        ) {
            closeModal();
        }
    });

    form.addEventListener('submit', async function (event) {
        event.preventDefault();

        clearMessage();
        successMessage.style.display = 'none';

        const categoryName = nameInput.value.trim();

        if (!categoryName) {
            showError('Please enter a product name.');
            nameInput.focus();
            return;
        }

        saveBtn.disabled = true;
        saveBtn.textContent = 'Saving...';

        try {
            const response = await fetch(storeUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    name: categoryName
                })
            });

            const data = await response.json();

            if (!response.ok) {
                if (response.status === 422 && data.errors) {
                    const firstError =
                        Object.values(data.errors).flat()[0];

                    showError(
                        firstError || 'Please check the product name.'
                    );
                } else {
                    showError(
                        data.message ||
                        'Could not save the name. Please try again.'
                    );
                }

                return;
            }

            if (
                !data.category ||
                !data.category.id ||
                !data.category.name
            ) {
                showError('The server returned an unexpected response.');
                return;
            }

            const categoryId = String(data.category.id);

            let option = Array.from(categorySelect.options).find(
                item => item.value === categoryId
            );

            if (!option) {
                option = new Option(data.category.name, categoryId);
                categorySelect.add(option);
            }

            categorySelect.value = categoryId;
            syncProductName();

            successMessage.textContent = data.already_exists
                ? 'This name already exists. It has been selected.'
                : 'Name saved successfully and selected.';

            successMessage.style.display = 'block';

            modal.classList.remove('open');
            modal.setAttribute('aria-hidden', 'true');
            form.reset();
            clearMessage();

        } catch (error) {
            showError(
                'Unable to contact the server. Check your connection and try again.'
            );
        } finally {
            saveBtn.disabled = false;
            saveBtn.textContent = 'Save Product Name';
        }
    });

    syncProductName();
})();
</script>
@endcan

<!-- Logout Confirmation Modal -->
<div
    class="modal-overlay"
    id="logoutModal"
    aria-hidden="true"
>
    <div
        class="modal logout-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="logoutModalTitle"
        aria-describedby="logoutModalDescription"
    >
        <div class="logout-modal-icon">↗</div>

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
        if (
            event.key === 'Escape' &&
            modal.classList.contains('open')
        ) {
            closeModal();
        }
    });
})();
</script>

</body>
</html>
