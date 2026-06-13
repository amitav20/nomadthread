<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'LeatherCraft — Admin Panel')</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.31.0/dist/tabler-icons.min.css">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="admin-body">

<!-- SIDEBAR -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-mark">
      <div class="logo-icon"><i class="ti ti-briefcase"></i></div>
      <div><div class="logo-text">NomadThread</div><div class="logo-sub">Admin Panel</div></div>
    </div>
  </div>
  <div class="sidebar-section">
    <div class="sidebar-section-label">Main</div>
    <a href="{{ route('backend.dashboard') }}" class="nav-item {{ Route::is('backend.dashboard') ? 'active' : '' }}"><i class="ti ti-layout-dashboard"></i> Dashboard</a>
    <a href="{{ route('backend.analytics') }}" class="nav-item {{ Route::is('backend.analytics') ? 'active' : '' }}"><i class="ti ti-chart-line"></i> Analytics</a>
  </div>
  <div class="sidebar-section">
    <div class="sidebar-section-label">Catalogue</div>
    <a href="{{ route('backend.products.create') }}" class="nav-item {{ Route::is('backend.products.create') ? 'active' : '' }}"><i class="ti ti-circle-plus"></i> Add Product</a>
    <a href="{{ route('backend.products.index') }}" class="nav-item {{ Route::is('backend.products.index') ? 'active' : '' }}"><i class="ti ti-package"></i> All Products <span class="nav-badge gold">142</span></a>
    <a href="{{ route('backend.categories.create') }}" class="nav-item {{ Route::is('backend.categories.create') ? 'active' : '' }}"><i class="ti ti-folder-plus"></i> Add Category</a>
    <a href="{{ route('backend.categories.index') }}" class="nav-item {{ Route::is('backend.categories.index') ? 'active' : '' }}"><i class="ti ti-tag"></i> All Categories</a>
    <a href="{{ route('backend.inventory') }}" class="nav-item {{ Route::is('backend.inventory') ? 'active' : '' }}"><i class="ti ti-stack"></i> Inventory</a>
  </div>
  <div class="sidebar-section">
    <div class="sidebar-section-label">Sales</div>
    <a href="{{ route('backend.orders') }}" class="nav-item {{ Route::is('backend.orders') ? 'active' : '' }}"><i class="ti ti-shopping-cart"></i> Orders <span class="nav-badge">7</span></a>
    <a href="{{ route('backend.customers') }}" class="nav-item {{ Route::is('backend.customers') ? 'active' : '' }}"><i class="ti ti-users"></i> Customers</a>
    <a href="{{ route('backend.reviews') }}" class="nav-item {{ Route::is('backend.reviews') ? 'active' : '' }}"><i class="ti ti-star"></i> Reviews</a>
  </div>
  <div class="sidebar-section">
    <div class="sidebar-section-label">Marketing</div>
    <a href="{{ route('backend.banners.index') }}" class="nav-item {{ Route::is('backend.banners.index') ? 'active' : '' }}"><i class="ti ti-photo"></i> Banners</a>
    <a href="{{ route('backend.banners.create') }}" class="nav-item {{ Route::is('backend.banners.create') ? 'active' : '' }}"><i class="ti ti-photo-plus"></i> Upload Banner</a>
    <a href="{{ route('backend.coupons') }}" class="nav-item {{ Route::is('backend.coupons') ? 'active' : '' }}"><i class="ti ti-ticket"></i> Coupons</a>
  </div>
  <div class="sidebar-section">
    <div class="sidebar-section-label">Website</div>
    <a href="{{ route('backend.pages.index') }}" class="nav-item {{ Route::is('backend.pages.index') ? 'active' : '' }}"><i class="ti ti-file-text"></i> Pages</a>
    <a href="{{ route('backend.pages.create') }}" class="nav-item {{ Route::is('backend.pages.create') ? 'active' : '' }}"><i class="ti ti-file-plus"></i> Add Page</a>
  </div>
  <div class="sidebar-section">
    <div class="sidebar-section-label">Config</div>
    <a href="{{ route('backend.shipping') }}" class="nav-item {{ Route::is('backend.shipping') ? 'active' : '' }}"><i class="ti ti-truck"></i> Shipping</a>
    <a href="{{ route('backend.payments') }}" class="nav-item {{ Route::is('backend.payments') ? 'active' : '' }}"><i class="ti ti-credit-card"></i> Payments</a>
    <a href="{{ route('backend.countries.index') }}" class="nav-item {{ Route::is('backend.countries.*') ? 'active' : '' }}"><i class="ti ti-world"></i> Countries</a>
    <a href="{{ route('backend.settings') }}" class="nav-item {{ Route::is('backend.settings') ? 'active' : '' }}"><i class="ti ti-settings"></i> Settings</a>
  </div>
  <div class="sidebar-footer">
    @if(Auth::check())
    <div class="admin-avatar admin-avatar-wrap">
      <div class="admin-avatar-inner">
        <div class="avatar-circle flex-shrink-0">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
        <div class="avatar-info avatar-info-wrap">
          <p class="avatar-name">{{ Auth::user()->name }}</p>
          <span class="avatar-role">{{ Auth::user()->role === 'admin' ? 'Administrator' : 'User' }}</span>
        </div>
      </div>
      <form action="{{ route('backend.logout') }}" method="POST" class="admin-logout-form">
        @csrf
        <button type="submit" class="admin-logout-btn" title="Logout">
          <i class="ti ti-logout fs-18"></i>
        </button>
      </form>
    </div>
    @endif
  </div>
</aside>

<!-- MAIN -->
<div class="main">
  <header class="header">
    <div>
      <div class="header-title" id="pageTitle">@yield('page_title', 'Dashboard')</div>
      <div class="header-breadcrumb" id="pageBreadcrumb">@yield('page_breadcrumb', 'Admin / Dashboard')</div>
    </div>
    <div class="header-search">
      <i class="ti ti-search text3-color"></i>
      <input type="text" placeholder="Search products, orders…">
    </div>
    <div class="header-actions">
      <div class="icon-btn"><i class="ti ti-bell"></i><div class="notif-dot"></div></div>
      <div class="icon-btn"><i class="ti ti-moon"></i></div>
      <div class="icon-btn"><i class="ti ti-help-circle"></i></div>
    </div>
  </header>

  <div class="content">
    @yield('content')
  </div><!-- /content -->
</div><!-- /main -->

<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
