@extends('layouts.frontend')

@section('title', 'Nomad Thread — Artisan Leather Goods')

@section('content')

<!-- PAGE SECTIONS NAV -->
<div class="page-indicator">
  <div class="page-dot active" onclick="window.scrollTo({top: document.getElementById('hero').offsetTop - 72, behavior: 'smooth'})" title="Hero"></div>
  <div class="page-dot" onclick="window.scrollTo({top: document.getElementById('categories').offsetTop - 72, behavior: 'smooth'})" title="Categories"></div>
  <div class="page-dot" onclick="window.scrollTo({top: document.getElementById('products').offsetTop - 72, behavior: 'smooth'})" title="Products"></div>
  <div class="page-dot" onclick="window.scrollTo({top: document.getElementById('about').offsetTop - 72, behavior: 'smooth'})" title="Story"></div>
  <div class="page-dot" onclick="window.scrollTo({top: document.getElementById('blog').offsetTop - 72, behavior: 'smooth'})" title="Journal"></div>
</div>

<!-- HERO -->
@php
  $heroBanners = collect($banners)->filter(function($b) {
      return strtolower($b['position']) === 'homepage hero';
  })->values()->all();
  
  if (empty($heroBanners)) {
      $heroBanners = [[
          'title' => "Crafted for <em>Life's</em><br>Every Journey",
          'subheadline' => 'Premium full-grain leather goods handcrafted by master artisans. Blending heritage with refined contemporary design.',
          'cta_text' => 'Explore Collection',
          'cta_link' => '#products',
          'image' => null,
          'video' => null,
      ]];
  }
