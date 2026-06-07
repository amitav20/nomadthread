<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="NOMAD THREAD — Premium full-grain leather goods handcrafted by master artisans. Built to last a lifetime and grow more beautiful with every use." />
  <title>@yield('title', 'NOMAD THREAD — Artisan Leather Goods')</title>
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,800;1,400&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
  
  <!-- Premium Artisan Stylesheet -->
  <link href="{{ asset('css/ecommerce.css') }}" rel="stylesheet" />

  <style>
    .mega-menu {
      z-index: 1100;
    }
  </style>

  <script>
    window.routes = {
      apiProducts: "{{ route('api.products') }}",
      productShow: "{{ route('shop.product', ['sku' => 'PLACEHOLDER']) }}"
    };
  </script>
</head>
<body>

  <!-- CUSTOM CURSOR -->
  <div class="cursor" id="cursor"></div>
  <div class="cursor-ring" id="cursorRing"></div>

  <!-- DRAWER OVERLAY -->
  <div class="drawer-overlay" id="drawerOverlay" onclick="closeCart()"></div>

  <!-- CART DRAWER -->
  <div class="cart-drawer" id="cartDrawer">
    <div class="cart-drawer-header">
      <span class="cart-drawer-title">Your Cart</span>
      <button class="icon-btn modal-close" onclick="closeCart()">✕</button>
    </div>
    <div class="cart-items" id="cartItems">
      <!-- Cart items injected here dynamically -->
    </div>
    <div class="cart-footer">
      <div class="cart-subtotal">
        <span>Subtotal</span>
        <span class="cart-total-num" id="cartTotal">₹0</span>
      </div>
      <button class="btn-checkout" onclick="showToast('Checkout flow simulated!')">Proceed to Checkout</button>
      <button class="btn-continue" onclick="closeCart()">Continue Shopping</button>
    </div>
  </div>

  <!-- PRODUCT QUICK VIEW MODAL -->
  <div class="modal-overlay" id="modalOverlay" onclick="closeModal(event)">
    <div class="modal" id="modalContent">
      <div class="modal-img" style="display: flex; flex-direction: column; gap: 20px; padding: 40px; min-height: 460px; justify-content: center; align-items: center;">
        <button class="modal-close" onclick="closeModalDirect()" style="z-index:20;">✕</button>
        <div id="modalMainContainer" style="position: relative; display: flex; align-items: center; justify-content: center; width: 100%; min-height: 280px;">
          <div class="product-visual modal-img-visual" id="modalVisual"></div>
        </div>
        <div id="modalProductThumbs" style="display: flex; gap: 8px; overflow-x: auto; width: 100%; justify-content: center; z-index: 10;"></div>
      </div>
      <div class="modal-detail">
        <div class="product-type" id="modalType">Leather Bags</div>
        <div class="product-name" id="modalName">Product Name</div>
        <div class="modal-rating">
          <span class="stars">★★★★★</span>
          <span class="rating-count">(124 reviews)</span>
        </div>
        <div class="product-price">
          <span class="price-current" id="modalPrice">₹12,000</span>
        </div>
        <p class="modal-desc" id="modalDesc">Premium full-grain leather, hand-stitched by skilled artisans using traditional techniques. Each piece develops a unique patina over time.</p>
        <div class="modal-section">
          <h5>Choose Color</h5>
          <div class="color-options" id="modalColors"></div>
        </div>
        <div class="modal-actions">
          <button class="btn-add-full" id="modalAddBtn">Add to Cart — <span id="modalAddPrice">₹12,000</span></button>
          <button class="btn-wishlist-full" onclick="showToast('Added to wishlist!')">♡ Add to Wishlist</button>
        </div>
      </div>
    </div>
  </div>

  <!-- TOAST -->
  <div class="toast" id="toast"><span class="toast-icon">✓</span><span id="toastMsg">Added to cart</span></div>

  <!-- TOP BAR -->
  <div class="top-bar">
    {!! $siteSettings['top_bar_text'] ?? '<span>✦</span> Free shipping on orders above ₹5,000 &nbsp;|&nbsp; Handcrafted with full-grain leather &nbsp;|&nbsp; <span>✦</span> 10% off on first order — Use CRAFT10' !!}
  </div>

  <!-- HEADER -->
  <header>
    <div class="header-inner">
      <a href="{{ route('home') }}" class="logo-wrap" style="display: inline-flex; align-items: center; gap: 10px; text-decoration: none;">
        @if(!empty($siteSettings['logo_image']))
          <img src="{{ asset($siteSettings['logo_image']) }}" alt="Logo" style="height: 32px; width: auto; border-radius: 4px;">
        @else
          <img src="{{ asset('images/logo.jpg') }}" alt="Logo" style="height: 32px; width: auto; border-radius: 4px;">
        @endif
        <span class="logo" style="color: #dfc049;">{{ $siteSettings['logo_text'] ?? 'NOMAD THREAD' }}</span>
      </a>
      <nav>
        <a href="{{ route('home') }}" class="nav-item {{ Route::is('home') ? 'active' : '' }}">Home</a>
        <a href="{{ route('shop.index') }}" class="nav-item {{ Route::is('shop.index') && !Request::routeIs('shop.category') ? 'active' : '' }}">Shop</a>
        
        @foreach($sharedCategories as $cat)
          <a href="{{ route('shop.category', $cat->slug) }}" class="nav-item {{ Request::is('category/' . $cat->slug) ? 'active' : '' }}">{{ $cat->name }}</a>
        @endforeach

        <a href="{{ Route::is('home') ? '#about' : route('home').'#about' }}" class="nav-item">Our Craft</a>
        <a href="{{ route('threads.index') }}" class="nav-item {{ Route::is('threads.*') ? 'active' : '' }}">Discussions</a>
      </nav>
      <div class="header-actions">
        <button class="icon-btn" title="Search" onclick="showToast('Search modal simulated!')">⌕</button>
        <button class="icon-btn" title="Wishlist" onclick="showToast('Your wishlist contains 0 items.')">♡</button>
        <a href="{{ route('backend.dashboard') }}" class="icon-btn" title="Admin Dashboard" style="text-decoration:none">⊙</a>
        <button class="icon-btn" title="Cart" onclick="openCart()" style="position:relative">
          🛍
          <span class="cart-count" id="cartBadge">0</span>
        </button>
      </div>
    </div>
  </header>

  <!-- MAIN CONTENT -->
  <main>
    @yield('content')
  </main>

  <!-- FOOTER -->
  <footer>
    <div class="footer-inner">
      <div class="footer-brand">
        <a href="{{ route('home') }}" class="logo-wrap" style="display: inline-flex; align-items: center; gap: 10px; text-decoration: none;">
          @if(!empty($siteSettings['logo_image']))
            <img src="{{ asset($siteSettings['logo_image']) }}" alt="Logo" style="height: 32px; width: auto; border-radius: 4px; filter: brightness(1.2);">
          @else
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo" style="height: 32px; width: auto; border-radius: 4px; filter: brightness(1.2);">
          @endif
          <span class="logo" style="color: var(--cream);">{{ $siteSettings['logo_text'] ?? 'NOMAD THREAD' }}</span>
        </a>
        <p class="footer-tagline">{{ $siteSettings['footer_tagline'] ?? 'Artisan leather goods handcrafted in India, built to last a lifetime and grow more beautiful with every use.' }}</p>
        <div class="footer-social">
          <a href="{{ $siteSettings['facebook_link'] ?? '#' }}" class="social-link" target="_blank">f</a>
          <a href="{{ $siteSettings['linkedin_link'] ?? '#' }}" class="social-link" target="_blank">in</a>
          <a href="{{ $siteSettings['instagram_link'] ?? '#' }}" class="social-link" target="_blank">📷</a>
          <a href="{{ $siteSettings['youtube_link'] ?? '#' }}" class="social-link" target="_blank">▶</a>
        </div>
      </div>
      <div class="footer-col">
        <h5>Shop</h5>
        <a href="{{ route('shop.index') }}?new=1">New Arrivals</a>
        @foreach($sharedCategories as $cat)
          <a href="{{ route('shop.category', $cat->slug) }}">{{ $cat->name }}</a>
        @endforeach
      </div>
      <div class="footer-col">
        <h5>Collections</h5>
        <a href="{{ Route::is('home') ? '#hero' : route('home') }}">Classic Series</a>
        <a href="{{ Route::is('home') ? '#hero' : route('home') }}">Wingman Edit</a>
        <a href="{{ Route::is('home') ? '#hero' : route('home') }}">Men's Edit</a>
        <a href="{{ Route::is('home') ? '#hero' : route('home') }}">Women's Edit</a>
      </div>
      <div class="footer-col">
        <h5>Company</h5>
        @if($sharedPages->where('show_in_footer', true)->isNotEmpty())
          @foreach($sharedPages->where('show_in_footer', true) as $p)
            <a href="{{ route('pages.show', $p->slug) }}">{{ $p->title }}</a>
          @endforeach
        @else
          <a href="{{ Route::is('home') ? '#about' : route('home').'#about' }}">Our Story</a>
          <a href="{{ Route::is('home') ? '#about' : route('home').'#about' }}">Artisans</a>
          <a href="{{ Route::is('home') ? '#about' : route('home').'#about' }}">Sustainability</a>
        @endif
      </div>
      <div class="footer-col">
        <h5>Help</h5>
        <a href="#" onclick="event.preventDefault(); showToast('Shipping details overlay!')">Shipping & Returns</a>
        <a href="#" onclick="event.preventDefault(); showToast('Support contact details!')">Contact Us</a>
        <a href="{{ route('threads.index') }}">Discussions Forum</a>
      </div>
    </div>
    <div class="footer-bottom">
      <span class="footer-copy">© {{ date('Y') }} {{ $siteSettings['copyright_text'] ?? 'Nomad Thread. Made with ♥ in India.' }}</span>
      <div class="footer-legal">
        <a href="#" onclick="event.preventDefault(); showToast('Privacy Policy')">Privacy Policy</a>
        <a href="#" onclick="event.preventDefault(); showToast('Terms of Service')">Terms of Service</a>
      </div>
    </div>
  </footer>

  <!-- SCROLL TO TOP -->
  <button class="scroll-top" id="scrollTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">↑</button>

  <!-- Interactive JavaScript -->
  <script src="{{ asset('js/ecommerce.js') }}"></script>
</body>
</html>
