<aside id="sidebar" class="sidebar">

    <div class="sidebar-brand">
        <div class="brand-mark">
            <i class="fa-solid fa-bus"></i>
        </div>
        <span class="brand-text">LO<span>V</span>O</span>
        <span class="brand-badge">Admin</span>
    </div>

    <nav class="sidebar-nav" aria-label="Admin navigation">

        <div class="nav-group-label">Overview</div>
        <a href="{{ route('admin.dashboard') }}"
            class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-chart-pie"></i></span> Dashboard
        </a>
        <a href="{{ route('admin.analytics') }}"
            class="nav-item {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-chart-line"></i></span> Analytics
        </a>

        <div class="nav-group-label">Operations</div>
        <a href="{{ route('admin.bookings.index') }}"
            class="nav-item {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-ticket"></i></span> Bookings
            <span class="nav-badge">12</span>
        </a>
        <a href="{{ route('admin.trips.index') }}"
            class="nav-item {{ request()->routeIs('admin.trips.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-location-dot"></i></span> Trips & Schedules
        </a>
        <a href="{{ route('admin.routes.index') }}"
            class="nav-item {{ request()->routeIs('admin.routes.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-route"></i></span> Routes
        </a>
        <a href="{{ route('admin.payments.index') }}"
            class="nav-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-credit-card"></i></span> Payments
        </a>
        <a href="{{ route('admin.promotions.index') }}"
            class="nav-item {{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-tag"></i></span> Promotions
            <span class="nav-badge gold">3</span>
        </a>

        <div class="nav-group-label">Fleet</div>
        <a href="{{ route('admin.buses.index') }}"
            class="nav-item {{ request()->routeIs('admin.buses.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-bus"></i></span> Buses
        </a>
        <a href="{{ route('admin.bus-types.index') }}"
            class="nav-item {{ request()->routeIs('admin.bus-types.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-couch"></i></span> Bus Types
        </a>
        <a href="{{ route('admin.seats.index') }}"
            class="nav-item {{ request()->routeIs('admin.seats.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-chair"></i></span> Seats & Layouts
        </a>
        <a href="{{ route('admin.maintenance.index') }}"
            class="nav-item {{ request()->routeIs('admin.maintenance.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-wrench"></i></span> Maintenance
            <span class="nav-badge">2</span>
        </a>

        <div class="nav-group-label">People</div>
        <a href="{{ route('admin.users.index') }}"
            class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-users"></i></span> Users
        </a>
        <a href="{{ route('admin.drivers.index') }}"
            class="nav-item {{ request()->routeIs('admin.drivers.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-id-badge"></i></span> Drivers
        </a>
        <a href="{{ route('admin.feedback.index') }}"
            class="nav-item {{ request()->routeIs('admin.feedback.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-comments"></i></span> Feedback
            <span class="nav-badge">5</span>
        </a>

        <div class="nav-group-label">System</div>
        <a href="{{ route('admin.roles.index') }}"
            class="nav-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-shield-halved"></i></span> Roles & Permissions
        </a>
        <a href="{{ route('admin.notifications.index') }}"
            class="nav-item {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-bell"></i></span> Notifications
        </a>
        <a href="{{ route('admin.cities.index') }}"
            class="nav-item {{ request()->routeIs('admin.cities.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-city"></i></span> Cities
        </a>

    </nav>

    <div class="sidebar-footer">
        <div class="sf-avatar">
            {{ strtoupper(substr(auth()->user()->name ?? 'Admin', 0, 1)) }}
            {{ strtoupper(substr(explode(' ', auth()->user()->name ?? 'AD')[1] ?? 'D', 0, 1)) }}
        </div>
        <div class="sf-info">
            <div class="sf-name">{{ auth()->user()->name ?? 'Admin User' }}</div>
            <div class="sf-role">{{ auth()->user()->role?->name ?? 'Super Administrator' }}</div>
        </div>
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
            <button type="submit" class="sf-logout" title="Logout">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </button>
        </form>
    </div>

</aside>