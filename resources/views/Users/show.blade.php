
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Details | InventoryPro</title>

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
            margin-bottom: 20px;
        }

        .card-header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 16px;
            padding-bottom: 22px;
            margin-bottom: 22px;
            border-bottom: 1px solid var(--line);
        }

        .avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 58px;
            height: 58px;
            flex-shrink: 0;
            border-radius: 50%;
            background: var(--brand-soft);
            color: var(--brand-ink);
            font-size: 24px;
            font-weight: 700;
        }

        .profile h2 {
            margin: 0 0 6px;
            font-size: 21px;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .profile-email {
            color: var(--muted);
            font-size: 14px;
            overflow-wrap: anywhere;
        }

        .profile-status {
            margin-top: 9px;
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
            overflow-wrap: anywhere;
        }

        .detail-label {
            display: block;
            margin-bottom: 8px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .35px;
        }

        .detail-value {
            font-size: 14px;
            font-weight: 700;
            line-height: 1.6;
            overflow-wrap: anywhere;
        }

        .badge {
            display: inline-block;
            padding: 6px 9px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-active {
            background: #dcfce7;
            color: #166534;
        }

        .badge-inactive {
            background: #f1f5f9;
            color: #475569;
        }

        .actions {
            margin-top: 22px;
            padding-top: 18px;
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

            .card {
                padding: 15px;
            }

            .profile {
                align-items: flex-start;
                gap: 12px;
            }

            .avatar {
                width: 48px;
                height: 48px;
                font-size: 20px;
            }

            .details {
                grid-template-columns: 1fr;
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
            <h1>User Details</h1>
            <div class="subtitle">
                InventoryPro · Account information
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

    <section class="card">

        <div class="profile">
            <div class="avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <div>
                <h2>{{ $user->name }}</h2>

                <div class="profile-email">
                    {{ $user->email }}
                </div>

                <div class="profile-status">
                    @if ($user->is_active)
                        <span class="badge badge-active">Active Account</span>
                    @else
                        <span class="badge badge-inactive">Inactive Account</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-header">
            <h2>Account Information</h2>
        </div>

        <div class="details">

            <div class="detail">
                <span class="detail-label">Full Name</span>
                <div class="detail-value">{{ $user->name }}</div>
            </div>

            <div class="detail">
                <span class="detail-label">Email Address</span>
                <div class="detail-value">{{ $user->email }}</div>
            </div>

            <div class="detail">
                <span class="detail-label">Assigned Role</span>
                <div class="detail-value">
                    {{ $user->roles->pluck('name')->join(', ') ?: 'No role assigned' }}
                </div>
            </div>

            <div class="detail">
                <span class="detail-label">Account Status</span>
                <div class="detail-value">
                    @if ($user->is_active)
                        <span class="badge badge-active">Active</span>
                    @else
                        <span class="badge badge-inactive">Inactive</span>
                    @endif
                </div>
            </div>

            <div class="detail">
                <span class="detail-label">Email Verified</span>
                <div class="detail-value">
                    {{ $user->email_verified_at
                        ? $user->email_verified_at->format('d M Y, h:i A')
                        : 'Not verified' }}
                </div>
            </div>

            <div class="detail">
                <span class="detail-label">Account Created</span>
                <div class="detail-value">
                    {{ $user->created_at?->format('d M Y, h:i A') ?? 'Not available' }}
                </div>
            </div>

            <div class="detail">
                <span class="detail-label">Last Updated</span>
                <div class="detail-value">
                    {{ $user->updated_at?->format('d M Y, h:i A') ?? 'Not available' }}
                </div>
            </div>

            <div class="detail">
                <span class="detail-label">User ID</span>
                <div class="detail-value">{{ $user->id }}</div>
            </div>

        </div>

        <div class="actions">
            <a href="{{ route('users.edit', $user) }}" class="btn primary">
                Edit User
            </a>

            <a href="{{ route('users.index') }}" class="btn secondary">
                Back to List
            </a>
        </div>

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
