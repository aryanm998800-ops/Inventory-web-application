
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create User | InventoryPro</title>

    <style>
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

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px 22px;
            background: var(--bg);
            color: var(--ink);
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
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
            transition: background .15s, border-color .15s;
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

        .card-header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
        }

        .card-header p {
            margin: 6px 0 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .field {
            min-width: 0;
            margin-bottom: 5px;
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
        select {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #cbd5e1;
            border-radius: 9px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            background: #fff;
            color: var(--ink);
        }

        input:focus,
        select:focus {
            outline: 2px solid #bfdbfe;
            border-color: var(--brand);
        }

        input::placeholder {
            color: #94a3b8;
        }

        .help {
            margin-top: 7px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.5;
        }

        .actions {
            margin-top: 24px;
            padding-top: 18px;
            border-top: 1px solid var(--line);
        }

        .alert {
            padding: 13px 15px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 14px;
            line-height: 1.6;
        }

        .alert-error {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #be123c;
        }

        .alert ul {
            margin: 8px 0 0;
            padding-left: 20px;
        }

        .required-note {
            color: var(--muted);
            font-size: 12px;
            margin-top: 0;
            margin-bottom: 20px;
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

            .card {
                padding: 15px;
            }

            .card-header {
                align-items: flex-start;
            }

            .grid {
                grid-template-columns: 1fr;
            }

            .full {
                grid-column: auto;
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
            <h1>Create User</h1>
            <div class="subtitle">
                InventoryPro · Add a new account
            </div>
        </div>

        <div class="top-actions">
            <a href="{{ route('users.index') }}" class="btn secondary">
                ← Back to Users
            </a>

            <a href="{{ route('dashboard') }}" class="btn secondary">
                Dashboard
            </a>

            <button type="button" class="btn logout-btn" data-logout-confirm>
                Logout
            </button>
        </div>
    </header>

    @if ($errors->any())
        <div class="alert alert-error">
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
                <h2>User Information</h2>
                <p>Create an account and assign the appropriate role.</p>
            </div>
        </div>

        <p class="required-note">Fields marked with * are required.</p>

        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="grid">

                <div class="field">
                    <label for="name">Full Name *</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name') }}"
                        maxlength="255"
                        autocomplete="name"
                        placeholder="Enter full name"
                        required
                    >
                </div>

                <div class="field">
                    <label for="email">Email Address *</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        maxlength="255"
                        autocomplete="email"
                        placeholder="Enter email address"
                        required
                    >
                </div>

                <div class="field">
                    <label for="password">Password *</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        minlength="8"
                        autocomplete="new-password"
                        placeholder="Create a password"
                        required
                    >
                    <div class="help">Use at least 8 characters.</div>
                </div>

                <div class="field">
                    <label for="password_confirmation">Confirm Password *</label>
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        minlength="8"
                        autocomplete="new-password"
                        placeholder="Re-enter password"
                        required
                    >
                </div>

                <div class="field full">
                    <label for="role">Assign Role *</label>
                    <select id="role" name="role" required>
                        <option value="">Select a role</option>

                        @foreach ($roles as $role)
                            <option
                                value="{{ $role->name }}"
                                @selected(old('role') === $role->name)
                            >
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>

                    <div class="help">
                        A user's role determines which permitted areas they can access.
                    </div>
                </div>

            </div>

            <div class="actions">
                <button type="submit" class="btn primary">
                    Create User
                </button>

                <a href="{{ route('users.index') }}" class="btn secondary">
                    Cancel
                </a>
            </div>
        </form>
    </section>

</div>

<!-- Logout confirmation modal -->
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
            Are you sure you want to log out of InventoryPro?
            You will need to sign in again to access your account.
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
    (() => {
        const modal = document.getElementById('logoutModal');
        const openButtons = document.querySelectorAll('[data-logout-confirm]');
        const cancelButton = document.getElementById('cancelLogout');

        if (!modal || !cancelButton) {
            return;
        }

        let previousFocus = null;

        function openModal() {
            previousFocus = document.activeElement;
            modal.classList.add('open');
            modal.setAttribute('aria-hidden', 'false');
            cancelButton.focus();
        }

        function closeModal() {
            modal.classList.remove('open');
            modal.setAttribute('aria-hidden', 'true');

            if (previousFocus) {
                previousFocus.focus();
            }
        }

        openButtons.forEach((button) => {
            button.addEventListener('click', openModal);
        });

        cancelButton.addEventListener('click', closeModal);

        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                closeModal();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && modal.classList.contains('open')) {
                closeModal();
            }
        });
    })();
</script>

</body>
</html>
