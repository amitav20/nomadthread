@extends('layouts.frontend')

@section('title', 'Nomad Thread — Premium Handcrafted Leather Goods')

@section('content')
@php
  $shopBanner = collect($banners)->firstWhere('position', 'Shop Hero');
@endphp

@if($shopBanner)
  <section class="page-hero-section">
    @if(!empty($shopBanner['video']))
      <video autoplay loop muted playsinline class="page-hero-video">
        <source src="{{ asset($shopBanner['video']) }}" type="video/mp4">
      </video>
    @elseif(!empty($shopBanner['image']))
      <div class="page-hero-bg-img" style="background-image: url('{{ asset($shopBanner['image']) }}');"></div>
    @endif
    <div class="page-hero-overlay"></div>
    <div class="section-inner position-relative z-20">
      <span class="page-hero-subHeadline">
        {{ $shopBanner['subheadline'] ?? 'Nomad Thread Catalog' }}
      </span>
      <h1 class="page-hero-headline">
        <em>{{ $shopBanner['title'] }}</em>
      </h1>
      @if(!empty($shopBanner['cta_text']))
        <a href="{{ $shopBanner['cta_link'] ?? '#' }}" class="btn-primary page-hero-cta"><span>{{ $shopBanner['cta_text'] }}</span></a>
      @endif
    </div>
  </section>
@endif

