@extends('layouts.frontend')

@section('title', 'Discussions | NomadThread')

@section('content')
@php
  $forumBanner = collect($banners)->firstWhere('position', 'Discussions Hero');
@endphp

@if($forumBanner)
  <section class="page-hero-section">
    @if(!empty($forumBanner['video']))
      <video autoplay loop muted playsinline class="hero-video-bg">
        <source src="{{ $forumBanner['video'] }}" type="video/mp4">
      </video>
    @elseif(!empty($forumBanner['image']))
      <div class="hero-image-bg" style="background-image: url('{{ $forumBanner['image'] }}');"></div>
    @endif
    <div class="hero-overlay"></div>
    <div class="section-inner">
      <span class="hero-tag">
        {{ $forumBanner['subheadline'] ?? 'Nomadic Discussions' }}
      </span>
      <h1 class="hero-title">
        <em>{{ $forumBanner['title'] }}</em>
      </h1>
      @if(!empty($forumBanner['cta_text']))
        <a href="{{ $forumBanner['cta_link'] ?? '#' }}" class="btn-primary hero-cta"><span>{{ $forumBanner['cta_text'] }}</span></a>
      @endif
    </div>
  </section>
@endif

<div class="forum-section {{ $forumBanner ? 'padded-default' : 'padded-top-only' }}">
  <div class="section-inner">
    
    <!-- Forum Header -->
    <div class="forum-header reveal {{ $forumBanner ? 'flex-between' : '' }}">
      @if(!$forumBanner)
        <div>
          <span class="section-tag">Nomadic Discussions</span>
          <h1 class="section-title">Community <em>Chronicles</em></h1>
          <p class="section-sub">Search threads, ask questions, or discover coworking hotspots globally with fellow remote professionals.</p>
        </div>
      @endif
      
      <!-- Search Form -->
      <form action="{{ route('threads.index') }}" method="GET" class="forum-search-form {{ $forumBanner ? 'margin-zero' : '' }}">
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
        <div class="thread-card reveal threads-empty-card">
          <div class="threads-empty-icon">🔍</div>
          <h3 class="thread-card-title threads-empty-h3">No Discussions Found</h3>
          <p class="thread-card-excerpt threads-empty-p">
            We couldn't find any threads matching your search term. Try searching for locations like "Bali" or "Lisbon".
          </p>
          <a href="{{ route('threads.index') }}" class="btn-primary btn-primary-padded"><span>Show All Threads</span></a>
        </div>
      @endforelse
    </div>

  </div>
</div>
@endsection
