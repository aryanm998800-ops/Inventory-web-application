@extends('layouts.app')

@section('title', 'Dashboard')

@php
    $currency = 'PKR';
    $fmt = fn ($n) => number_format($n);
    $statusTotal = max(collect($stockStatus)->sum('count'), 1);

    $paths = [
        'right' => '<line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>',
        'package' => '<path d="M16.5 9.4l-9-5.19"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>',
        'alert' => '<path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>',
        'download' => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>',
        'upload' => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>',
        'trend-up' => '<line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/>',
        'trend-dn' => '<line x1="7" y1="7" x2="17" y2="17"/><polyline points="17 7 17 17 7 17"/>',
    ];

    $ic = fn ($n, $s = 18) =>
        '<svg width="'.$s.'" height="'.$s.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.($paths[$n] ?? '').'</svg>';

    $cards = [
        ['key' => 'total_products', 'title' => 'Total Products', 'tone' => 'purple', 'icon' => 'package', 'prefix' => ''],
        ['key' => 'low_stock', 'title' => 'Low Stock Items', 'tone' => 'amber', 'icon' => 'alert', 'prefix' => ''],
        ['key' => 'out_of_stock', 'title' => 'Out of Stock Items', 'tone' => 'red', 'icon' => 'package', 'prefix' => ''],
        ['key' => 'stock_in', 'title' => 'Stock In (This Month)', 'tone' => 'green', 'icon' => 'download', 'prefix' => '', 'suffix' => ' Units'],
    ];
@endphp

@section('content')