<section class="products-section products-section-wrap {{ $shopBanner ? 'has-banner' : 'no-banner' }}">
  <div class="section-inner">
    @if(!$shopBanner)
      <div class="section-header reveal visible">
        <span class="section-tag">Nomad Thread Catalog</span>
        <h2 class="section-title">Timeless <em>Leather Craft</em></h2>
        <p class="section-sub">Explore our curated collections of premium bags, wallets, and handcrafted accessories.</p>
      </div>
    @endif

    <!-- Category Filter Bar -->
    <div class="filter-bar reveal visible catalog-filter-bar">
      <a href="{{ route('shop.index') }}" class="filter-btn active text-decoration-none" data-category="all">All</a>
      @foreach($categories as $cat)
        <a href="{{ route('shop.category', $cat['slug']) }}" class="filter-btn text-decoration-none" data-category="{{ $cat['slug'] }}">
          {{ $cat['name'] }}
        </a>
      @endforeach
    </div>

    <!-- Gender Filter Bar -->
    <div class="gender-filter-bar reveal visible catalog-gender-filter-bar">
      <span class="gender-label">Collection For:</span>
      <button onclick="filterByGender('all')" class="gender-btn active" id="gender-all">All</button>
      <button onclick="filterByGender('men')" class="gender-btn" id="gender-men">Men</button>
      <button onclick="filterByGender('women')" class="gender-btn" id="gender-women">Women</button>
    </div>

    <!-- Toggle Advanced Filters -->
    <div class="reveal visible catalog-toggle-wrapper">
      <button id="filterPanelToggleBtn" onclick="toggleFilterPanel()" class="gender-btn filter-toggle-btn">
        Filter Catalog &darr;
      </button>
    </div>

    <!-- Advanced Filter Panel -->
    <div id="advancedFilterPanel" class="reveal visible catalog-advanced-filter-panel">
      <div class="filter-grid-4col">
        
        <!-- Search -->
        <div>
          <h5 class="filter-column-title">Search</h5>
          <input type="text" id="filterSearchInput" oninput="handleSearchInput(this.value)" placeholder="Search products..." class="filter-search-input">
        </div>

        <!-- Price Range -->
        <div>
          <h5 class="filter-column-title-price">
            Max Price: <span id="priceRangeLabel" class="price-range-label">₹50,000</span>
          </h5>
          <input type="range" id="filterPriceRange" min="1000" max="50000" step="500" value="50000" oninput="updatePriceLabel(this.value); triggerFilters();" class="price-range-slider">
          <div class="price-range-footer">
            <span>₹1,000</span>
            <span>₹50,000</span>
          </div>
        </div>

        <!-- Sort By -->
        <div>
          <h5 class="filter-column-title">Sort By</h5>
          <select id="filterSortSelect" onchange="handleSortSelect(this.value)" class="sort-select">
            <option value="default">Default Sorting</option>
            <option value="price-low">Price: Low to High</option>
            <option value="price-high">Price: High to Low</option>
            <option value="name-az">Name: A-Z</option>
            <option value="newest">Newest Arrivals</option>
          </select>
        </div>

        <!-- Filter Colors -->
        <div>
          <h5 class="filter-column-title">Colors</h5>
          <div class="color-swatch-wrapper">
            @php
              $allColors = ['tan', 'espresso', 'cognac', 'black', 'olive', 'wine', 'camel', 'slate'];
            @endphp
            @foreach($allColors as $c)
              <div onclick="toggleColorFilter('{{ $c }}', this)" class="filter-color-btn" title="{{ ucfirst($c) }}">
                <div class="swatch-{{ $c }} filter-color-btn-inner"></div>
              </div>
            @endforeach
          </div>
        </div>

      </div>

      <div class="filter-panel-footer">
        <button onclick="resetFilters()" class="clear-filters-btn">
          Clear Filters
        </button>
      </div>
    </div>

    <div class="product-grid" id="productGrid">
      @forelse($products as $p)
        @php
          $colorsList = is_array($p['colors']) ? $p['colors'] : explode(',', $p['colors'] ?? '');
          $firstColor = $colorsList[0] ?? 'tan';
        @endphp
        <div class="product-card" data-id="{{ $p['id'] }}" data-gender="{{ $p['gender'] ?? 'unisex' }}">
          <div class="product-img-wrap">
            @if(!empty($p['badge']))
              <div class="product-badge {{ $p['badge'] === 'new' ? 'badge-new' : 'badge-sale' }}">
                {{ ucfirst($p['badge']) }}
              </div>
            @endif
            <button class="product-wishlist" onclick="toggleWishlist(this)" title="Wishlist">♡</button>
            <div class="product-thumb">
              <a href="{{ route('shop.product', $p['sku']) }}" class="display-block-w-full-h-full">
                @if(!empty($p['images']))
                  <img src="{{ asset(ltrim($p['images'][0]['image_path'], '/')) }}" alt="{{ $p['images'][0]['alt_text'] ?? $p['name'] }}" class="product-img-el" id="thumb-{{ $p['id'] }}">
                @else
                  <div class="product-visual {{ $p['shape'] ?? 'bag-shape' }} color-{{ $firstColor }}" data-product="{{ $p['id'] }}" id="thumb-{{ $p['id'] }}"></div>
                @endif
              </a>
            </div>
            <div class="product-add-overlay">
              <button class="add-cart-btn" onclick="addToCart({{ $p['id'] }}, '{{ $firstColor }}')">Add to Cart</button>
              <button class="quick-view-btn" onclick="openModal({{ $p['id'] }})">Quick View</button>
            </div>
          </div>
          <div class="product-info">
            <div class="color-swatches">
              @foreach($colorsList as $index => $c)
                @if(!empty($c))
                  <div class="swatch swatch-{{ trim($c) }} {{ $index === 0 ? 'active' : '' }}" onclick="changeColor({{ $p['id'] }}, '{{ trim($c) }}', this)" title="{{ ucfirst(trim($c)) }}"></div>
                @endif
              @endforeach
            </div>
            <div class="product-name">
              <a href="{{ route('shop.product', $p['sku']) }}" class="product-name-link">{{ $p['name'] }}</a>
            </div>
            <div class="product-type">{{ $p['type'] }}</div>
            <div class="product-price">
              <span class="price-current">₹{{ number_format($p['price'], 0, '.', ',') }}</span>
              @if(!empty($p['old_price'] ?? $p['oldPrice']))
                <span class="price-old">₹{{ number_format($p['old_price'] ?? $p['oldPrice'], 0, '.', ',') }}</span>
                <span class="price-save">Save {{ round((1 - $p['price'] / ($p['old_price'] ?? $p['oldPrice'])) * 100) }}%</span>
              @endif
            </div>
          </div>
        </div>
      @empty
        <div class="product-grid-empty">
          No products found in this category.
        </div>
      @endforelse
    </div>
  </div>
</section>


@endsection
