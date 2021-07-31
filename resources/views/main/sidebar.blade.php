<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-heartbeat"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin<sup>Inc</sup></div>
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
        Gallery
    </div>
    
    <li class="nav-item {{ $sidebar == 'gallery' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('get.list-gallery') }}">
            <i class="fas fa-fw fa-images"></i>
            <span>Manage Gallery</span>
        </a>
    </li>
    
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Jobs
    </div>
    <!-- Nav Item - Charts -->
    <li class="nav-item {{ $sidebar == 'jobs' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('get.list-jobs') }}">
            <i class="fas fa-fw fa-handshake"></i>
            <span>Manage Jobs</span>
        </a>
    </li>
    <!-- Nav Item - Tables -->
    <li class="nav-item {{ $sidebar == 'applicant' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('get.list-applicant') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Manage Applicant</span>
        </a>
    </li>
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