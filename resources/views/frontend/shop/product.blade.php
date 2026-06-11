@extends('layouts.frontend')

@section('title', 'Nomad Thread — ' . $product['name'])

@section('content')
<style>
  .product-details-container {
    display: grid;
    grid-template-columns: 1.2fr 1.1fr;
    gap: 60px;
    align-items: start;
  }
  @media (max-width: 991px) {
    .product-details-container {
      grid-template-columns: 1fr;
      gap: 40px;
    }
  }
  .product-showcase {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }
  .main-image-card {
    background: var(--bg-card);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid var(--border);
    padding: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    min-height: 480px;
    overflow: hidden;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    transition: border-color 0.3s;
  }
  .main-image-card:hover {
    border-color: var(--border-focus);
  }
  .detail-thumb-list {
    display: flex;
    gap: 12px;
    overflow-x: auto;
    padding-bottom: 8px;
    scrollbar-width: thin;
    scrollbar-color: var(--gold) transparent;
  }
  .detail-thumb-item {
    width: 80px;
    height: 80px;
    border: 1px solid var(--border);
    cursor: pointer;
    background: var(--bg-card);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 6px;
  }
  .detail-thumb-item:hover {
    transform: translateY(-2px);
    border-color: var(--gold);
    box-shadow: 0 4px 12px rgba(201, 168, 76, 0.15);
  }
  .detail-thumb-item.active {
    border-color: var(--gold) !important;
    background: rgba(201, 168, 76, 0.05);
    box-shadow: 0 4px 12px rgba(201, 168, 76, 0.2);
  }
  .product-info-panel {
    background: rgba(26, 17, 11, 0.4);
    backdrop-filter: blur(8px);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
  }
  .spec-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 16px;
    border-top: 1px solid var(--border);
    padding-top: 30px;
    margin-top: 30px;
  }
  .spec-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid rgba(255, 255, 255, 0.03);
    padding-bottom: 12px;
  }
  .spec-label {
    font-family: 'Jost', sans-serif;
    font-weight: 600;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: var(--text-light);
  }
  .spec-value {
    font-family: 'Jost', sans-serif;
    font-size: 14px;
    color: var(--cream);
    font-weight: 500;
  }
  .color-selector {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
  }
  .color-opt {
    display: flex;
    align-items: center;
    gap: 8px;
    border: 1px solid var(--border);
    padding: 10px 18px;
    cursor: pointer;
    border-radius: 20px;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    background: transparent;
  }
  .color-opt:hover {
    border-color: var(--gold);
    background: rgba(201, 168, 76, 0.03);
    transform: translateY(-1px);
  }
  .color-opt.active {
    border-color: var(--gold);
    background: rgba(201, 168, 76, 0.08);
    box-shadow: 0 4px 12px rgba(201, 168, 76, 0.1);
  }
  .btn-add-cart-premium {
    flex: 1;
    padding: 18px 24px;
    background: var(--gold);
    border: none;
    color: var(--bg);
    font-family: 'Jost', sans-serif;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-size: 13px;
    cursor: pointer;
    border-radius: 6px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 15px rgba(201, 168, 76, 0.2);
  }
  .btn-add-cart-premium:hover {
    background: var(--gold-light);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(201, 168, 76, 0.35);
  }
  .btn-add-cart-premium:active {
    transform: translateY(0);
  }
  .btn-wishlist-premium {
    padding: 18px 24px;
    background: transparent;
    border: 1px solid var(--border);
    color: var(--cream);
    font-family: 'Jost', sans-serif;
    font-size: 16px;
    cursor: pointer;
    border-radius: 6px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }
  .btn-wishlist-premium:hover {
    border-color: var(--gold);
    color: var(--gold);
    background: rgba(201, 168, 76, 0.05);
    transform: translateY(-2px);
  }
</style>