<style>
    /* Original dashboard theme */
    :root {
        --bg:#f4f5fb;
        --card:#fff;
        --ink:#1b1b3a;
        --muted:#6b7086;
        --line:#eceef5;
        --brand:#5b3df5;
        --brand-soft:#eeebff;
        --brand-ink:#3b22c9;
        --green:#10b981;
        --green-soft:#e3f8f0;
        --red:#ef4444;
        --red-soft:#fdeaea;
        --amber:#f59e0b;
        --amber-soft:#fff3df;
        --radius:16px;
        --shadow:0 1px 2px rgba(27,27,58,.04),0 6px 20px rgba(27,27,58,.04);
    }

    .dashboard-content {
        color:var(--ink);
        font-family:Inter,system-ui,sans-serif;
        font-size:14px;
        -webkit-font-smoothing:antialiased;
    }

    .dashboard-content *,
    .dashboard-content *::before,
    .dashboard-content *::after {
        box-sizing:border-box;
    }

    .dashboard-content svg {
        flex-shrink:0;
    }

    .dashboard-content .grid {
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:18px;
        margin-bottom:18px;
    }

    .dashboard-content .card {
        min-width:0;
        background:var(--card);
        border-radius:var(--radius);
        box-shadow:var(--shadow);
        padding:22px 24px;
    }

    .dashboard-content .stat-grid {
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:14px;
    }

    .dashboard-content h2 {
        font-size:15.5px;
        font-weight:700;
    }

    .dashboard-content .link {
        color:var(--brand-ink);
        font-weight:500;
        font-size:12.5px;
        display:inline-flex;
        align-items:center;
        gap:8px;
        text-decoration:none;
    }

    .dashboard-content .hero {
        display:flex;
        justify-content:space-between;
        align-items:center;
        background:linear-gradient(135deg,#f7f6ff,#fff);
    }

    .dashboard-content .hero h1 {
        font-size:25px;
        font-weight:700;
        margin-bottom:10px;
    }

    .dashboard-content .hero p {
        color:var(--muted);
        font-size:13px;
        line-height:1.5;
    }

    .dashboard-content .hero .lbl {
        margin-top:20px;
        font-size:13px;
        font-weight:500;
    }

    .dashboard-content .hero .value {
        font-size:34px;
        font-weight:800;
        color:var(--brand-ink);
        margin:2px 0 18px;
        letter-spacing:-.5px;
    }

    .dashboard-content .btn {
        display:inline-flex;
        align-items:center;
        gap:12px;
        background:var(--brand);
        color:#fff;
        padding:12px 22px;
        border-radius:8px;
        font-weight:600;
        font-size:13.5px;
        box-shadow:0 6px 14px rgba(91,61,245,.28);
        text-decoration:none;
    }

    .dashboard-content .btn:hover {
        background:#4a2fe0;
    }

    .dashboard-content .stat {
        display:flex;
        gap:16px;
        align-items:center;
        padding:20px;
    }

    .dashboard-content .stat .ico {
        width:54px;
        height:54px;
        border-radius:14px;
        display:grid;
        place-items:center;
        flex-shrink:0;
    }

    .dashboard-content .ico.purple {
        background:var(--brand-soft);
        color:var(--brand);
    }

    .dashboard-content .ico.amber {
        background:var(--amber-soft);
        color:var(--amber);
    }

    .dashboard-content .ico.red {
        background:var(--red-soft);
        color:var(--red);
    }

    .dashboard-content .ico.green {
        background:var(--green-soft);
        color:var(--green);
    }

    .dashboard-content .stat .t {
        font-size:13px;
        color:#454866;
    }

    .dashboard-content .stat .n {
        font-size:25px;
        font-weight:700;
        margin:2px 0 6px;
    }

    .dashboard-content .stat .n small {
        font-size:13px;
        font-weight:600;
        color:var(--muted);
    }

    .dashboard-content .chg {
        font-size:12px;
        color:var(--muted);
        display:flex;
        align-items:center;
        flex-wrap:wrap;
        gap:4px;
    }

    .dashboard-content .chg b {
        display:inline-flex;
        align-items:center;
        gap:3px;
        font-weight:600;
    }

    .dashboard-content .chg .up {
        color:var(--green);
    }

    .dashboard-content .chg .dn {
        color:var(--red);
    }

    .dashboard-content .card-head {
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:12px;
        margin-bottom:14px;
    }

    .dashboard-content .tag {
        border:1px solid var(--line);
        border-radius:8px;
        padding:7px 12px;
        font-size:12px;
        color:#454866;
    }

    .dashboard-content .legend {
        display:flex;
        flex-wrap:wrap;
        gap:22px;
        font-size:11.5px;
        color:#454866;
        margin-bottom:6px;
    }

    .dashboard-content .legend span {
        display:flex;
        align-items:center;
        gap:8px;
    }

    .dashboard-content .legend .sq {
        width:11px;
        height:11px;
        border-radius:3px;
        background:var(--brand);
    }

    .dashboard-content .legend .ln {
        width:18px;
        height:2px;
        background:#9b8cf7;
        position:relative;
    }

    .dashboard-content .legend .ln::after {
        content:'';
        position:absolute;
        left:5px;
        top:-3px;
        width:7px;
        height:7px;
        border-radius:50%;
        background:#fff;
        border:2px solid #9b8cf7;
    }

    .dashboard-content .chart-wrap {
        position:relative;
        height:250px;
    }

    .dashboard-content .donut-row {
        display:flex;
        align-items:center;
        gap:36px;
        padding-top:6px;
    }

    .dashboard-content .donut {
        position:relative;
        width:210px;
        height:210px;
        flex-shrink:0;
    }

    .dashboard-content .donut-center {
        position:absolute;
        inset:0;
        display:grid;
        place-content:center;
        text-align:center;
        font-size:12.5px;
        color:#454866;
        pointer-events:none;
    }

    .dashboard-content .donut-center b {
        font-size:21px;
        color:var(--ink);
        display:block;
    }

    .dashboard-content .status-list {
        flex:1;
        min-width:0;
        list-style:none;
    }

    .dashboard-content .status-list li {
        display:flex;
        align-items:center;
        gap:10px;
        padding:9px 0;
        font-size:12.5px;
    }

    .dashboard-content .status-list .dot {
        width:10px;
        height:10px;
        border-radius:50%;
    }

    .dashboard-content .status-list .num {
        margin-left:auto;
        display:flex;
        gap:10px;
    }

    .dashboard-content .status-list .num span:first-child {
        min-width:34px;
        text-align:right;
    }

    .dashboard-content .status-list .num span:last-child {
        min-width:56px;
        text-align:right;
    }

    .dashboard-content .table-wrap {
        width:100%;
        overflow-x:auto;
    }

    .dashboard-content table {
        width:100%;
        border-collapse:collapse;
        font-size:12.5px;
    }

    .dashboard-content thead th {
        background:#f6f7fb;
        font-weight:500;
        color:#555873;
        padding:10px 12px;
        text-align:center;
        font-size:12px;
        white-space:nowrap;
    }

    .dashboard-content thead th:first-child,
    .dashboard-content tbody td:first-child {
        text-align:left;
    }

    .dashboard-content tbody td {
        padding:12px;
        text-align:center;
        border-bottom:1px solid var(--line);
    }

    .dashboard-content tbody tr:last-child td {
        border-bottom:0;
    }

    .dashboard-content .prod {
        display:flex;
        align-items:center;
        gap:12px;
        font-weight:500;
        white-space:nowrap;
    }

    .dashboard-content .prod .thumb {
        width:28px;
        height:28px;
        border-radius:8px;
        background:var(--brand-soft);
        color:var(--brand-ink);
        display:grid;
        place-items:center;
        font-size:12px;
        font-weight:700;
    }

    .dashboard-content .badge {
        display:inline-block;
        padding:4px 10px;
        border-radius:6px;
        background:var(--amber-soft);
        color:#e08a00;
        font-size:10.5px;
        font-weight:600;
        white-space:nowrap;
    }

    .dashboard-content .badge.out {
        background:var(--red-soft);
        color:var(--red);
    }

    .dashboard-content .empty {
        text-align:center;
        color:var(--muted);
        padding:26px 0 !important;
    }

    .dashboard-content .act {
        display:flex;
        align-items:center;
        gap:14px;
        padding:11px 0;
        border-bottom:1px solid var(--line);
    }

    .dashboard-content .act:last-of-type {
        border-bottom:0;
    }

    .dashboard-content .act .ico {
        width:38px;
        height:38px;
        border-radius:10px;
        display:grid;
        place-items:center;
        flex-shrink:0;
    }

    .dashboard-content .act .info {
        flex:1;
        min-width:0;
        font-size:12px;
        color:#454866;
        overflow-wrap:anywhere;
    }

    .dashboard-content .act .info b {
        display:block;
        font-size:12.5px;
        color:var(--ink);
        font-weight:600;
        margin-bottom:1px;
    }

    .dashboard-content .act .meta {
        text-align:right;
        font-size:11.5px;
        color:var(--muted);
        flex-shrink:0;
    }

    .dashboard-content .act .meta b {
        display:block;
        font-weight:500;
        margin-bottom:2px;
    }

    .dashboard-content .meta .pos {
        color:var(--green);
    }

    .dashboard-content .meta .neg {
        color:var(--red);
    }

    .dashboard-content .card-foot {
        margin-top:16px;
    }

    @media (max-width:1200px) {
        .dashboard-content .grid {
            grid-template-columns:1fr;
        }
    }

    @media (max-width:900px) {
        .dashboard-content svg.box {
            display:none;
        }

        .dashboard-content .donut-row {
            flex-direction:column;
            align-items:flex-start;
        }
    }

    @media (max-width:560px) {
        .dashboard-content .stat-grid {
            grid-template-columns:1fr;
        }

        .dashboard-content .card {
            padding:18px;
        }

        .dashboard-content .hero h1 {
            font-size:23px;
        }

        .dashboard-content .hero .value {
            font-size:28px;
        }
    }
</style>

<div class="dashboard-content">

    {{-- Row 1: Original hero + stat cards --}}
    <section class="grid">
        <div class="card hero">
            <div>
                <h1>Inventory Overview</h1>

                <p>
                    Real-time summary of your inventory status.<br>
                    {{ $fmt($totalCategories) }} categories,
                    {{ $fmt($totalSuppliers) }} suppliers,
                    {{ $fmt($activeProducts) }} active products.
                </p>

                <div class="lbl">Total Inventory Value</div>

                <div class="value">
                    {{ $currency }} {{ number_format($totalValue, 2) }}
                </div>

                @can('view products')
                    <a href="{{ route('products.index') }}" class="btn">
                        View Inventory Details {!! $ic('right', 16) !!}
                    </a>
                @endcan
            </div>

            <svg class="box" width="210" height="190" viewBox="0 0 210 190" fill="none" aria-hidden="true">
                <ellipse cx="105" cy="175" rx="70" ry="9" fill="#e6e1fb"/>
                <path d="M105 70 L172 100 L105 130 L38 100 Z" fill="#cfc4fb"/>
                <path d="M38 100 L105 130 L105 178 L38 146 Z" fill="#6f4bf6"/>
                <path d="M172 100 L105 130 L105 178 L172 146 Z" fill="#4a2fd8"/>
                <path d="M38 100 L10 78 L72 58 L105 70 Z" fill="#a898f8"/>
                <path d="M172 100 L200 78 L138 58 L105 70 Z" fill="#8b78f4"/>
                <path d="M105 70 L138 58 L138 30 L105 42 Z" fill="#f4f1ff"/>
                <path d="M105 70 L72 58 L72 30 L105 42 Z" fill="#e4defc"/>
                <path d="M72 30 L105 18 L138 30 L105 42 Z" fill="#fff"/>
                <rect x="136" y="124" width="18" height="30" rx="2" fill="#8b78f4" opacity=".7"/>
            </svg>
        </div>

        <div class="stat-grid">
            @foreach ($cards as $c)
                @php $s = $stats[$c['key']]; @endphp

                <div class="card stat">
                    <div class="ico {{ $c['tone'] }}">
                        {!! $ic($c['icon'], 26) !!}
                    </div>

                    <div>
                        <div class="t">{{ $c['title'] }}</div>

                        <div class="n">
                            {{ $fmt($s['value']) }}@isset($c['suffix'])<small>{{ $c['suffix'] }}</small>@endisset
                        </div>

                        <div class="chg">
                            @isset($s['change'])
                                <b class="{{ $s['dir'] === 'up' ? 'up' : 'dn' }}">
                                    {!! $ic($s['dir'] === 'up' ? 'trend-up' : 'trend-dn', 13) !!}
                                    {{ $s['change'] }}%
                                </b>
                                vs last month
                            @else
                                {{ $s['note'] ?? '' }}
                            @endisset
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Row 2: Original trend chart + stock status --}}
    <section class="grid">
        <div class="card">
            <div class="card-head">
                <h2>Inventory Value Trend</h2>
                <div class="tag">Last 6 Months</div>
            </div>

            <div class="legend">
                <span><i class="sq"></i> Inventory Value ({{ $currency }})</span>
                <span><i class="ln"></i> No. of Products</span>
            </div>

            <div class="chart-wrap">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <h2>Stock Status</h2>
            </div>

            <div class="donut-row">
                <div class="donut">
                    <canvas id="statusChart"></canvas>

                    <div class="donut-center">
                        <span>Total</span>
                        <b>{{ $fmt($totalProducts) }}</b>
                        <span>Products</span>
                    </div>
                </div>

                <ul class="status-list">
                    @foreach ($stockStatus as $s)
                        <li>
                            <i class="dot" style="background:{{ $s['color'] }}"></i>
                            {{ $s['label'] }}

                            <span class="num">
                                <span>{{ $fmt($s['count']) }}</span>
                                <span>({{ number_format($s['count'] / $statusTotal * 100, 1) }}%)</span>
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>

            @can('view reports')
                <div class="card-foot">
                    <a href="{{ route('reports.stock') }}" class="link">
                        View full report {!! $ic('right', 14) !!}
                    </a>
                </div>
            @endcan
        </div>
    </section>

    {{-- Row 3: Original low-stock table + stock activities --}}
    <section class="grid" style="margin-bottom:0">
        <div class="card">
            <div class="card-head">
                <h2>Top Low Stock Items</h2>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>SKU</th>
                            <th>Current Stock</th>
                            <th>Reorder Level</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($lowStockItems as $item)
                            <tr>
                                <td>
                                    <a href="{{ $item['url'] }}" class="prod">
                                        <span class="thumb">{{ strtoupper(substr($item['name'], 0, 2)) }}</span>
                                        {{ $item['name'] }}
                                    </a>
                                </td>

                                <td>{{ $item['sku'] }}</td>
                                <td>{{ $item['stock'] }}</td>
                                <td>{{ $item['reorder'] }}</td>

                                <td>
                                    <span class="badge {{ $item['out'] ? 'out' : '' }}">
                                        {{ $item['out'] ? 'Out of Stock' : 'Low Stock' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty">
                                    Koi bhi product low stock mein nahi hai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @can('view reports')
                <div class="card-foot">
                    <a href="{{ route('reports.low-stock') }}" class="link">
                        View all low stock items {!! $ic('right', 14) !!}
                    </a>
                </div>
            @endcan
        </div>

        <div class="card">
            <div class="card-head">
                <h2>Recent Stock Activities</h2>

                @can('view stock')
                    <a href="{{ route('stock.history') }}" class="link" style="font-size:11.5px">
                        View All {!! $ic('right', 14) !!}
                    </a>
                @endcan
            </div>

            @forelse ($activities as $a)
                <div class="act">
                    <div class="ico {{ $a['type'] === 'in' ? 'green' : 'red' }}">
                        {!! $ic($a['type'] === 'in' ? 'download' : 'upload', 18) !!}
                    </div>

                    <div class="info">
                        <b>{{ $a['title'] }}</b>
                        {{ $a['desc'] }}
                    </div>

                    <div class="meta">
                        <b class="{{ $a['type'] === 'in' ? 'pos' : 'neg' }}">
                            {{ $a['amount'] }}
                        </b>
                        {{ $a['date'] }}
                    </div>
                </div>
            @empty
                <p class="empty" style="padding:26px 0">
                    Abhi tak koi stock activity nahi hui.
                </p>
            @endforelse

            @can('view stock')
                <div class="card-foot">
                    <a href="{{ route('stock.history') }}" class="link">
                        View all activities {!! $ic('right', 14) !!}
                    </a>
                </div>
            @endcan
        </div>
    </section>

</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const trend = @json($trend);
    const status = @json($stockStatus);

    if (typeof Chart === 'undefined') {
        console.error('Chart.js could not be loaded.');
        return;
    }

    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.font.size = 11;
    Chart.defaults.color = '#454866';

    const trendCanvas = document.getElementById('trendChart');

    if (trendCanvas) {
        new Chart(trendCanvas, {
            data: {
                labels: trend.labels,
                datasets: [
                    {
                        type: 'bar',
                        label: 'Inventory Value',
                        data: trend.values,
                        yAxisID: 'y',
                        backgroundColor: '#6a4cf0',
                        borderRadius: 4,
                        barPercentage: .55,
                        order: 2
                    },
                    {
                        type: 'line',
                        label: 'No. of Products',
                        data: trend.products,
                        yAxisID: 'y1',
                        borderColor: '#9b8cf7',
                        backgroundColor: '#fff',
                        borderWidth: 2,
                        pointRadius: 4,
                        pointBorderWidth: 2,
                        pointBackgroundColor: '#fff',
                        tension: .3,
                        order: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#eef0f6'
                        },
                        border: {
                            display: false
                        },
                        ticks: {
                            callback: v =>
                                v >= 1e6
                                    ? (v / 1e6).toFixed(1) + 'M'
                                    : (v >= 1e3 ? (v / 1e3) + 'K' : v)
                        }
                    },
                    y1: {
                        position: 'right',
                        beginAtZero: true,
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        },
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }

    const statusCanvas = document.getElementById('statusChart');

    if (statusCanvas) {
        new Chart(statusCanvas, {
            type: 'doughnut',
            data: {
                labels: status.map(s => s.label),
                datasets: [{
                    data: status.map(s => s.count),
                    backgroundColor: status.map(s => s.color),
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
});
</script>
@endsection
