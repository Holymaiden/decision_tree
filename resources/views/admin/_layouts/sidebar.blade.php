<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('admin') }}">Admin</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('admin') }}">A</a>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-header">Main Menu</li>
            <li class="@stack('dashboard')">
                <a class="nav-link" href="{{ url('admin') }}">
                    <i class="fas fa-fire"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="@stack('users')">
                <a class="nav-link" href="{{ route('users') }}">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </li>
            <li class="@stack('drugs')">
                <a class="nav-link" href="{{ route('drugs') }}">
                    <i class="fas fa-capsules"></i>
                    <span>Obat</span>
                </a>
            </li>
            <li class="@stack('transactions')">
                <a class="nav-link" href="{{ route('transactions') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Transaksi</span>
                </a>
            </li>
            <!-- <li class="@stack('sales')">
                <a class="nav-link" href="{{ route('sales') }}">
                    </i><i class="fas fa-hands-helping"></i>
                    <span>Penjualan</span>
                </a>
            </li> -->
        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="{{ route('logout') }}" class="btn btn-danger btn-lg btn-block btn-icon-split">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>

    </aside>
</div>