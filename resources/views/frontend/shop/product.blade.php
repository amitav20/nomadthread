@extends('layouts.frontend')

@section('title', 'Nomad Thread — ' . $product['name'])

@section('content')


<section class="product-details-section">
  <div class="section-inner product-details-inner">
    
    <div class="mb-35">
      <a href="{{ route('shop.index') }}" class="back-to-shop-link">
        &larr; Back to Shop
      </a>
    </div>

    @php
      $colorsList = is_array($product['colors']) ? $product['colors'] : explode(',', $product['colors'] ?? '');
      $firstColor = $colorsList[0] ?? 'tan';
      
      $imageUrls = [];
      if(!empty($product['images'])) {
        foreach($product['images'] as $img) {
          $imageUrls[] = asset(ltrim($img['image_path'], '/'));
        }
      }
    @endphp

    <div class="product-details-container">
      
      <!-- Product Image / Visual Showcase -->
      <div class="product-showcase">
        <div class="main-image-card">
          @if(!empty($product['badge']))
            <div class="product-badge {{ $product['badge'] === 'new' ? 'badge-new' : 'badge-sale' }} badge-absolute-pos">
              {{ ucfirst($product['badge']) }}
            </div>
          @endif
          
          @if(!empty($product['images']))
            <img src="{{ asset(ltrim($product['images'][0]['image_path'], '/')) }}" alt="{{ $product['images'][0]['alt_text'] ?? $product['name'] }}" id="productMainImage" class="product-main-image-el">
            
            @if(count($product['images']) > 1)
              <!-- Left Arrow -->
              <button onclick="navigateImage(-1)" class="nav-arrow prev-arrow detail-nav-arrow">
                &#10094;
              </button>
              <!-- Right Arrow -->
              <button onclick="navigateImage(1)" class="nav-arrow next-arrow detail-nav-arrow">
                &#10095;
              </button>
            @endif
          @else
            <div class="product-visual {{ $product['shape'] ?? 'bag-shape' }} color-{{ $firstColor }} product-visual-details" id="productVisual"></div>
          @endif
        </div>
        
        @if(!empty($product['images']) && count($product['images']) > 1)
          <div class="detail-thumb-list">
            @foreach($product['images'] as $index => $img)
              <div onclick="changeDetailImage('{{ asset(ltrim($img['image_path'], '/')) }}', this, {{ $index }})" class="detail-thumb-item {{ $index === 0 ? 'active' : '' }}">
                <img src="{{ asset(ltrim($img['image_path'], '/')) }}" alt="{{ $img['alt_text'] ?? $product['name'] }}">
              </div>
            @endforeach
          </div>
        @endif
      </div>
 
      <!-- Product Details Info -->
      <div class="product-info-panel">
        <span class="product-type detail-product-type">
          {{ $product['type'] }}
        </span>
        <h1 class="detail-product-name">
          {{ $product['name'] }}
        </h1>
        
        <div class="modal-rating detail-rating-wrap">
          <span class="stars detail-stars">★★★★★</span>
          <span class="rating-count detail-rating-count">(124 reviews)</span>
        </div>
 
        <div class="product-price detail-price-wrap">
          <span class="price-current detail-price-current">₹{{ number_format($product['price'], 0, '.', ',') }}</span>
          @if(!empty($product['old_price'] ?? $product['oldPrice']))
            <span class="price-old detail-price-old">₹{{ number_format($product['old_price'] ?? $product['oldPrice'], 0, '.', ',') }}</span>
            <span class="price-save detail-price-save">Save {{ round((1 - $product['price'] / ($product['old_price'] ?? $product['oldPrice'])) * 100) }}%</span>
          @endif
        </div>
 
        <p class="detail-desc">
          {{ $product['description'] ?? 'Premium full-grain leather, hand-stitched by skilled artisans using traditional techniques. Each piece develops a unique patina over time.' }}
        </p>
 
        <!-- Color Selection -->
        <div class="mb-35">
          <h5 class="detail-color-title">Choose Color</h5>
          <div class="color-selector">
            @foreach($colorsList as $index => $c)
              @if(!empty($c))
                <div class="color-opt {{ $index === 0 ? 'active' : '' }}" onclick="selectPageColor('{{ trim($c) }}', this)">
                  <div class="color-opt-swatch swatch-{{ trim($c) }} detail-color-swatch"></div>
                  <span class="color-opt-name detail-color-name">{{ ucfirst(trim($c)) }}</span>
                </div>
              @endif
            @endforeach
          </div>
        </div>
 
        <!-- Actions -->
        <div class="detail-actions-wrap">
          <button class="btn-add-cart-premium" onclick="addPageProductToCart({{ $product['id'] }})">
            Add to Cart — <span class="fw-700">₹{{ number_format($product['price'], 0, '.', ',') }}</span>
          </button>
          <button class="btn-wishlist-premium" onclick="showToast('Added to wishlist!')">
            ♡
          </button>
        </div>
 
        <!-- Specifications / Info Accordion -->
        <div class="spec-grid">
          <div class="spec-row">
            <span class="spec-label">SKU</span>
            <span class="spec-value">{{ $product['sku'] }}</span>
          </div>
          <div class="spec-row">
            <span class="spec-label">Leather Type</span>
            <span class="spec-value">{{ $product['leather_type'] ?? 'Premium Full-Grain' }}</span>
          </div>
          <div class="spec-row">
            <span class="spec-label">Lining</span>
            <span class="spec-value">{{ $product['lining_material'] ?? 'Organic Cotton Canvas' }}</span>
          </div>
          <div class="spec-row border-bottom-none-pb-0">
            <span class="spec-label">Dimensions</span>
            <span class="spec-value">
              @if(!empty($product['length']))
                {{ $product['length'] }} x {{ $product['width'] }} x {{ $product['height'] }} cm
              @else
                Standard Handcraft Sizing
              @endif
            </span>
          </div>
        </div>
 
      </div>
 
    </div>
 
  </div>
