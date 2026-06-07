@extends('layouts.frontend')

@section('title', 'Nomad Thread — ' . $product['name'])

@section('content')
<section class="product-details-section" style="padding-top: 140px; padding-bottom: 80px; min-height: 85vh; background: var(--bg);">
  <div class="section-inner" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    
    <div style="margin-bottom: 30px;">
      <a href="{{ route('shop.index') }}" style="color: var(--gold); text-decoration: none; font-size: 14px; font-family: 'Jost', sans-serif;">&larr; Back to Shop</a>
    </div>

    @php
      $colorsList = is_array($product['colors']) ? $product['colors'] : explode(',', $product['colors'] ?? '');
      $firstColor = $colorsList[0] ?? 'tan';
    @endphp

    <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 60px; align-items: start;">
      
      <!-- Product Image / Visual Showcase -->
      <div style="display: flex; flex-direction: column; gap: 20px;">
        <div style="background: var(--bg-card); border: 1px solid var(--border); padding: 40px; display: flex; align-items: center; justify-content: center; position: relative; min-height: 400px;">
          @if(!empty($product['badge']))
            <div class="product-badge {{ $product['badge'] === 'new' ? 'badge-new' : 'badge-sale' }}" style="position: absolute; top: 20px; left: 20px;">
              {{ ucfirst($product['badge']) }}
            </div>
          @endif
          
          @if(!empty($product['images']))
            <img src="{{ asset($product['images'][0]['image_path']) }}" alt="{{ $product['images'][0]['alt_text'] ?? $product['name'] }}" id="productMainImage" style="max-width: 100%; max-height: 380px; object-fit: contain; transition: opacity 0.3s ease;">
          @else
            <div class="product-visual {{ $product['shape'] ?? 'bag-shape' }} color-{{ $firstColor }}" id="productVisual" style="width: 320px; height: 320px; transition: all 0.5s;"></div>
          @endif
        </div>
        
        @if(!empty($product['images']) && count($product['images']) > 1)
          <div style="display: flex; gap: 10px; overflow-x: auto; padding-bottom: 8px;">
            @foreach($product['images'] as $index => $img)
              <div onclick="changeDetailImage('{{ asset($img['image_path']) }}', this)" class="detail-thumb-item {{ $index === 0 ? 'active' : '' }}" style="width: 70px; height: 70px; border: 1px solid {{ $index === 0 ? 'var(--gold)' : 'var(--border)' }}; cursor: pointer; background: var(--bg-card); display: flex; align-items: center; justify-content: center; overflow: hidden; transition: all 0.2s;">
                <img src="{{ asset($img['image_path']) }}" alt="{{ $img['alt_text'] ?? $product['name'] }}" style="width: 100%; height: 100%; object-fit: cover;">
              </div>
            @endforeach
          </div>
        @endif
      </div>

      <!-- Product Details Info -->
      <div class="product-details-info">
        <span class="product-type" style="font-family: 'Jost', sans-serif; font-size: 13px; text-transform: uppercase; letter-spacing: 2px; color: var(--gold); display: block; margin-bottom: 10px;">
          {{ $product['type'] }}
        </span>
        <h1 style="font-family: 'Playfair Display', serif; font-size: 42px; font-weight: 500; color: var(--cream); line-height: 1.2; margin-bottom: 15px;">
          {{ $product['name'] }}
        </h1>
        
        <div class="modal-rating" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
          <span class="stars" style="color: var(--gold); letter-spacing: 2px; font-size: 16px;">★★★★★</span>
          <span class="rating-count" style="font-family: 'Jost', sans-serif; font-size: 12px; color: var(--text-light);">(124 reviews)</span>
        </div>

        <div class="product-price" style="margin-bottom: 30px;">
          <span class="price-current" style="font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 500; color: var(--cream);">₹{{ number_format($product['price'], 0, '.', ',') }}</span>
          @if(!empty($product['old_price'] ?? $product['oldPrice']))
            <span class="price-old" style="text-decoration: line-through; color: var(--text-light); font-size: 18px; margin-left: 12px; font-family: 'Playfair Display', serif;">₹{{ number_format($product['old_price'] ?? $product['oldPrice'], 0, '.', ',') }}</span>
            <span class="price-save" style="font-family: 'Jost', sans-serif; font-size: 11px; background: rgba(201,168,76,0.15); color: var(--gold); padding: 3px 8px; border-radius: 20px; font-weight: 500; margin-left: 10px; vertical-align: middle;">Save {{ round((1 - $product['price'] / ($product['old_price'] ?? $product['oldPrice'])) * 100) }}%</span>
          @endif
        </div>

        <p style="font-family: 'Cormorant Garamond', serif; font-size: 19px; line-height: 1.6; color: var(--text-light); margin-bottom: 30px;">
          {{ $product['description'] ?? 'Premium full-grain leather, hand-stitched by skilled artisans using traditional techniques. Each piece develops a unique patina over time.' }}
        </p>

        <!-- Color Selection -->
        <div style="margin-bottom: 35px;">
          <h5 style="font-family: 'Jost', sans-serif; font-size: 12px; text-transform: uppercase; letter-spacing: 1.5px; color: var(--cream); margin-bottom: 12px; font-weight: 500;">Choose Color</h5>
          <div class="color-options" style="display: flex; gap: 15px; flex-wrap: wrap;">
            @foreach($colorsList as $index => $c)
              @if(!empty($c))
                <div class="color-opt {{ $index === 0 ? 'active' : '' }}" onclick="selectPageColor('{{ trim($c) }}', this)" style="display: flex; align-items: center; gap: 8px; border: 1px solid var(--border); padding: 8px 14px; cursor: pointer; transition: all 0.2s;">
                  <div class="color-opt-swatch swatch-{{ trim($c) }}" style="width: 16px; height: 16px; border-radius: 50%;"></div>
                  <span class="color-opt-name" style="font-family: 'Jost', sans-serif; font-size: 12px; color: var(--cream);">{{ ucfirst(trim($c)) }}</span>
                </div>
              @endif
            @endforeach
          </div>
        </div>

        <!-- Actions -->
        <div style="display: flex; gap: 15px; margin-bottom: 40px;">
          <button class="btn-add-full" onclick="addPageProductToCart({{ $product['id'] }})" style="flex: 1; padding: 16px; background: var(--gold); border: none; color: var(--bg); font-family: 'Jost', sans-serif; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; cursor: pointer; transition: all 0.2s;">
            Add to Cart — ₹{{ number_format($product['price'], 0, '.', ',') }}
          </button>
          <button class="btn-wishlist-full" onclick="showToast('Added to wishlist!')" style="padding: 16px 24px; background: transparent; border: 1px solid var(--border); color: var(--cream); font-family: 'Jost', sans-serif; cursor: pointer; transition: all 0.2s;">
            ♡
          </button>
        </div>

        <!-- Specifications / Info Accordion -->
        <div style="border-top: 1px solid var(--border); padding-top: 25px;">
          <div style="margin-bottom: 15px;">
            <span style="font-family: 'Jost', sans-serif; font-weight: 600; font-size: 12px; text-transform: uppercase; color: var(--cream); width: 120px; display: inline-block;">SKU:</span>
            <span style="font-family: 'Jost', sans-serif; font-size: 14px; color: var(--text-light);">{{ $product['sku'] }}</span>
          </div>
          <div style="margin-bottom: 15px;">
            <span style="font-family: 'Jost', sans-serif; font-weight: 600; font-size: 12px; text-transform: uppercase; color: var(--cream); width: 120px; display: inline-block;">Leather Type:</span>
            <span style="font-family: 'Jost', sans-serif; font-size: 14px; color: var(--text-light);">{{ $product['leather_type'] ?? 'Premium Full-Grain' }}</span>
          </div>
          <div style="margin-bottom: 15px;">
            <span style="font-family: 'Jost', sans-serif; font-weight: 600; font-size: 12px; text-transform: uppercase; color: var(--cream); width: 120px; display: inline-block;">Lining:</span>
            <span style="font-family: 'Jost', sans-serif; font-size: 14px; color: var(--text-light);">{{ $product['lining_material'] ?? 'Organic Cotton Canvas' }}</span>
          </div>
          <div style="margin-bottom: 15px;">
            <span style="font-family: 'Jost', sans-serif; font-weight: 600; font-size: 12px; text-transform: uppercase; color: var(--cream); width: 120px; display: inline-block;">Dimensions:</span>
            <span style="font-family: 'Jost', sans-serif; font-size: 14px; color: var(--text-light);">
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

  function changeDetailImage(src, el) {
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
    });
    el.style.borderColor = 'var(--gold)';
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
