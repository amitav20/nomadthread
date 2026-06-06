@extends('layouts.frontend')

@section('title', 'Nomad Thread — ' . ($page->meta_title ?: $page->title))

@section('content')
<!-- Page Banner Header -->
<section class="page-hero-section" style="padding: 120px 0 60px; background: var(--espresso); position: relative; overflow: hidden; min-height: 250px; display: flex; align-items: center; justify-content: center; text-align: center;">
  @if($pageBanner)
    @if(!empty($pageBanner['video']))
      <video autoplay loop muted playsinline style="position: absolute; inset: 0; width:100%; height:100%; object-fit:cover; opacity: 0.4;">
        <source src="{{ $pageBanner['video'] }}" type="video/mp4">
      </video>
    @elseif(!empty($pageBanner['image']))
      <div style="position: absolute; inset:0; background-image: url('{{ $pageBanner['image'] }}'); background-size: cover; background-position: center; opacity: 0.4;"></div>
    @endif
  @elseif(!empty($page->featured_image))
    <div style="position: absolute; inset:0; background-image: url('{{ $page->featured_image }}'); background-size: cover; background-position: center; opacity: 0.3;"></div>
  @endif

  <div style="position: absolute; inset:0; background: linear-gradient(to bottom, rgba(44,26,14,0.6), rgba(44,26,14,0.85)); z-index:1;"></div>

  <div class="section-inner" style="position: relative; z-index: 2;">
    <span style="font-family:'Jost', sans-serif; font-size:10px; letter-spacing:4px; text-transform:uppercase; color:var(--tan-light); margin-bottom:12px; display:block;">
      {{ $page->page_type }}
    </span>
    <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(32px, 4vw, 52px); font-weight: 700; color: var(--cream); line-height: 1.2;">
      <em>{{ $page->title }}</em>
    </h1>
    <div style="display:flex; justify-content:center; gap:8px; font-family:'Jost', sans-serif; font-size:12px; color:var(--tan-light); margin-top:15px; opacity:0.8;">
      <a href="{{ route('home') }}" style="color:inherit; text-decoration:none;">Home</a>
      <span>/</span>
      <span style="color:var(--gold);">{{ $page->title }}</span>
    </div>
  </div>
</section>

