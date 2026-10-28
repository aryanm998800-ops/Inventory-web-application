
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management | InventoryPro</title>

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
            padding: 22px;
            box-shadow: var(--shadow);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 18px;
        }

        h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 800px;
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
            border-bottom: 0;
        }

        tbody tr:hover {
            background: #fafcff;
        }

        .actions {
            gap: 7px;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 10px;
            border: 1px solid transparent;
            border-radius: 7px;
            text-decoration: none;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
        }

        .view {
            background: var(--brand-soft);
            color: var(--brand-ink);
        }

        .view:hover {
            background: #dbeafe;
        }

        .edit {
            background: var(--purple-soft);
            color: #6d28d9;
        }

        .edit:hover {
            background: #e9d5ff;
        }

        .delete {
            background: var(--red-soft);
            color: #b91c1c;
        }

        .delete:hover {
            background: #fecaca;
        }

        .inline-form {
            display: inline;
            margin: 0;
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

        .alert {
            margin-bottom: 18px;
            padding: 13px 15px;
            border: 1px solid transparent;
            border-radius: 10px;
            font-size: 14px;
            line-height: 1.6;
        }

        .alert-success {
            background: #f0fdf4;
            border-color: #bbf7d0;
            color: #166534;
        }

        .alert-error {
            background: #fff0ef;
            border-color: #fecaca;
            color: #a32d27;
        }

        .alert ul {
            margin: 8px 0 0;
            padding-left: 22px;
        }

        .empty {
            padding: 35px 15px;
            text-align: center;
            color: var(--muted);
            line-height: 1.6;
        }

        .pagination {
            margin-top: 20px;
        }

        .pagination nav > div:first-child {
            margin-bottom: 12px;
            color: var(--muted);
            font-size: 13px;
        }

        .pagination nav a,
        .pagination nav span {
            border-radius: 7px;
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
            <h1>Users Management</h1>
            <div class="subtitle">
                InventoryPro · Manage accounts and roles
            </div>
        </div>

        <div class="top-actions">
            <a href="{{ route('dashboard') }}" class="btn secondary">
                ← Dashboard
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

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <strong>Please check the following:</strong>
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
                <h2>All Users</h2>
                <div class="subtitle" style="margin-top: 6px;">
                    View, edit and manage account access.
                </div>
            </div>

            <a href="{{ route('users.create') }}" class="btn primary">
                + Add User
            </a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>
                                {{ $users->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <strong>{{ $user->name }}</strong>
                            </td>

                            <td>
                                {{ $user->email }}
                            </td>

                            <td>
                                {{ $user->roles->pluck('name')->join(', ') ?: 'No role' }}
                            </td>

                            <td>
                                @if ($user->is_active)
                                    <span class="badge badge-active">
                                        Active
                                    </span>
                                @else
                                    <span class="badge badge-inactive">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="actions">
                                    <a
                                        href="{{ route('users.show', $user) }}"
                                        class="action-btn view"
                                    >
                                        View
                                    </a>

                                    <a
                                        href="{{ route('users.edit', $user) }}"
                                        class="action-btn edit"
                                    >
                                        Edit
                                    </a>

                                    @if ($user->is_active)
                                        <form
                                            method="POST"
                                            action="{{ route('users.destroy', $user) }}"
                                            class="inline-form"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="action-btn delete"
                                            >
                                                Deactivate
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty">
                                No users found. Click “Add User” to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $users->links() }}
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