@endphp
<section class="hero" id="hero" style="position: relative; overflow: hidden;">
  <!-- Slider Wrapper -->
  <div class="hero-slider-container" style="position: absolute; inset: 0; width: 100%; height: 100%;">
    @foreach($heroBanners as $index => $banner)
      @php
        $videoUrl = null;
        if (!empty($siteSettings['hero_video'])) {
            $videoUrl = asset(ltrim($siteSettings['hero_video'], '/'));
        } elseif (!empty($banner['video'])) {
            $videoUrl = asset(ltrim($banner['video'], '/'));
        }
        $hasVideo = !empty($videoUrl);
      @endphp
      <div class="hero-slide" id="hero-slide-{{ $index }}" style="opacity: {{ $index === 0 ? '1' : '0' }}; pointer-events: {{ $index === 0 ? 'auto' : 'none' }}; z-index: {{ $index === 0 ? '3' : '1' }};">
        
        <!-- Full Banner Background Video (Behind both green and chocolate overlays) -->
        @if($hasVideo)
          <div style="position: absolute; inset: 0; width: 100%; height: 100%; overflow: hidden; background: #000; z-index: 1; pointer-events: none;">
            <video autoplay loop muted playsinline style="position: absolute; top: 50%; left: 50%; width: 100%; height: 100%; object-fit: cover; transform: translate(-50%, -50%); opacity: 0.55;">
              <source src="{{ $videoUrl }}" type="video/mp4">
            </video>
          </div>
        @endif

        <!-- Left Side Content (Green Overlaid on Video) -->
        <div class="hero-left" style="background: {{ $hasVideo ? 'rgba(16, 38, 16, 0.85)' : 'var(--espresso)' }}; backdrop-filter: {{ $hasVideo ? 'blur(8px)' : 'none' }}; -webkit-backdrop-filter: {{ $hasVideo ? 'blur(8px)' : 'none' }}; z-index: 2; position: relative;">
          <div class="hero-tag">New Collection 2026</div>
          <h1>{!! $banner['title'] !!}</h1>
          <p class="hero-desc">{{ $banner['subheadline'] }}</p>
          <div class="hero-btns">
            <a href="{{ $banner['cta_link'] ?? '#products' }}" class="btn-primary"><span>{{ $banner['cta_text'] ?? 'Explore Collection' }}</span></a>
            <a href="#about" class="btn-outline">Our Craft Story</a>
          </div>
        </div>

        <!-- Right Side Media & Slider Card (Chocolate Overlaid on Video) -->
        <div class="hero-right" style="position: relative; height: 100%; background: {{ $hasVideo ? 'rgba(44, 26, 14, 0.7)' : 'transparent' }}; backdrop-filter: {{ $hasVideo ? 'blur(8px)' : 'none' }}; -webkit-backdrop-filter: {{ $hasVideo ? 'blur(8px)' : 'none' }}; z-index: 2;">
          
          @if(!$hasVideo)
            <!-- Fallback gradient background when there is no video -->
            <div style="position: absolute; inset: 0; width: 100%; height: 100%; overflow: hidden; background: #2c1a0e; z-index: 1;">
              <div style="position: absolute; inset:0; background: radial-gradient(circle at 60% 50%, rgba(200,169,122,0.15) 0%, rgba(44,26,14,0.9) 100%);"></div>
            </div>
          @endif

          <!-- Foreground Slider Card -->
          <div style="position: relative; z-index: 5; display: flex; align-items: center; justify-content: center; height: 100%; width: 100%;">
            <div class="hero-product-showcase" style="animation: float 4s ease-in-out infinite;">
              <div class="hero-product-bg"></div>
              <div class="leather-texture-box" style="background: rgba(44,26,14,0.4); backdrop-filter: blur(8px); border-radius: 8px;">
                
                @if(!empty($banner['image']))
                  <div style="width: 260px; height: 220px; border-radius: 8px; overflow: hidden; box-shadow: var(--shadow);">
                    <img src="{{ asset(ltrim($banner['image'], '/')) }}" alt="{{ $banner['title'] }}" style="width: 100%; height: 100%; object-fit: cover;">
                  </div>
                @else
                  <div class="product-silhouette"></div>
                @endif
                
                <span class="hero-product-label">{{ $banner['alt_text'] ?? 'Full Grain Leather' }}</span>
              </div>
            </div>
          </div>

        </div>
      </div>
    @endforeach
  </div>

  <!-- Hand-written simple Slider Indicators (Dots) -->
  @if(count($heroBanners) > 1)
    <div class="slider-dots" style="position: absolute; bottom: 40px; left: 80px; z-index: 20; display: flex; gap: 10px;">
      @foreach($heroBanners as $index => $banner)
        <span class="slider-dot" id="slider-dot-{{ $index }}" onclick="goToSlide({{ $index }})" style="width: 12px; height: 12px; border-radius: 50%; border: 1.5px solid var(--tan-light); cursor: pointer; transition: all 0.3s; opacity: {{ $index === 0 ? '1' : '0.4' }}; background: {{ $index === 0 ? 'var(--tan)' : 'transparent' }};"></span>
      @endforeach
    </div>
  @endif

  <div class="hero-scroll" style="z-index: 20;"><div class="scroll-line"></div> Scroll to Explore</div>
</section>

<!-- MARQUEE -->
@php
  $marqueeItems = ['Full Grain Leather', 'Handstitched Artisanship', 'Indian Heritage', 'Lifetime Durability', 'Bespoke Monogramming', '10+ Years of Craft'];
@endphp
<div class="marquee-strip">
  <div class="marquee-track" id="marqueeTrack">
    @foreach(array_merge($marqueeItems, $marqueeItems) as $item)
      <span class="marquee-item">{{ trim($item) }}</span>
    @endforeach
  </div>
</div>

