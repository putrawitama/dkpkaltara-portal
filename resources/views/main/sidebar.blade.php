<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon">
            <!-- <i class="fas fa-heartbeat"></i> -->
            <img src="{{ asset('img/logo/logo.png') }}" alt="logo" height=50>
        </div>
        <div class="sidebar-brand-text mx-3">DKP Kaltara</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ $sidebar == 'dashboard' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Managements
    </div>
    
    <li class="nav-item {{ $sidebar == 'gallery' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('get.list-gallery') }}">
            <i class="fas fa-fw fa-images"></i>
            <span>Manage Gallery</span>
        </a>
    </li>

    <li class="nav-item {{ $sidebar == 'menu' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('get.list-menu') }}">
            <i class="fas fa-fw fa-bars"></i>
            <span>Manage Menu</span>
        </a>
    </li>

    <li class="nav-item {{ $sidebar == 'external' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('get.list-external') }}">
            <i class="fas fa-fw fa-link"></i>
            <span>Manage External Link</span>
        </a>
    </li>
    
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Articles
    </div>
    <!-- Nav Item - Charts -->
    <li class="nav-item {{ $sidebar == 'article' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('get.list-article') }}">
            <i class="fas fa-fw fa-handshake"></i>
            <span>Manage Article</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Mails
    </div>
    <!-- Nav Item - Charts -->
    <li class="nav-item {{ $sidebar == 'mail' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('get.list-mail') }}">
            <i class="fas fa-fw fa-inbox"></i>
            <span>Manage Inbox</span>
        </a>
    </li>
    <!-- Nav Item - Tables -->
    <!-- <li class="nav-item {{ $sidebar == 'applicant' ? 'active' : '' }}">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Manage Applicant</span>
        </a>
    </li> -->
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
    <!-- Sidebar Message -->
    <!-- <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
        <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
    </div> -->
</ul>
<!-- End of Sidebar -->