@extends('layouts.frontend')

@section('title', 'Discussions | NomadThread')

@section('content')
@php
  $forumBanner = collect($banners)->firstWhere('position', 'Discussions Hero');
@endphp

@if($forumBanner)
  <section class="page-hero-section" style="padding: 120px 0 60px; background: var(--espresso); position: relative; overflow: hidden; min-height: 250px; display: flex; align-items: center; justify-content: center; text-align: center;">
    @if(!empty($forumBanner['video']))
      <video autoplay loop muted playsinline style="position: absolute; inset: 0; width:100%; height:100%; object-fit:cover; opacity: 0.4;">
        <source src="{{ $forumBanner['video'] }}" type="video/mp4">
      </video>
    @elseif(!empty($forumBanner['image']))
      <div style="position: absolute; inset:0; background-image: url('{{ $forumBanner['image'] }}'); background-size: cover; background-position: center; opacity: 0.4;"></div>
    @endif
    <div style="position: absolute; inset:0; background: linear-gradient(to bottom, rgba(44,26,14,0.6), rgba(44,26,14,0.85)); z-index:1;"></div>
    <div class="section-inner" style="position: relative; z-index: 2;">
      <span style="font-family:'Jost', sans-serif; font-size:10px; letter-spacing:4px; text-transform:uppercase; color:var(--tan-light); margin-bottom:12px; display:block;">
        {{ $forumBanner['subheadline'] ?? 'Nomadic Discussions' }}
      </span>
      <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(32px, 4vw, 52px); font-weight: 700; color: var(--cream); line-height: 1.2;">
        <em>{{ $forumBanner['title'] }}</em>
      </h1>
      @if(!empty($forumBanner['cta_text']))
        <a href="{{ $forumBanner['cta_link'] ?? '#' }}" class="btn-primary" style="margin-top: 15px; display: inline-block; padding: 12px 28px;"><span>{{ $forumBanner['cta_text'] }}</span></a>
      @endif
    </div>
  </section>
@endif

<div class="forum-section" style="{{ $forumBanner ? 'padding: 60px 0;' : 'padding-top: 140px;' }}">
  <div class="section-inner">
    
    <!-- Forum Header -->
    <div class="forum-header reveal" style="{{ $forumBanner ? 'display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--border); padding-bottom:30px; margin-bottom:40px;' : '' }}">
      @if(!$forumBanner)
        <div>
          <span class="section-tag" style="margin-bottom:8px">Nomadic Discussions</span>
          <h1 class="section-title" style="font-size:36px; margin-bottom:12px">Community <em>Chronicles</em></h1>
          <p class="section-sub" style="margin:0; text-align:left; max-width:540px">Search threads, ask questions, or discover coworking hotspots globally with fellow remote professionals.</p>
        </div>
      @endif
      
      <!-- Search Form -->
      <form action="{{ route('threads.index') }}" method="GET" class="forum-search-form" style="{{ $forumBanner ? 'margin-top:0;' : '' }}">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search location or keywords..." class="forum-search-input" />
        <button type="submit" class="forum-search-btn">Search</button>
        @if(request('search'))
          <a href="{{ route('threads.index') }}" class="forum-clear-btn">Clear</a>
        @endif
      </form>
    </div>

    <!-- Threads List -->
    <div class="threads-list">
      @forelse($threads as $thread)
        <a href="{{ route('threads.show', $thread->id) }}" class="thread-card reveal">
          <div class="thread-meta">
            <span class="thread-badge">{{ $thread->location }}</span>
            <span>&bull;</span>
            <span class="thread-author">By {{ $thread->user->name }}</span>
            <span>&bull;</span>
            <span>{{ $thread->created_at->diffForHumans() }}</span>
          </div>
          
          <h2 class="thread-card-title">{{ $thread->title }}</h2>
          
          <p class="thread-card-excerpt">
            {{ Str::limit($thread->content, 180, '...') }}
          </p>
          
          <div class="thread-card-footer">
            <span>Posted {{ $thread->created_at->format('M d, Y') }}</span>
            <span class="thread-read-more">Read Thread</span>
          </div>
        </a>
      @empty
        <div class="thread-card reveal" style="text-align:center; padding: 80px 40px;">
          <div style="font-size:48px; margin-bottom:20px; opacity:0.4">🔍</div>
          <h3 class="thread-card-title" style="margin-bottom:8px">No Discussions Found</h3>
          <p class="thread-card-excerpt" style="max-width:480px; margin:0 auto 24px">
            We couldn't find any threads matching your search term. Try searching for locations like "Bali" or "Lisbon".
          </p>
          <a href="{{ route('threads.index') }}" class="btn-primary" style="padding: 12px 28px"><span>Show All Threads</span></a>
        </div>
      @endforelse
    </div>

  </div>
</div>
@endsection
