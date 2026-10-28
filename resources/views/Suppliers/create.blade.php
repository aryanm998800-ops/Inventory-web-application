
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Supplier | InventoryPro</title>

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
            font-size: 18px;
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
            padding: 22px;
            box-shadow: var(--shadow);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 22px;
        }

        .card-header p {
            margin: 7px 0 0;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .field {
            min-width: 0;
            margin-bottom: 2px;
        }

        .full {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 700;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid var(--line);
            border-radius: 9px;
            background: #fff;
            color: var(--ink);
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: 2px solid #bfdbfe;
            border-color: var(--brand);
        }

        textarea {
            min-height: 95px;
            resize: vertical;
            line-height: 1.5;
        }

        .error {
            margin-top: 6px;
            color: #b91c1c;
            font-size: 12px;
            line-height: 1.5;
        }

        .alert {
            margin-bottom: 18px;
            padding: 13px 15px;
            border: 1px solid #fecaca;
            border-radius: 10px;
            background: #fff0ef;
            color: #a32d27;
            font-size: 14px;
        }

        .alert ul {
            margin: 8px 0 0;
            padding-left: 20px;
        }

        .help {
            display: block;
            margin-top: 7px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.5;
        }

        .actions {
            margin-top: 24px;
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
                padding: 17px;
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
            <h1>Add Supplier</h1>
            <div class="subtitle">
                InventoryPro · Register a new supplier
            </div>
        </div>

        <div class="top-actions">
            <a href="{{ route('suppliers.index') }}" class="btn secondary">
                &larr; Back to Suppliers
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
                <h2>Supplier Information</h2>
                <p class="subtitle">
                    Enter the supplier's contact and business details.
                </p>
            </div>
        </div>

        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf

            <div class="grid">

                <div class="field">
                    <label for="name">Supplier Name *</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        maxlength="255"
                        required
                        placeholder="Enter supplier name"
                    >
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="company_name">Company Name</label>
                    <input
                        type="text"
                        id="company_name"
                        name="company_name"
                        value="{{ old('company_name') }}"
                        maxlength="255"
                        placeholder="Enter company name"
                    >
                    @error('company_name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        maxlength="255"
                        placeholder="supplier@example.com"
                    >
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="phone">Phone Number</label>
                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        value="{{ old('phone') }}"
                        maxlength="30"
                        placeholder="Enter phone number"
                    >
                    @error('phone')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field full">
                    <label for="address">Address</label>
                    <textarea
                        id="address"
                        name="address"
                        placeholder="Enter supplier address"
                    >{{ old('address') }}</textarea>
                    @error('address')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field full">
                    <label for="notes">Notes</label>
                    <textarea
                        id="notes"
                        name="notes"
                        placeholder="Optional notes about this supplier"
                    >{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="is_active">Supplier Status *</label>
                    <select id="is_active" name="is_active" required>
                        <option
                            value="1"
                            {{ old('is_active', '1') == '1' ? 'selected' : '' }}
                        >
                            Active
                        </option>

                        <option
                            value="0"
                            {{ old('is_active') === '0' ? 'selected' : '' }}
                        >
                            Inactive
                        </option>
                    </select>

                    @error('is_active')
                        <div class="error">{{ $message }}</div>
                    @enderror

                    <small class="help">
                        Choose whether this supplier is active.
                    </small>
                </div>

            </div>

            <div class="actions">
                <button type="submit" class="btn primary">
                    Save Supplier
                </button>

                <a href="{{ route('suppliers.index') }}" class="btn secondary">
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