<section class="product-details-section" style="padding-top: 160px; padding-bottom: 90px; min-height: 85vh; background: var(--bg);">
  <div class="section-inner" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    
    <div style="margin-bottom: 35px;">
      <a href="{{ route('shop.index') }}" style="color: var(--text-light); text-decoration: none; font-size: 13px; font-family: 'Jost', sans-serif; text-transform: uppercase; letter-spacing: 1.5px; display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s;" onmouseover="this.style.color='var(--gold)';" onmouseout="this.style.color='var(--text-light)';">
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
            <div class="product-badge {{ $product['badge'] === 'new' ? 'badge-new' : 'badge-sale' }}" style="position: absolute; top: 25px; left: 25px; z-index: 10;">
              {{ ucfirst($product['badge']) }}
            </div>
          @endif
          
          @if(!empty($product['images']))
            <img src="{{ asset(ltrim($product['images'][0]['image_path'], '/')) }}" alt="{{ $product['images'][0]['alt_text'] ?? $product['name'] }}" id="productMainImage" style="max-width: 100%; max-height: 400px; object-fit: contain; transition: opacity 0.25s ease;">
            
            @if(count($product['images']) > 1)
              <!-- Left Arrow -->
              <button onclick="navigateImage(-1)" class="nav-arrow prev-arrow" style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); background: rgba(26, 17, 11, 0.75); border: 1px solid var(--border); color: var(--cream); width: 46px; height: 46px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.25s; z-index: 10; font-size: 16px;" onmouseover="this.style.background='var(--gold)'; this.style.color='var(--bg)'; this.style.borderColor='var(--gold)';" onmouseout="this.style.background='rgba(26, 17, 11, 0.75)'; this.style.color='var(--cream)'; this.style.borderColor='var(--border)';">
                &#10094;
              </button>
              <!-- Right Arrow -->
              <button onclick="navigateImage(1)" class="nav-arrow next-arrow" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); background: rgba(26, 17, 11, 0.75); border: 1px solid var(--border); color: var(--cream); width: 46px; height: 46px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.25s; z-index: 10; font-size: 16px;" onmouseover="this.style.background='var(--gold)'; this.style.color='var(--bg)'; this.style.borderColor='var(--gold)';" onmouseout="this.style.background='rgba(26, 17, 11, 0.75)'; this.style.color='var(--cream)'; this.style.borderColor='var(--border)';">
                &#10095;
              </button>
            @endif
          @else
            <div class="product-visual {{ $product['shape'] ?? 'bag-shape' }} color-{{ $firstColor }}" id="productVisual" style="width: 320px; height: 320px; transition: all 0.5s;"></div>
          @endif
        </div>
        
        @if(!empty($product['images']) && count($product['images']) > 1)
          <div class="detail-thumb-list">
            @foreach($product['images'] as $index => $img)
              <div onclick="changeDetailImage('{{ asset(ltrim($img['image_path'], '/')) }}', this, {{ $index }})" class="detail-thumb-item {{ $index === 0 ? 'active' : '' }}">
                <img src="{{ asset(ltrim($img['image_path'], '/')) }}" alt="{{ $img['alt_text'] ?? $product['name'] }}" style="width: 100%; height: 100%; object-fit: cover;">
              </div>
            @endforeach
          </div>
        @endif
      </div>
 
      <!-- Product Details Info -->
      <div class="product-info-panel">
        <span class="product-type" style="font-family: 'Jost', sans-serif; font-size: 12px; text-transform: uppercase; letter-spacing: 2.5px; color: var(--gold); display: block; margin-bottom: 12px; font-weight: 600;">
          {{ $product['type'] }}
        </span>
        <h1 style="font-family: 'Playfair Display', serif; font-size: 38px; font-weight: 500; color: var(--cream); line-height: 1.25; margin-bottom: 15px;">
          {{ $product['name'] }}
        </h1>
        
        <div class="modal-rating" style="display: flex; align-items: center; gap: 10px; margin-bottom: 25px;">
          <span class="stars" style="color: var(--gold); letter-spacing: 2px; font-size: 15px;">★★★★★</span>
          <span class="rating-count" style="font-family: 'Jost', sans-serif; font-size: 12px; color: var(--text-light);">(124 reviews)</span>
        </div>
 
        <div class="product-price" style="margin-bottom: 30px; display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
          <span class="price-current" style="font-family: 'Playfair Display', serif; font-size: 30px; font-weight: 500; color: var(--cream);">₹{{ number_format($product['price'], 0, '.', ',') }}</span>
          @if(!empty($product['old_price'] ?? $product['oldPrice']))
            <span class="price-old" style="text-decoration: line-through; color: var(--text-light); font-size: 18px; font-family: 'Playfair Display', serif;">₹{{ number_format($product['old_price'] ?? $product['oldPrice'], 0, '.', ',') }}</span>
            <span class="price-save" style="font-family: 'Jost', sans-serif; font-size: 11px; background: rgba(201,168,76,0.15); color: var(--gold); padding: 4px 10px; border-radius: 20px; font-weight: 600;">Save {{ round((1 - $product['price'] / ($product['old_price'] ?? $product['oldPrice'])) * 100) }}%</span>
          @endif
        </div>
 
        <p style="font-family: 'Cormorant Garamond', serif; font-size: 19px; line-height: 1.65; color: var(--text-light); margin-bottom: 35px;">
          {{ $product['description'] ?? 'Premium full-grain leather, hand-stitched by skilled artisans using traditional techniques. Each piece develops a unique patina over time.' }}
        </p>
 
        <!-- Color Selection -->
        <div style="margin-bottom: 35px;">
          <h5 style="font-family: 'Jost', sans-serif; font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: var(--cream); margin-bottom: 15px; font-weight: 600;">Choose Color</h5>
          <div class="color-selector">
            @foreach($colorsList as $index => $c)
              @if(!empty($c))
                <div class="color-opt {{ $index === 0 ? 'active' : '' }}" onclick="selectPageColor('{{ trim($c) }}', this)">
                  <div class="color-opt-swatch swatch-{{ trim($c) }}" style="width: 14px; height: 14px; border-radius: 50%;"></div>
                  <span class="color-opt-name" style="font-family: 'Jost', sans-serif; font-size: 12px; color: var(--cream); font-weight: 500;">{{ ucfirst(trim($c)) }}</span>
                </div>
              @endif
            @endforeach
          </div>
        </div>
 
        <!-- Actions -->
        <div style="display: flex; gap: 15px; margin-bottom: 20px;">
          <button class="btn-add-cart-premium" onclick="addPageProductToCart({{ $product['id'] }})">
            Add to Cart — <span style="font-weight:700;">₹{{ number_format($product['price'], 0, '.', ',') }}</span>
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
          <div class="spec-row" style="border-bottom: none; padding-bottom: 0;">
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