<script>
  let currentSlide = 0;
  const slideCount = {{ count($heroBanners) }};
  let slideInterval = null;

  function goToSlide(index) {
    if (slideCount <= 1) return;
    
    // Deactivate current slide
    const prevSlideEl = document.getElementById('hero-slide-' + currentSlide);
    const prevDotEl = document.getElementById('slider-dot-' + currentSlide);
    
    if (prevSlideEl) {
      prevSlideEl.style.opacity = '0';
      prevSlideEl.style.pointerEvents = 'none';
      prevSlideEl.style.zIndex = '1';
    }
    if (prevDotEl) {
      prevDotEl.style.opacity = '0.4';
      prevDotEl.style.background = 'transparent';
    }

    // Set new current slide
    currentSlide = index;

    // Activate new slide
    const nextSlideEl = document.getElementById('hero-slide-' + currentSlide);
    const nextDotEl = document.getElementById('slider-dot-' + currentSlide);

    if (nextSlideEl) {
      nextSlideEl.style.opacity = '1';
      nextSlideEl.style.pointerEvents = 'auto';
      nextSlideEl.style.zIndex = '3';
    }
    if (nextDotEl) {
      nextDotEl.style.opacity = '1';
      nextDotEl.style.background = 'var(--tan)';
    }

    resetAutoplay();
  }

  function nextSlide() {
    let nextIndex = (currentSlide + 1) % slideCount;
    goToSlide(nextIndex);
  }

  function resetAutoplay() {
    clearInterval(slideInterval);
    if (slideCount > 1) {
      slideInterval = setInterval(nextSlide, 6000);
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    resetAutoplay();
  });
</script>

<!-- CATEGORIES -->
<section id="categories">
  <div class="section-inner">
    <div class="section-header reveal">
      <span class="section-tag">Browse by Category</span>
      <h2 class="section-title">Timeless Leather, <em>Every Form</em></h2>
    </div>
    @php
      $bgMap = [
        'bags' => 'bg-bags',
        'bag' => 'bg-bags',
        'wallets' => 'bg-wallets',
        'wallet' => 'bg-wallets',
        'accessories' => 'bg-belts',
        'accessory' => 'bg-belts',
        'travel' => 'bg-luggage',
        'travels' => 'bg-luggage'
      ];
    @endphp
    <div class="cat-grid reveal">
      @foreach($categories as $cat)
        <a href="{{ route('shop.category', $cat['slug']) }}" class="cat-card">
          <div class="cat-bg {{ $bgMap[$cat['slug']] ?? 'bg-bags' }}" style="height:100%"></div>
          <div class="cat-overlay"></div>
          <div class="cat-arrow">↗</div>
          <div class="cat-info">
            <span class="cat-name">{{ $cat['name'] }}</span>
            <span class="cat-count">{{ $cat['icon'] }} Collection</span>
          </div>
        </a>
      @endforeach
    </div>
  </div>
</section>

<!-- PRODUCTS -->
<section class="products-section" id="products">
  <div class="section-inner">
    <div class="section-header reveal">
      <span class="section-tag">Featured Products</span>
      <h2 class="section-title">Curated <em>Bestsellers</em></h2>
      <p class="section-sub">Each piece is a testament to the beauty of natural leather and the skill of our craftspeople.</p>
    </div>

    <div class="filter-bar reveal">
      <button class="filter-btn active" data-category="all" onclick="filterProducts('all', this)">All</button>
      @foreach($categories as $cat)
        <button class="filter-btn" data-category="{{ $cat['slug'] }}" onclick="filterProducts('{{ $cat['slug'] }}', this)">{{ $cat['name'] }}</button>
      @endforeach
      <button class="filter-btn" data-category="new" onclick="filterProducts('new', this)">New Arrivals</button>
    </div>

    <div class="product-grid" id="productGrid"></div>
  </div>
</section>

