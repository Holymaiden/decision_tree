<nav class="navbar navbar-expand-lg main-navbar">
    <a href="{{ route('home') }}" class="navbar-brand sidebar-gone-hide">Apotek Narisa</a>
    <div class="navbar-nav">
        <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
    </div>
    <div class="nav-collapse">
        <a class="sidebar-gone-show nav-collapse-toggle nav-link" href="{{ route('home') }}">
            <i class="fas fa-ellipsis-v"></i>
        </a>

    </div>
    <form class="form-inline ml-auto">
        <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" id="pencarian" aria-label="Search" data-width="250">
            <button class="btn" type="submit" id="btnSearch"><i class="fas fa-search"></i></button>
            <div class="search-backdrop"></div>
            <div class="search-result">
                <div class="search-header">
                    Kata Kunci
                </div>
            </div>
        </div>
    </form>
    <ul class="navbar-nav navbar-right">

        <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('stisla') }}/assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->email }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Admin</div>
                <a href="{{ route('dashboard') }}" class="dropdown-item has-icon text-success">
                    <i class="fas fa-user"></i> Dashboard
                </a>
                <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>


<nav class="navbar navbar-secondary navbar-expand-lg">
    <div class="container">
        <ul class="navbar-nav">
            <li class="nav-item @stack('home')">
                <a href="{{ route('home') }}" class="nav-link"><i class="fas fa-search"></i><span>Pencarian</span></a>
            </li>
            <li class="nav-item @stack('carts')">
                <a href="{{ route('carts') }}" class="nav-link"><i class="fas fa-capsules"></i><span>Keranjang Obat</span></a>
            </li>
        </ul>
    </div>
</nav>