</section>

<script>
  let selectedPageColor = '{{ $firstColor }}';

  function selectPageColor(colorName, el) {
    selectedPageColor = colorName;
    
    // Manage active state
    document.querySelectorAll('.color-opt').forEach(opt => opt.classList.remove('active'));
    el.classList.add('active');
    
    // Change Visual
    const visual = document.getElementById('productVisual');
    const shapeClass = '{{ $product['shape'] ?? 'bag-shape' }}';
    visual.className = `product-visual ${shapeClass} color-${colorName}`;
  }

  let currentImageIndex = 0;
  const imageUrls = @json($imageUrls);

  function changeDetailImage(src, el, index) {
    currentImageIndex = index;
    const mainImg = document.getElementById('productMainImage');
    if (mainImg) {
      mainImg.style.opacity = 0;
      setTimeout(() => {
        mainImg.src = src;
        mainImg.style.opacity = 1;
      }, 150);
    }
    
    document.querySelectorAll('.detail-thumb-item').forEach(item => {
      item.style.borderColor = 'var(--border)';
      item.classList.remove('active');
    });
    el.style.borderColor = 'var(--gold)';
    el.classList.add('active');
  }

  function navigateImage(direction) {
    if (!imageUrls || imageUrls.length <= 1) return;
    
    currentImageIndex += direction;
    if (currentImageIndex < 0) {
      currentImageIndex = imageUrls.length - 1;
    } else if (currentImageIndex >= imageUrls.length) {
      currentImageIndex = 0;
    }
    
    const nextSrc = imageUrls[currentImageIndex];
    const mainImg = document.getElementById('productMainImage');
    if (mainImg) {
      mainImg.style.opacity = 0;
      setTimeout(() => {
        mainImg.src = nextSrc;
        mainImg.style.opacity = 1;
      }, 150);
    }
    
    // Update thumbnail highlights
    const thumbs = document.querySelectorAll('.detail-thumb-item');
    thumbs.forEach((item, idx) => {
      if (idx === currentImageIndex) {
        item.style.borderColor = 'var(--gold)';
        item.classList.add('active');
      } else {
        item.style.borderColor = 'var(--border)';
        item.classList.remove('active');
      }
    });
  }

  function addPageProductToCart(productId) {
    if (typeof addToCart === 'function') {
      addToCart(productId, selectedPageColor);
    } else {
      showToast('Error: Cart module not loaded.');
    }
  }
</script>
@endsection