<!-- FEATURED BANNER -->
<section class="featured-banner" id="about">
  <div class="featured-inner">
    <div class="featured-content reveal">
      <span class="section-tag">The Nomad Thread Story</span>
      <h2 class="section-title" style="color:var(--cream)">Where <em>Heritage</em><br>Meets Craft</h2>
      <p class="section-sub" style="text-align:left">Every Nomad Thread piece begins as raw full-grain hide, selected by hand in our atelier. Skilled artisans spend days cutting, stitching, and finishing each item — no shortcuts, no compromises.</p>
      <a href="#" class="btn-primary" style="margin-top:4px" onclick="event.preventDefault(); showToast('Our process brochure is downloading!')"><span>Discover Our Process</span></a>
      <div class="featured-facts">
        <div class="fact-item"><div class="fact-num">18+</div><div class="fact-label">Years of Craft</div></div>
        <div class="fact-item"><div class="fact-num">150k</div><div class="fact-label">Happy Owners</div></div>
        <div class="fact-item"><div class="fact-num">100%</div><div class="fact-label">Full-Grain Leather</div></div>
        <div class="fact-item"><div class="fact-num">32</div><div class="fact-label">Expert Artisans</div></div>
      </div>
    </div>
    <div class="featured-visual reveal">
      <div class="feat-img">
        <div class="feat-img-bg feat-bg1"><span class="craft-icon">✂</span></div>
      </div>
      <div class="feat-img">
        <div class="feat-img-bg feat-bg2"><span class="craft-icon">🧵</span></div>
      </div>
      <div class="feat-img">
        <div class="feat-img-bg feat-bg3"><span class="craft-icon">👜</span></div>
      </div>
    </div>
  </div>
</section>

<!-- PROCESS -->
<section class="process-section">
  <div class="section-inner">
    <div class="section-header reveal">
      <span class="section-tag">Our Process</span>
      <h2 class="section-title">Made the <em>Right Way</em></h2>
    </div>
    <div class="process-grid">
      <div class="process-item reveal">
        <div class="process-num">01</div>
        <div class="process-icon">🐄</div>
        <div class="process-title">Hide Selection</div>
        <p class="process-text">We source only the finest full-grain hides, selected by hand for texture, weight, and character.</p>
      </div>
      <div class="process-item reveal" style="transition-delay:0.1s">
        <div class="process-num">02</div>
        <div class="process-icon">✂️</div>
        <div class="process-title">Pattern Cutting</div>
        <p class="process-text">Master cutters trace each pattern by hand, ensuring grain alignment and minimal waste.</p>
      </div>
      <div class="process-item reveal" style="transition-delay:0.2s">
        <div class="process-num">03</div>
        <div class="process-icon">🧵</div>
        <div class="process-title">Hand Stitching</div>
        <p class="process-text">Saddle-stitched by hand with waxed linen thread for strength that outlasts machine sewing.</p>
      </div>
      <div class="process-item reveal" style="transition-delay:0.3s">
        <div class="process-num">04</div>
        <div class="process-icon">✨</div>
        <div class="process-title">Burnishing & Care</div>
        <p class="process-text">Edges are burnished, conditioned, and finished to a natural sheen that deepens with age.</p>
      </div>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="testimonials-section">
  <div class="section-inner">
    <div class="section-header reveal">
      <span class="section-tag">Customer Stories</span>
      <h2 class="section-title">Loved by <em>Thousands</em></h2>
    </div>
    <div class="testimonials-grid">
      <div class="testimonial-card reveal">
        <div class="testimonial-quote">"</div>
        <p class="testimonial-text">The cognac messenger bag I bought three years ago looks better today than the day it arrived. The leather has developed a beautiful patina that I get compliments on constantly.</p>
        <div class="testimonial-author">
          <div class="author-avatar av1">A</div>
          <div><div class="author-name">Arjun Mehta</div><div class="author-loc">Mumbai, India</div></div>
        </div>
      </div>
      <div class="testimonial-card reveal" style="transition-delay:0.15s">
        <div class="testimonial-quote">"</div>
        <p class="testimonial-text">I gifted my husband the espresso bifold wallet and he hasn't put it down. The quality is immediately evident — it feels like a luxury item without the pretentious price tag.</p>
        <div class="testimonial-author">
          <div class="author-avatar av2">P</div>
          <div><div class="author-name">Priya Sharma</div><div class="author-loc">Delhi, India</div></div>
        </div>
      </div>
      <div class="testimonial-card reveal" style="transition-delay:0.3s">
        <div class="testimonial-quote">"</div>
        <p class="testimonial-text">The monogramming service added such a personal touch. I ordered three belts for my brothers as birthday gifts and the presentation box alone made an impression.</p>
        <div class="testimonial-author">
          <div class="author-avatar av3">S</div>
          <div><div class="author-name">Sameer Rathore</div><div class="author-loc">Bengaluru, India</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- BLOG -->
