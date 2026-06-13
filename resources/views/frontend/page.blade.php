@extends('layouts.frontend')

@section('title', 'Nomad Thread — ' . ($page->meta_title ?: $page->title))

@section('content')
<!-- Page Banner Header -->
<section class="page-hero-section">
  @if($pageBanner)
    @if(!empty($pageBanner['video']))
      <video autoplay loop muted playsinline class="hero-video-bg">
        <source src="{{ $pageBanner['video'] }}" type="video/mp4">
      </video>
    @elseif(!empty($pageBanner['image']))
      <div class="hero-image-bg" style="background-image: url('{{ $pageBanner['image'] }}');"></div>
    @endif
  @elseif(!empty($page->featured_image))
    <div class="hero-image-bg opacity-30" style="background-image: url('{{ $page->featured_image }}');"></div>
  @endif

  <div class="hero-overlay"></div>

  <div class="section-inner">
    <span class="hero-tag">
      {{ $page->page_type }}
    </span>
    <h1 class="hero-title">
      <em>{{ $page->title }}</em>
    </h1>
    <div class="page-breadcrumb-trail">
      <a href="{{ route('home') }}">Home</a>
      <span>/</span>
      <span class="active">{{ $page->title }}</span>
    </div>
  </div>
</section>

<!-- Page Content Section -->
<section class="custom-page-section">
  <div class="section-inner">
    
    @if($page->template == 'With Sidebar')
      <div class="sidebar-template-grid">
        <div class="dynamic-page-content">
          {!! $page->content !!}
        </div>
        <div class="sidebar-card">
          <h4 class="sidebar-h4">Information</h4>
          <p class="sidebar-p">Need immediate assistance or have questions about our premium leathercraft?</p>
          <a href="/shop" class="sidebar-btn">Explore Shop</a>
        </div>
      </div>
      
    @elseif($page->template == 'Contact Page')
      <div class="contact-template-grid">
        <div>
          <div class="dynamic-page-content">
            {!! $page->content !!}
          </div>
          <div class="contact-info-list">
            <div class="contact-info-item">
              <span class="contact-info-icon">📍</span>
              <div>
                <h5 class="contact-info-title">Atelier Address</h5>
                <p class="contact-info-text">Nomad Thread Atelier, 12, Heritage Lane, Dharavi, Mumbai, India</p>
              </div>
            </div>
            <div class="contact-info-item">
              <span class="contact-info-icon">✉</span>
              <div>
                <h5 class="contact-info-title">Email Support</h5>
                <p class="contact-info-text">support@nomadthread.in &bull; support@nomadthread.in</p>
              </div>
            </div>
          </div>
        </div>
        
        <div class="contact-form-card">
          <h3 class="contact-form-title">Send a Message</h3>
          <form onsubmit="event.preventDefault(); showToast('Your inquiry has been submitted!'); this.reset();" class="contact-form">
            <div class="form-field-wrapper">
              <label class="form-field-label">Your Name</label>
              <input type="text" required class="form-field-input">
            </div>
            <div class="form-field-wrapper">
              <label class="form-field-label">Email Address</label>
              <input type="email" required class="form-field-input">
            </div>
            <div class="form-field-wrapper">
              <label class="form-field-label">Message</label>
              <textarea required class="form-field-textarea"></textarea>
            </div>
            <button type="submit" class="form-submit-btn">Send Inquiry</button>
          </form>
        </div>
      </div>
      
    @elseif($page->template == 'Policy Page')
      <div class="policy-template-container">
        <div class="dynamic-page-content">
          {!! $page->content !!}
        </div>
      </div>
      
    @else
      <div class="dynamic-page-content">
        {!! $page->content !!}
      </div>
    @endif
    
  </div>
</section>
@endsection
