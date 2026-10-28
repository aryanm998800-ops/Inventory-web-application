
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories | InventoryPro</title>

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
            align-items: center;
            justify-content: space-between;
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

        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 680px;
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

        .edit {
            background: var(--purple-soft);
            color: #6d28d9;
        }

        .delete {
            background: var(--red-soft);
            color: #b91c1c;
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

        .alert {
            margin-bottom: 18px;
            padding: 13px 15px;
            border-radius: 9px;
            font-size: 14px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .alert-error {
            background: var(--red-soft);
            color: #b91c1c;
        }

        .alert ul {
            margin: 8px 0 0;
            padding-left: 20px;
        }

        .empty {
            padding: 35px 15px;
            text-align: center;
            color: var(--muted);
            font-size: 14px;
        }

        .pagination-wrap {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 20px;
        }

        .pagination {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
        }

        .pagination a,
        .pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 35px;
            min-height: 35px;
            padding: 7px 10px;
            border: 1px solid var(--line);
            border-radius: 7px;
            text-decoration: none;
            color: var(--ink);
            background: #fff;
            font-size: 13px;
        }

        .pagination .active {
            background: var(--brand);
            color: #fff;
            border-color: var(--brand);
        }

        .pagination .disabled {
            color: #94a3b8;
            background: #f8fafc;
        }

        /* Centered logout confirmation */
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
            box-shadow: 0 20px 60px rgba(15, 23, 42, .22);
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

            .pagination-wrap {
                align-items: flex-start;
                flex-direction: column;
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
            <h1>Categories</h1>
            <div class="subtitle">
                Manage your inventory product categories.
            </div>
        </div>

        <div class="top-actions">
            <a href="{{ route('dashboard') }}" class="btn secondary">
                ← Dashboard
            </a>

            <button type="button"
                    class="btn logout-btn"
                    data-logout-confirm>
                Logout
            </button>
        </div>
    </header>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <strong>Please correct the following errors:</strong>
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
                <h2>All Categories</h2>
                <div class="subtitle" style="margin-top: 5px;">
                    View and manage your product categories.
                </div>
            </div>

            @can('create categories')
                <a href="{{ route('categories.create') }}"
                   class="btn primary">
                    + Add Category
                </a>
            @endcan
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>
                                {{ $categories->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <strong>{{ $category->name }}</strong>
                            </td>

                            <td>
                                {{ $category->description ?: '—' }}
                            </td>

                            <td>
                                @if ($category->is_active)
                                    <span class="badge badge-active">Active</span>
                                @else
                                    <span class="badge badge-inactive">Inactive</span>
                                @endif
                            </td>

                            <td>
                                {{ $category->created_at?->format('d M Y') ?? '—' }}
                            </td>

                            <td>
                                <div class="actions">
                                    @can('view categories')
                                        <a href="{{ route('categories.show', $category) }}"
                                           class="action-btn view">
                                            View
                                        </a>
                                    @endcan

                                    @can('edit categories')
                                        <a href="{{ route('categories.edit', $category) }}"
                                           class="action-btn edit">
                                            Edit
                                        </a>
                                    @endcan

                                    @can('delete categories')
                                        <form method="POST"
                                              action="{{ route('categories.destroy', $category) }}"
                                              onsubmit="return confirm('Are you sure you want to delete this category?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="action-btn delete">
                                                Delete
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty">
                                    <strong>No categories found.</strong>
                                    <p>Add your first category to get started.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($categories->hasPages())
            <div class="pagination-wrap">
                <div class="subtitle">
                    Showing {{ $categories->firstItem() ?? 0 }}–{{ $categories->lastItem() ?? 0 }}
                    of {{ $categories->total() }} categories
                </div>

                <div class="pagination">
                    @if ($categories->onFirstPage())
                        <span class="disabled">Previous</span>
                    @else
                        <a href="{{ $categories->previousPageUrl() }}">Previous</a>
                    @endif

                    @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                        @if ($page == $categories->currentPage())
                            <span class="active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($categories->hasMorePages())
                        <a href="{{ $categories->nextPageUrl() }}">Next</a>
                    @else
                        <span class="disabled">Next</span>
                    @endif
                </div>
            </div>
        @elseif ($categories->total() > 0)
            <div class="pagination-wrap">
                <div class="subtitle">
                    Showing {{ $categories->firstItem() ?? 0 }}–{{ $categories->lastItem() ?? 0 }}
                    of {{ $categories->total() }} categories
                </div>
            </div>
        @endif

    </section>
</div>

<!-- Logout modal -->
<div class="modal-overlay"
     id="logoutModal"
     aria-hidden="true">

    <div class="modal"
         role="dialog"
         aria-modal="true"
         aria-labelledby="logoutModalTitle"
         aria-describedby="logoutModalMessage">

        <div class="modal-icon">!</div>

        <h2 id="logoutModalTitle">Confirm Logout</h2>

        <p id="logoutModalMessage">
            Are you sure you want to log out of InventoryPro?
        </p>

        <div class="modal-actions">
            <button type="button"
                    class="btn secondary"
                    id="cancelLogout">
                Cancel
            </button>

            <button type="button"
                    class="btn logout-btn"
                    id="confirmLogout">
                Yes, Logout
            </button>
        </div>
    </div>
</div>

<form id="logoutForm"
      method="POST"
      action="{{ route('logout') }}"
      hidden>
    @csrf
</form>

<script>
    (function () {
        const modal = document.getElementById('logoutModal');
        const cancelButton = document.getElementById('cancelLogout');
        const confirmButton = document.getElementById('confirmLogout');
        const logoutForm = document.getElementById('logoutForm');
        const logoutButtons = document.querySelectorAll('[data-logout-confirm]');

        let lastFocusedElement = null;

        function openModal(event) {
            lastFocusedElement = event.currentTarget;
            modal.classList.add('open');
            modal.setAttribute('aria-hidden', 'false');
            cancelButton.focus();
        }

        function closeModal() {
            modal.classList.remove('open');
            modal.setAttribute('aria-hidden', 'true');

            if (lastFocusedElement) {
                lastFocusedElement.focus();
            }
        }

        logoutButtons.forEach(function (button) {
            button.addEventListener('click', openModal);
        });

        cancelButton.addEventListener('click', closeModal);

        confirmButton.addEventListener('click', function () {
            logoutForm.submit();
        });

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