<section class="blog-section" id="blog">
  <div class="section-inner">
    <div class="section-header reveal">
      <span class="section-tag">The Leather Journal</span>
      <h2 class="section-title">Stories of <em>Craft</em></h2>
    </div>
    <div class="blog-grid reveal">
      <a href="#" class="blog-card" onclick="event.preventDefault(); showToast('Article coming soon!')">
        <div class="blog-img">
          <div class="blog-img-bg blog-bg1" style="height:100%"></div>
        </div>
        <div class="blog-body">
          <div class="blog-meta">
            <span class="blog-cat">Leather Care</span>
            <span class="blog-date">May 20, 2026</span>
          </div>
          <h3 class="blog-title">The Art of Aging: How Full-Grain Leather Develops Its Character</h3>
          <p class="blog-excerpt">Unlike corrected-grain or bonded leather, full-grain leather tells a story with every scratch and crease. Learn how to nurture your leather pieces through their most beautiful transformation...</p>
          <span class="blog-read">Read Article</span>
        </div>
      </a>
      <div class="blog-right">
        <a href="#" class="blog-card blog-card-small" onclick="event.preventDefault(); showToast('Article coming soon!')">
          <div class="blog-img">
            <div class="blog-img-bg blog-bg2" style="height:100%"></div>
          </div>
          <div class="blog-body">
            <div class="blog-meta">
              <span class="blog-cat">Craftsmanship</span>
              <span class="blog-date">May 8, 2026</span>
            </div>
            <h3 class="blog-title">Saddle Stitching: Why Hand Beats Machine Every Time</h3>
            <p class="blog-excerpt">A single broken thread in a machine stitch can unravel an entire seam. Discover why our artisans spend an extra four hours on every bag...</p>
            <span class="blog-read">Read Article</span>
          </div>
        </a>
        <a href="#" class="blog-card blog-card-small" onclick="event.preventDefault(); showToast('Article coming soon!')">
          <div class="blog-img">
            <div class="blog-img-bg blog-bg3" style="height:100%"></div>
          </div>
          <div class="blog-body">
            <div class="blog-meta">
              <span class="blog-cat">Gifting</span>
              <span class="blog-date">April 28, 2026</span>
            </div>
            <h3 class="blog-title">5 Leather Gifts That Will Be Used for a Lifetime</h3>
            <p class="blog-excerpt">Forget disposable gifts. These five Nomad Thread pieces have become heirlooms in hundreds of homes...</p>
            <span class="blog-read">Read Article</span>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- NEWSLETTER -->
<section class="newsletter-section">
  <div class="section-inner newsletter-inner">
    <span class="section-tag">Stay Connected</span>
    <h2 class="newsletter-title">Join the Nomad Thread Circle</h2>
    <p class="newsletter-sub">New arrivals, leather care tips, and exclusive member offers — straight to your inbox.</p>
    <form class="newsletter-form" onsubmit="handleNewsletter(event)">
      <input class="newsletter-input" type="email" placeholder="Your email address" required />
      <button type="submit" class="newsletter-btn">Subscribe</button>
    </form>
  </div>
</section>

<script>
// Script to control active dot state on scroll
document.addEventListener('DOMContentLoaded', () => {
  const sections = [
    document.getElementById('hero'),
    document.getElementById('categories'),
    document.getElementById('products'),
    document.getElementById('about'),
    document.getElementById('blog')
  ];
  const dots = document.querySelectorAll('.page-dot');
  
  window.addEventListener('scroll', () => {
    let currentIdx = 0;
    const scrollPos = window.scrollY + 120;
    
    sections.forEach((section, idx) => {
      if (section && scrollPos >= section.offsetTop) {
        currentIdx = idx;
      }
    });
    
    dots.forEach((dot, idx) => {
      dot.classList.toggle('active', idx === currentIdx);
    });
  });
});
</script>

@endsection