<!-- Page Content Section -->
<section style="padding: 80px 0; background: var(--warm-white); min-height: 50vh;">
  <div class="section-inner" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    
    @if($page->template == 'With Sidebar')
      <div style="display: grid; grid-template-columns: 2.5fr 1fr; gap: 60px;">
        <div class="dynamic-page-content" style="font-family:'Cormorant Garamond', serif; font-size:20px; line-height:1.7; color:var(--text-dark);">
          {!! $page->content !!}
        </div>
        <div style="background:var(--cream); border: 1px solid var(--border); padding: 30px; border-radius: 8px;">
          <h4 style="font-family:'Jost', sans-serif; font-size:14px; letter-spacing:2px; text-transform:uppercase; color:var(--espresso); margin-bottom: 20px; font-weight:600; border-bottom:1px solid var(--border); padding-bottom:10px;">Information</h4>
          <p style="font-family:'Jost', sans-serif; font-size:13px; color:var(--text-mid); line-height:1.6; margin-bottom: 15px;">Need immediate assistance or have questions about our premium leathercraft?</p>
          <a href="/shop" style="display:block; text-align:center; padding:12px; background:var(--espresso); color:var(--cream); font-family:'Jost', sans-serif; font-size:11px; letter-spacing:2px; text-transform:uppercase; text-decoration:none; font-weight:500;">Explore Shop</a>
        </div>
      </div>
      
    @elseif($page->template == 'Contact Page')
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: start;">
        <div>
          <div class="dynamic-page-content" style="font-family:'Cormorant Garamond', serif; font-size:20px; line-height:1.7; color:var(--text-dark); margin-bottom:40px;">
            {!! $page->content !!}
          </div>
          <div style="display:flex; flex-direction:column; gap:20px;">
            <div style="display:flex; gap:15px; align-items:flex-start;">
              <span style="font-size:24px; color:var(--tan-dark);">📍</span>
              <div>
                <h5 style="font-family:'Jost', sans-serif; font-size:13px; letter-spacing:1.5px; text-transform:uppercase; color:var(--espresso); margin-bottom:4px; font-weight:600;">Atelier Address</h5>
                <p style="font-family:'Jost', sans-serif; font-size:14px; color:var(--text-mid); line-height:1.5;">Nomad Thread Atelier, 12, Heritage Lane, Dharavi, Mumbai, India</p>
              </div>
            </div>
            <div style="display:flex; gap:15px; align-items:flex-start;">
              <span style="font-size:24px; color:var(--tan-dark);">✉</span>
              <div>
                <h5 style="font-family:'Jost', sans-serif; font-size:13px; letter-spacing:1.5px; text-transform:uppercase; color:var(--espresso); margin-bottom:4px; font-weight:600;">Email Support</h5>
                <p style="font-family:'Jost', sans-serif; font-size:14px; color:var(--text-mid); line-height:1.5;">support@nomadthread.in &bull; sales@nomadthread.in</p>
              </div>
            </div>
          </div>
        </div>
        
        <div style="background:var(--cream); border:1px solid var(--border); padding: 40px; border-radius: 8px;">
          <h3 style="font-family:'Playfair Display', serif; font-weight:600; font-size:26px; color:var(--espresso); margin-bottom:20px;">Send a Message</h3>
          <form onsubmit="event.preventDefault(); showToast('Your inquiry has been submitted!'); this.reset();" style="display:flex; flex-direction:column; gap:20px;">
            <div style="display:flex; flex-direction:column; gap:6px;">
              <label style="font-family:'Jost', sans-serif; font-size:11px; letter-spacing:1px; text-transform:uppercase; color:var(--text-mid); font-weight:500;">Your Name</label>
              <input type="text" required style="padding:12px; background:var(--warm-white); border:1px solid var(--border); outline:none; font-family:'Jost', sans-serif; font-size:13.5px; color:var(--text-dark);">
            </div>
            <div style="display:flex; flex-direction:column; gap:6px;">
              <label style="font-family:'Jost', sans-serif; font-size:11px; letter-spacing:1px; text-transform:uppercase; color:var(--text-mid); font-weight:500;">Email Address</label>
              <input type="email" required style="padding:12px; background:var(--warm-white); border:1px solid var(--border); outline:none; font-family:'Jost', sans-serif; font-size:13.5px; color:var(--text-dark);">
            </div>
            <div style="display:flex; flex-direction:column; gap:6px;">
              <label style="font-family:'Jost', sans-serif; font-size:11px; letter-spacing:1px; text-transform:uppercase; color:var(--text-mid); font-weight:500;">Message</label>
              <textarea required style="padding:12px; min-height:120px; background:var(--warm-white); border:1px solid var(--border); outline:none; font-family:'Jost', sans-serif; font-size:13.5px; color:var(--text-dark); resize:none;"></textarea>
            </div>
            <button type="submit" style="padding:14px; background:var(--espresso); color:var(--cream); border:none; font-family:'Jost', sans-serif; font-size:11px; letter-spacing:2px; text-transform:uppercase; font-weight:600; cursor:pointer; transition:all 0.2s;">Send Inquiry</button>
          </form>
        </div>
      </div>
      
    @elseif($page->template == 'Policy Page')
      <div style="max-width: 800px; margin: 0 auto;">
        <div class="dynamic-page-content" style="font-family:'DM Sans', sans-serif; font-size:15px; line-height:1.8; color:var(--text-dark);">
          {!! $page->content !!}
        </div>
      </div>
      
    @else
      <div class="dynamic-page-content" style="font-family:'Cormorant Garamond', serif; font-size:20px; line-height:1.7; color:var(--text-dark);">
        {!! $page->content !!}
      </div>
    @endif
    
  </div>
</section>
@endsection
