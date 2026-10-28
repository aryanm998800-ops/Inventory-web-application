
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category | InventoryPro</title>

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
            padding: 28px;
            box-shadow: var(--shadow);
        }

        .field {
            margin-bottom: 22px;
        }

        label {
            display: block;
            margin-bottom: 9px;
            font-size: 14px;
            font-weight: 700;
        }

        input[type="text"],
        textarea {
            display: block;
            width: 100%;
            padding: 13px;
            border: 1px solid #cbd5e1;
            border-radius: 9px;
            font-size: 15px;
            font-family: Arial, sans-serif;
            color: var(--ink);
            background: #fff;
            transition: border-color .15s ease, box-shadow .15s ease;
        }

        input[type="text"]:focus,
        textarea:focus {
            outline: none;
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .help {
            display: block;
            margin-top: 7px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.5;
        }

        .status-options {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .status-options label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            font-weight: 400;
            cursor: pointer;
        }

        .status-options input {
            accent-color: var(--brand);
        }

        .actions {
            margin-top: 28px;
        }

        .alert {
            margin-bottom: 18px;
            padding: 13px 15px;
            border: 1px solid #fecaca;
            border-radius: 10px;
            background: #fff0ef;
            color: #a32d27;
            font-size: 14px;
            line-height: 1.6;
        }

        .alert ul {
            margin-bottom: 0;
            padding-left: 22px;
        }

        .required {
            color: var(--red);
        }

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
                padding: 20px;
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
            <h1>Edit Category</h1>
            <div class="subtitle">
                InventoryPro · Update category details
            </div>
        </div>

        <div class="top-actions">
            <a href="{{ route('categories.index') }}" class="btn secondary">
                &larr; Back to Categories
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
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="card">
        <form method="POST" action="{{ route('categories.update', $category) }}">
            @csrf
            @method('PUT')

            <div class="field">
                <label for="name">
                    Category Name <span class="required">*</span>
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $category->name) }}"
                    placeholder="e.g. Electronics"
                    maxlength="255"
                    required
                    autofocus
                >

                <small class="help">
                    Category name must be unique.
                </small>
            </div>

            <div class="field">
                <label for="description">Description</label>

                <textarea
                    id="description"
                    name="description"
                    maxlength="2000"
                    placeholder="Enter a short description (optional)..."
                >{{ old('description', $category->description) }}</textarea>

                <small class="help">
                    Update the description of this category if needed.
                </small>
            </div>

            <div class="field">
                <label>
                    Category Status <span class="required">*</span>
                </label>

                <div class="status-options">
                    <label>
                        <input
                            type="radio"
                            name="is_active"
                            value="1"
                            {{ (string) old('is_active', (int) $category->is_active) === '1' ? 'checked' : '' }}
                            required
                        >
                        Active
                    </label>

                    <label>
                        <input
                            type="radio"
                            name="is_active"
                            value="0"
                            {{ (string) old('is_active', (int) $category->is_active) === '0' ? 'checked' : '' }}
                            required
                        >
                        Inactive
                    </label>
                </div>

                <small class="help">
                    You can change the category status at any time.
                </small>
            </div>

            <div class="actions">
                <button type="submit" class="btn primary">
                    Update Category
                </button>

                <a href="{{ route('categories.index') }}" class="btn secondary">
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
