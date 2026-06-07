@extends('layouts.frontend')

@section('title', 'Nomad Thread — ' . ($currentCategory['name'] ?? 'Category'))

@section('content')
@php
  $categoryBanner = collect($banners)->first(function($b) use ($currentCategory) {
    return strtolower($b['position']) === 'category: ' . strtolower($currentCategory['slug']) || 
           strtolower($b['position']) === 'category header';
  });
@endphp

@if($categoryBanner)
  <section class="page-hero-section" style="padding: 120px 0 60px; background: var(--espresso); position: relative; overflow: hidden; min-height: 250px; display: flex; align-items: center; justify-content: center; text-align: center;">
    @if(!empty($categoryBanner['video']))
      <video autoplay loop muted playsinline style="position: absolute; inset: 0; width:100%; height:100%; object-fit:cover; opacity: 0.4;">
        <source src="{{ asset($categoryBanner['video']) }}" type="video/mp4">
      </video>
    @elseif(!empty($categoryBanner['image']))
      <div style="position: absolute; inset:0; background-image: url('{{ asset($categoryBanner['image']) }}'); background-size: cover; background-position: center; opacity: 0.4;"></div>
    @endif
    <div style="position: absolute; inset:0; background: linear-gradient(to bottom, rgba(44,26,14,0.6), rgba(44,26,14,0.85)); z-index:1;"></div>
    <div class="section-inner" style="position: relative; z-index: 2;">
      <span style="font-family:'Jost', sans-serif; font-size:10px; letter-spacing:4px; text-transform:uppercase; color:var(--tan-light); margin-bottom:12px; display:block;">
        {{ $categoryBanner['subheadline'] ?? 'Category Collection' }}
      </span>
      <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(32px, 4vw, 52px); font-weight: 700; color: var(--cream); line-height: 1.2;">
        <em>{{ $categoryBanner['title'] }}</em>
      </h1>
      @if(!empty($categoryBanner['cta_text']))
        <a href="{{ $categoryBanner['cta_link'] ?? '#' }}" class="btn-primary" style="margin-top: 15px; display: inline-block; padding: 12px 28px;"><span>{{ $categoryBanner['cta_text'] }}</span></a>
      @endif
    </div>
  </section>
@endif

<section class="products-section" style="{{ $categoryBanner ? 'padding: 60px 0;' : 'padding-top: 140px;' }} min-height: 80vh;">
  <div class="section-inner">
    @if(!$categoryBanner)
      <div class="section-header reveal visible">
        <span class="section-tag">Category Collection</span>
        <h2 class="section-title">
          {{ $currentCategory['icon'] ?? '✦' }} 
          <em>{{ $currentCategory['name'] }}</em>
        </h2>
        <p class="section-sub">{{ $currentCategory['description'] ?? 'Premium handcrafted leather goods built to last a lifetime.' }}</p>
      </div>
    @endif

    <!-- Category Filter Bar -->
    <div class="filter-bar reveal visible" style="margin-bottom: 40px; justify-content: center; display: flex; gap: 10px; flex-wrap: wrap;">
      <a href="{{ route('shop.index') }}" class="filter-btn" style="text-decoration:none" data-category="all">All</a>
      @foreach($categories as $cat)
        <a href="{{ route('shop.category', $cat['slug']) }}" class="filter-btn {{ $currentCategory['slug'] === $cat['slug'] ? 'active' : '' }}" style="text-decoration:none" data-category="{{ $cat['slug'] }}">
          {{ $cat['name'] }}
        </a>
      @endforeach
    </div>

    <div class="product-grid" id="productGrid">
      @forelse($products as $p)
        @php
          $colorsList = is_array($p['colors']) ? $p['colors'] : explode(',', $p['colors'] ?? '');
          $firstColor = $colorsList[0] ?? 'tan';
        @endphp
        <div class="product-card" data-id="{{ $p['id'] }}">
          <div class="product-img-wrap">
            @if(!empty($p['badge']))
              <div class="product-badge {{ $p['badge'] === 'new' ? 'badge-new' : 'badge-sale' }}">
                {{ ucfirst($p['badge']) }}
              </div>
            @endif
            <button class="product-wishlist" onclick="toggleWishlist(this)" title="Wishlist">♡</button>
            <div class="product-thumb">
              <a href="{{ route('shop.product', $p['sku']) }}" style="display:block; width:100%; height:100%">
                @if(!empty($p['images']))
                  <img src="{{ asset($p['images'][0]['image_path']) }}" alt="{{ $p['images'][0]['alt_text'] ?? $p['name'] }}" style="width:100%; height:100%; object-fit:cover;" id="thumb-{{ $p['id'] }}">
                @else
                  <div class="product-visual {{ $p['shape'] ?? 'bag-shape' }} color-{{ $firstColor }}" data-product="{{ $p['id'] }}" id="thumb-{{ $p['id'] }}"></div>
                @endif
              </a>
            </div>
            <div class="product-add-overlay">
              <button class="add-cart-btn" onclick="addToCart({{ $p['id'] }}, '{{ $firstColor }}')">Add to Cart</button>
              <a href="{{ route('shop.product', $p['sku']) }}" class="quick-view-btn" style="text-decoration:none; display:inline-flex; align-items:center; justify-content:center">View Details</a>
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
              <a href="{{ route('shop.product', $p['sku']) }}" style="color:inherit; text-decoration:none">{{ $p['name'] }}</a>
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
        <div style="grid-column: 1/-1; text-align:center; padding: 80px 20px; font-family:'Cormorant Garamond',serif; font-size:24px; color:var(--text-light)">
          No products found in this category.
        </div>
      @endforelse
    </div>
  </div>
</section>
@endsection
