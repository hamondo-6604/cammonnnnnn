{{--
|--------------------------------------------------------------------------
| resources/views/dashboard/admin_list.blade.php
|--------------------------------------------------------------------------
| Main Admin Dashboard view.
|
| Controller: App\Http\Controllers\Admin\DashboardController@index
| Route name: admin.dashboard
| Route: GET /admin/dashboard
|
| Data expected from controller ($data array or individual variables):
| $totalBookings (int) — bookings this month
| $totalRevenue (float) — revenue this month (₱)
| $activeTrips (int) — currently running trips
| $totalPassengers (int) — registered users
| $recentBookings (Collection<Booking>) — latest 5 bookings
    | $fleetStatus (array) — ['active'=>N, 'maintenance'=>N, 'idle'=>N]
    | $revenueChart (array) — 30-day daily revenue for sparkline
    | $bookingChart (array) — 30-day daily booking count
    |
    | TODO: Replace all placeholder values with real Eloquent data once
    | models (Booking, Trip, Bus, User) are fully implemented.
    --}}

    @extends('layouts.app')

    {{-- ── Page meta ── --}}
    @section('title', 'Dashboard')

    {{-- ── Header bar labels (consumed by layouts/header.blade.php) ── --}}
    @section('page-title', 'Dashboard Overview')
    @section('page-sub', 'Real-time overview of LOVO operations')

    {{-- ══════════════════════════════════════════════════════════════════
    CONTENT
    ════════════════════════════════════════════════════════════════════ --}}
    @section('content')

        {{-- ─────────────────────────────────────────────────────────────────
        ROW 1 — KPI STAT CARDS
        TODO: swap static numbers with $totalBookings, $totalRevenue, etc.
        ───────────────────────────────────────────────────────────────── --}}
        <div class="kpi-grid">

            {{-- Bookings --}}
            <div class="kpi-card">
                <div class="kpi-icon kpi-icon--khaki">
                    <i class="fa-solid fa-ticket"></i>
                </div>
                <div class="kpi-body">
                    <span class="kpi-label">Total Bookings</span>
                    {{-- TODO: {{ number_format($totalBookings) }} --}}
                    <span class="kpi-value">3,248</span>
                    <span class="kpi-delta kpi-delta--up">
                        <i class="fa-solid fa-arrow-trend-up"></i> +8.4% this month
                    </span>
                </div>
                <div class="kpi-spark" id="kpi-spark-bookings"></div>
            </div>

            {{-- Revenue --}}
            <div class="kpi-card">
                <div class="kpi-icon kpi-icon--green">
                    <i class="fa-solid fa-peso-sign"></i>
                </div>
                <div class="kpi-body">
                    <span class="kpi-label">Revenue</span>
                    {{-- TODO: ₱{{ number_format($totalRevenue, 2) }} --}}
                    <span class="kpi-value">₱1.24M</span>
                    <span class="kpi-delta kpi-delta--up">
                        <i class="fa-solid fa-arrow-trend-up"></i> +12.1% vs last month
                    </span>
                </div>
                <div class="kpi-spark" id="kpi-spark-revenue"></div>
            </div>

            {{-- Active Trips --}}
            <div class="kpi-card">
                <div class="kpi-icon kpi-icon--blue">
                    <i class="fa-solid fa-map-location-dot"></i>
                </div>
                <div class="kpi-body">
                    <span class="kpi-label">Active Trips</span>
                    {{-- TODO: {{ $activeTrips }} --}}
                    <span class="kpi-value">14</span>
                    <span class="kpi-delta kpi-delta--neutral">
                        <i class="fa-solid fa-circle-dot"></i> Live right now
                    </span>
                </div>
            </div>

            {{-- Passengers --}}
            <div class="kpi-card">
                <div class="kpi-icon kpi-icon--amber">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="kpi-body">
                    <span class="kpi-label">Registered Passengers</span>
                    {{-- TODO: {{ number_format($totalPassengers) }} --}}
                    <span class="kpi-value">3,891</span>
                    <span class="kpi-delta kpi-delta--up">
                        <i class="fa-solid fa-user-plus"></i> +34 this week
                    </span>
                </div>
            </div>

        </div>{{-- /.kpi-grid --}}


        {{-- ─────────────────────────────────────────────────────────────────
        ROW 2 — REVENUE CHART + RECENT BOOKINGS
        ───────────────────────────────────────────────────────────────── --}}
        <div class="dash-row">

            {{-- ── Revenue chart panel ── --}}
            <div class="dash-panel dash-panel--wide">
                <div class="panel-head">
                    <div>
                        <h2 class="panel-title">Revenue Overview</h2>
                        <p class="panel-sub">Daily revenue — last 30 days</p>
                    </div>
                    <div class="panel-actions">
                        {{-- Tab switcher --}}
                        <div class="tab-bar">
                            <button class="tab active" data-tab="revenue">Revenue</button>
                            <button class="tab" data-tab="bookings">Bookings</button>
                        </div>
                        <a href="{{ route('admin.analytics') }}" class="panel-link">
                            Full report <i class="fa-solid fa-arrow-right fa-xs"></i>
                        </a>
                    </div>
                </div>

                {{-- Bar chart (rendered by JS below) --}}
                {{--
                TODO: pass real 30-day data to JS via a @json blade directive:
                <div id="rev-chart-data" data-revenue="{{ json_encode($revenueChart) }}"
                    data-bookings="{{ json_encode($bookingChart) }}"></div>
                --}}
                <div id="rev-chart" class="rev-chart-wrap" aria-label="Revenue bar chart"></div>
                <div class="rev-chart-labels">
                    <span>30 days ago</span>
                    <span>15 days ago</span>
                    <span>Today</span>
                </div>
            </div>

            {{-- ── Recent Bookings table ── --}}
            <div class="dash-panel dash-panel--narrow">
                <div class="panel-head">
                    <div>
                        <h2 class="panel-title">Recent Bookings</h2>
                        <p class="panel-sub">Latest 5 reservations</p>
                    </div>
                    <a href="{{ route('admin.bookings.index') }}" class="panel-link">
                        View all <i class="fa-solid fa-arrow-right fa-xs"></i>
                    </a>
                </div>

                {{--
                TODO: replace with a @foreach over $recentBookings collection
                Example:
                @forelse($recentBookings as $booking)
                <div class="booking-row">
                    <div class="booking-avatar">{{ strtoupper(substr($booking->passenger->name,0,1)) }}</div>
                    <div class="booking-info">
                        <span class="booking-name">{{ $booking->passenger->name }}</span>
                        <span class="booking-route">{{ $booking->trip->route->origin }} → {{
                            $booking->trip->route->destination }}</span>
                    </div>
                    <span class="booking-status booking-status--{{ $booking->status }}">{{ ucfirst($booking->status)
                        }}</span>
                </div>
                @empty
                <p class="empty-state">No recent bookings.</p>
                @endforelse
                --}}

                {{-- Static placeholder rows (remove once data is wired) --}}
                @php
                    $placeholderBookings = [
                        ['initials' => 'MA', 'name' => 'Maria Alcantara', 'route' => 'Manila → Cebu', 'status' => 'confirmed'],
                        ['initials' => 'JR', 'name' => 'Jose Reyes', 'route' => 'Davao → Cagayan', 'status' => 'pending'],
                        ['initials' => 'SC', 'name' => 'Sofia Cruz', 'route' => 'Iloilo → Bacolod', 'status' => 'confirmed'],
                        ['initials' => 'AL', 'name' => 'Antonio Lim', 'route' => 'Manila → Baguio', 'status' => 'cancelled'],
                        ['initials' => 'RP', 'name' => 'Rosa Pascual', 'route' => 'Cebu → Tacloban', 'status' => 'confirmed'],
                    ];
                @endphp

                <div class="booking-list">
                    @foreach($placeholderBookings as $b)
                        <div class="booking-row">
                            <div class="booking-avatar">{{ $b['initials'] }}</div>
                            <div class="booking-info">
                                <span class="booking-name">{{ $b['name'] }}</span>
                                <span class="booking-route">
                                    <i class="fa-solid fa-route fa-xs"></i> {{ $b['route'] }}
                                </span>
                            </div>
                            <span class="booking-status booking-status--{{ $b['status'] }}">
                                {{ ucfirst($b['status']) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>{{-- /.dash-row --}}


        {{-- ─────────────────────────────────────────────────────────────────
        ROW 3 — FLEET STATUS + QUICK ACTIONS + RECENT ACTIVITY
        ───────────────────────────────────────────────────────────────── --}}
        <div class="dash-row dash-row--three">

            {{-- ── Fleet status mini-cards ── --}}
            <div class="dash-panel">
                <div class="panel-head">
                    <div>
                        <h2 class="panel-title">Fleet Status</h2>
                        <p class="panel-sub">38 buses total</p>
                    </div>
                    <a href="{{ route('admin.buses.index') }}" class="panel-link">
                        Manage <i class="fa-solid fa-arrow-right fa-xs"></i>
                    </a>
                </div>

                {{--
                TODO: replace static counts with $fleetStatus['active'],
                $fleetStatus['maintenance'], $fleetStatus['idle']
                --}}
                <div class="fleet-stat-list">
                    <div class="fleet-stat">
                        <div class="fleet-stat-icon fleet-stat-icon--green">
                            <i class="fa-solid fa-bus"></i>
                        </div>
                        <div class="fleet-stat-body">
                            <span class="fleet-stat-label">On Route</span>
                            <span class="fleet-stat-val">24</span>
                        </div>
                        <div class="fleet-stat-bar-wrap">
                            <div class="fleet-stat-bar fleet-stat-bar--green" style="width:63%"></div>
                        </div>
                    </div>
                    <div class="fleet-stat">
                        <div class="fleet-stat-icon fleet-stat-icon--amber">
                            <i class="fa-solid fa-wrench"></i>
                        </div>
                        <div class="fleet-stat-body">
                            <span class="fleet-stat-label">Maintenance</span>
                            <span class="fleet-stat-val">4</span>
                        </div>
                        <div class="fleet-stat-bar-wrap">
                            <div class="fleet-stat-bar fleet-stat-bar--amber" style="width:11%"></div>
                        </div>
                    </div>
                    <div class="fleet-stat">
                        <div class="fleet-stat-icon fleet-stat-icon--muted">
                            <i class="fa-solid fa-circle-pause"></i>
                        </div>
                        <div class="fleet-stat-body">
                            <span class="fleet-stat-label">Idle / Parked</span>
                            <span class="fleet-stat-val">10</span>
                        </div>
                        <div class="fleet-stat-bar-wrap">
                            <div class="fleet-stat-bar fleet-stat-bar--muted" style="width:26%"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Quick Actions ── --}}
            <div class="dash-panel">
                <div class="panel-head">
                    <h2 class="panel-title">Quick Actions</h2>
                </div>
                <div class="quick-actions">
                    <a href="{{ route('admin.bookings.create') }}" class="qa-btn">
                        <i class="fa-solid fa-plus"></i>
                        <span>New Booking</span>
                    </a>
                    <a href="{{ route('admin.trips.create') }}" class="qa-btn">
                        <i class="fa-solid fa-calendar-plus"></i>
                        <span>Schedule Trip</span>
                    </a>
                    <a href="{{ route('admin.buses.create') }}" class="qa-btn">
                        <i class="fa-solid fa-bus-simple"></i>
                        <span>Add Bus</span>
                    </a>
                    <a href="{{ route('admin.drivers.create') }}" class="qa-btn">
                        <i class="fa-solid fa-id-badge"></i>
                        <span>Add Driver</span>
                    </a>
                    <a href="{{ route('admin.promotions.create') }}" class="qa-btn">
                        <i class="fa-solid fa-tag"></i>
                        <span>New Promo</span>
                    </a>
                    <a href="{{ route('admin.routes.create') }}" class="qa-btn">
                        <i class="fa-solid fa-route"></i>
                        <span>New Route</span>
                    </a>
                </div>
            </div>

            {{-- ── Recent Activity feed ── --}}
            <div class="dash-panel">
                <div class="panel-head">
                    <div>
                        <h2 class="panel-title">Recent Activity</h2>
                        <p class="panel-sub">System events</p>
                    </div>
                </div>

                {{--
                TODO: replace with dynamic activity log from a polymorphic
                `activity_logs` table (consider spatie/laravel-activitylog).
                @foreach($recentActivity as $log) ... @endforeach
                --}}
                <div class="activity-feed">

                    <div class="activity-item">
                        <div class="act-icon act-icon--green">
                            <i class="fa-solid fa-ticket"></i>
                        </div>
                        <div class="act-body">
                            <span class="act-text">New booking <strong>#BK-3248</strong> confirmed</span>
                            <span class="act-time">2 min ago</span>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="act-icon act-icon--amber">
                            <i class="fa-solid fa-wrench"></i>
                        </div>
                        <div class="act-body">
                            <span class="act-text">Bus <strong>LVO-017</strong> flagged for maintenance</span>
                            <span class="act-time">18 min ago</span>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="act-icon act-icon--blue">
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                        <div class="act-body">
                            <span class="act-text">New passenger registered: <strong>Rosa P.</strong></span>
                            <span class="act-time">34 min ago</span>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="act-icon act-icon--red">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </div>
                        <div class="act-body">
                            <span class="act-text">Booking <strong>#BK-3241</strong> cancelled</span>
                            <span class="act-time">1 hr ago</span>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="act-icon act-icon--khaki">
                            <i class="fa-solid fa-tag"></i>
                        </div>
                        <div class="act-body">
                            <span class="act-text">Promo <strong>SUMMER25</strong> activated</span>
                            <span class="act-time">2 hr ago</span>
                        </div>
                    </div>

                </div>{{-- /.activity-feed --}}
            </div>

        </div>{{-- /.dash-row --}}

    @endsection{{-- /content --}}


    {{-- ══════════════════════════════════════════════════════════════════
    PAGE STYLES
    Scoped to the dashboard page only.
    TODO: move these to resources/css/pages/_dashboard.scss
    once SCSS partials are organised.
    ════════════════════════════════════════════════════════════════════ --}}
    @push('head')
        <style>
            

            /* ─────────── KPI GRID ─────────── */
            .kpi-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 20px;
                margin-bottom: 24px;
            }

            .kpi-card {
                background: var(--white);
                border: 1px solid var(--border);
                border-radius: var(--radius);
                padding: 20px;
                display: flex;
                align-items: flex-start;
                gap: 14px;
                box-shadow: var(--shadow);
                transition: box-shadow .2s, transform .2s;
                position: relative;
                overflow: hidden;
            }

            .kpi-card:hover {
                box-shadow: var(--shadow-hover);
                transform: translateY(-2px);
            }

            .kpi-icon {
                width: 44px;
                height: 44px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.1rem;
                flex-shrink: 0;
            }

            .kpi-icon--khaki {
                background: var(--khaki-bg);
                color: var(--khaki-dark);
            }

            .kpi-icon--green {
                background: var(--c-green-bg);
                color: var(--c-green);
            }

            .kpi-icon--blue {
                background: var(--c-blue-bg);
                color: var(--c-blue);
            }

            .kpi-icon--amber {
                background: var(--c-amber-bg);
                color: var(--c-amber);
            }

            .kpi-body {
                flex: 1;
                display: flex;
                flex-direction: column;
                gap: 4px;
            }

            .kpi-label {
                font-size: .74rem;
                font-weight: 600;
                color: var(--muted);
                text-transform: uppercase;
                letter-spacing: .8px;
            }

            .kpi-value {
                font-size: 1.55rem;
                font-weight: 800;
                color: var(--ink);
                line-height: 1.1;
            }

            .kpi-delta {
                font-size: .73rem;
                font-weight: 500;
                display: flex;
                align-items: center;
                gap: 4px;
            }

            .kpi-delta--up {
                color: var(--c-green);
            }

            .kpi-delta--neutral {
                color: var(--c-blue);
            }

            .kpi-delta--down {
                color: var(--c-red);
            }

            .kpi-spark {
                position: absolute;
                right: 12px;
                bottom: 12px;
                display: flex;
                align-items: flex-end;
                gap: 2px;
                height: 28px;
                opacity: .5;
            }

            .spark-bar {
                width: 4px;
                border-radius: 2px 2px 0 0;
                background: var(--khaki);
                transition: height .3s;
            }

            .spark-bar.hi {
                background: var(--khaki-dark);
                opacity: 1;
            }

            /* ─────────── DASH ROWS ─────────── */
            .dash-row {
                display: grid;
                grid-template-columns: 1fr 380px;
                gap: 20px;
                margin-bottom: 24px;
            }

            .dash-row--three {
                grid-template-columns: repeat(3, 1fr);
            }

            /* ─────────── PANEL ─────────── */
            .dash-panel {
                background: var(--white);
                border: 1px solid var(--border);
                border-radius: var(--radius);
                padding: 22px;
                box-shadow: var(--shadow);
            }

            .panel-head {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                margin-bottom: 18px;
                gap: 12px;
            }

            .panel-title {
                font-family: 'Playfair Display', serif;
                font-size: 1rem;
                font-weight: 700;
                color: var(--ink);
            }

            .panel-sub {
                font-size: .74rem;
                color: var(--muted);
                margin-top: 2px;
            }

            .panel-actions {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .panel-link {
                font-size: .75rem;
                font-weight: 600;
                color: var(--khaki-dark);
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 4px;
                transition: opacity .2s;
                white-space: nowrap;
            }

            .panel-link:hover {
                opacity: .7;
            }

            /* ─── Revenue Chart ─── */
            .rev-chart-wrap {
                height: 120px;
                display: flex;
                align-items: flex-end;
                gap: 3px;
                margin-bottom: 8px;
            }

            .rev-chart-wrap>div {
                flex: 1;
                border-radius: 3px 3px 0 0;
                cursor: default;
                transition: opacity .2s;
            }

            .rev-chart-wrap>div:hover {
                opacity: .7 !important;
            }

            .rev-chart-labels {
                display: flex;
                justify-content: space-between;
                font-size: .68rem;
                color: var(--muted);
                margin-top: 6px;
            }

            /* Tab bar */
            .tab-bar {
                display: flex;
                background: var(--bg3);
                border-radius: 7px;
                padding: 3px;
                gap: 2px;
            }

            .tab {
                padding: 5px 12px;
                border-radius: 5px;
                border: none;
                font-size: .75rem;
                font-weight: 600;
                cursor: pointer;
                font-family: 'Outfit', sans-serif;
                background: none;
                color: var(--muted);
                transition: all .2s;
            }

            .tab.active {
                background: var(--white);
                color: var(--khaki-dark);
                box-shadow: 0 1px 3px rgba(195, 176, 145, .2);
            }

            /* ─── Booking list ─── */
            .booking-list {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .booking-row {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 10px 12px;
                border-radius: var(--radius-sm);
                border: 1px solid var(--border);
                transition: background .2s;
            }

            .booking-row:hover {
                background: var(--khaki-bg);
            }

            .booking-avatar {
                width: 34px;
                height: 34px;
                border-radius: 50%;
                background: linear-gradient(135deg, var(--khaki), var(--khaki-dark));
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: .75rem;
                font-weight: 700;
                color: var(--white);
                flex-shrink: 0;
            }

            .booking-info {
                flex: 1;
                display: flex;
                flex-direction: column;
                min-width: 0;
            }

            .booking-name {
                font-size: .83rem;
                font-weight: 600;
                color: var(--ink);
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .booking-route {
                font-size: .72rem;
                color: var(--muted);
                margin-top: 2px;
                display: flex;
                align-items: center;
                gap: 4px;
            }

            .booking-status {
                font-size: .68rem;
                font-weight: 700;
                letter-spacing: .5px;
                text-transform: uppercase;
                padding: 3px 8px;
                border-radius: 20px;
                white-space: nowrap;
            }

            .booking-status--confirmed {
                background: var(--c-green-bg);
                color: var(--c-green);
            }

            .booking-status--pending {
                background: var(--c-amber-bg);
                color: var(--c-amber);
            }

            .booking-status--cancelled {
                background: var(--c-red-bg);
                color: var(--c-red);
            }

            /* ─── Fleet stats ─── */
            .fleet-stat-list {
                display: flex;
                flex-direction: column;
                gap: 16px;
            }

            .fleet-stat {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .fleet-stat-icon {
                width: 36px;
                height: 36px;
                border-radius: 9px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: .9rem;
                flex-shrink: 0;
            }

            .fleet-stat-icon--green {
                background: var(--c-green-bg);
                color: var(--c-green);
            }

            .fleet-stat-icon--amber {
                background: var(--c-amber-bg);
                color: var(--c-amber);
            }

            .fleet-stat-icon--muted {
                background: var(--bg3);
                color: var(--muted);
            }

            .fleet-stat-body {
                flex: 1;
                min-width: 0;
            }

            .fleet-stat-label {
                font-size: .74rem;
                color: var(--muted);
                display: block;
            }

            .fleet-stat-val {
                font-size: 1.1rem;
                font-weight: 800;
                color: var(--ink);
            }

            .fleet-stat-bar-wrap {
                width: 60px;
                height: 6px;
                background: var(--bg3);
                border-radius: 3px;
                overflow: hidden;
                flex-shrink: 0;
            }

            .fleet-stat-bar {
                height: 100%;
                border-radius: 3px;
                transition: width .6s ease;
            }

            .fleet-stat-bar--green {
                background: var(--c-green);
            }

            .fleet-stat-bar--amber {
                background: var(--c-amber);
            }

            .fleet-stat-bar--muted {
                background: var(--muted-lt);
            }

            /* ─── Quick Actions ─── */
            .quick-actions {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 10px;
            }

            .qa-btn {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 7px;
                padding: 14px 10px;
                border: 1px solid var(--border);
                border-radius: var(--radius-sm);
                background: var(--bg);
                text-decoration: none;
                color: var(--text-dim);
                font-size: .75rem;
                font-weight: 600;
                transition: all .2s;
                text-align: center;
            }

            .qa-btn i {
                font-size: 1.1rem;
                color: var(--khaki-dark);
                transition: transform .2s;
            }

            .qa-btn:hover {
                background: var(--khaki-bg);
                border-color: var(--khaki-light);
                color: var(--khaki-dark);
                transform: translateY(-2px);
                box-shadow: 0 2px 8px rgba(195, 176, 145, .15);
            }

            .qa-btn:hover i {
                transform: scale(1.15);
            }

            /* ─── Activity feed ─── */
            .activity-feed {
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .activity-item {
                display: flex;
                align-items: flex-start;
                gap: 12px;
            }

            .act-icon {
                width: 34px;
                height: 34px;
                border-radius: 9px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: .9rem;
                flex-shrink: 0;
            }

            .act-icon--green {
                background: var(--c-green-bg);
                color: var(--c-green);
            }

            .act-icon--amber {
                background: var(--c-amber-bg);
                color: var(--c-amber);
            }

            .act-icon--blue {
                background: var(--c-blue-bg);
                color: var(--c-blue);
            }

            .act-icon--red {
                background: var(--c-red-bg);
                color: var(--c-red);
            }

            .act-icon--khaki {
                background: var(--khaki-bg);
                color: var(--khaki-dark);
            }

            .act-body {
                flex: 1;
            }

            .act-text {
                font-size: .82rem;
                color: var(--ink-soft);
                display: block;
                line-height: 1.4;
            }

            .act-text strong {
                color: var(--ink);
            }

            .act-time {
                font-size: .71rem;
                color: var(--muted);
                margin-top: 2px;
                display: block;
            }

            /* ─────────── RESPONSIVE ─────────── */
            @media (max-width: 1280px) {
                .kpi-grid {
                    grid-template-columns: repeat(2, 1fr);
                }

                .dash-row {
                    grid-template-columns: 1fr;
                }

                .dash-row--three {
                    grid-template-columns: 1fr 1fr;
                }
            }

            @media (max-width: 900px) {
                .dash-row--three {
                    grid-template-columns: 1fr;
                }
            }

            @media (max-width: 768px) {
                .sidebar {
                    transform: translateX(-100%);
                }

                .sidebar.open {
                    transform: translateX(0);
                }

                .main-wrapper {
                    margin-left: 0;
                }

                .topbar-toggle {
                    display: flex;
                }

                .topbar-search,
                .topbar-date {
                    display: none;
                }

                .main-content {
                    padding: 18px 16px;
                }

                .kpi-grid {
                    grid-template-columns: 1fr 1fr;
                    gap: 12px;
                }

                .quick-actions {
                    grid-template-columns: repeat(2, 1fr);
                }
            }

            @media (max-width: 480px) {
                .kpi-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    @endpush


    {{-- ══════════════════════════════════════════════════════════════════
    PAGE SCRIPTS
    ════════════════════════════════════════════════════════════════════ --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                // ── Revenue / Booking sparklines on KPI cards ──
                function renderSpark(containerId, data, color) {
                    const el = document.getElementById(containerId);
                    if (!el) return;
                    const max = Math.max(...data);
                    el.innerHTML = data.map((v, i) => {
                        const h = Math.round((v / max) * 22) + 4;
                        const isLast = i === data.length - 1;
                        return `<div class="spark-bar${isLast ? ' hi' : ''}"
                             style="height:${h}px;background:${color || 'var(--khaki)'}"></div>`;
                    }).join('');
                }

                // TODO: replace these with real data passed as JSON from controller
                // e.g.  const revData = @json($revenueChart);
                const revData = [62, 78, 54, 91, 83, 70, 88, 95, 72, 86, 90, 104, 88, 112, 98, 87, 120, 130, 115, 140];
                const bkData = [28, 35, 22, 42, 38, 30, 45, 48, 32, 40, 44, 52, 41, 56, 49, 38, 60, 65, 58, 70];

                renderSpark('kpi-spark-revenue', revData.slice(-10));
                renderSpark('kpi-spark-bookings', bkData.slice(-10));

                // ── Main revenue/booking chart ──
                function buildRevChart(data, label) {
                    const el = document.getElementById('rev-chart');
                    if (!el) return;
                    const max = Math.max(...data);
                    el.innerHTML = data.map((v, i) => {
                        const h = Math.round((v / max) * 110) + 8;
                        const isToday = i === data.length - 1;
                        const color = isToday ? 'var(--khaki-dark)' : 'rgba(195,176,145,0.4)';
                        const day = i + 1;
                        return `<div style="flex:1;height:${h}px;background:${color};
                             border-radius:3px 3px 0 0;cursor:default;transition:all .2s"
                             title="${label} — Day ${day}: ${v}"
                             onmouseenter="this.style.opacity='.75'"
                             onmouseleave="this.style.opacity='1'"></div>`;
                    }).join('');
                }

                // Initialise with revenue
                buildRevChart(revData, 'Revenue (₱k)');

                // Tab switcher
                document.querySelectorAll('.tab').forEach(tab => {
                    tab.addEventListener('click', function () {
                        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                        this.classList.add('active');
                        if (this.dataset.tab === 'bookings') {
                            buildRevChart(bkData, 'Bookings');
                        } else {
                            buildRevChart(revData, 'Revenue (₱k)');
                        }
                    });
                });

            });
        </script>
    @endpush