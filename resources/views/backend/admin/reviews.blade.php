@extends('layouts.admin')

@section('title', 'Reviews | LeatherCraft')
@section('page_title', 'Reviews')
@section('page_breadcrumb', 'Sales / Reviews')

@section('content')
<div class="page-header">
  <div><div class="page-heading">Reviews</div><div class="page-subheading">Manage customer feedback</div></div>
</div>
<div class="stats-grid" style="grid-template-columns:repeat(4,1fr);">
  <div class="stat-card"><div class="stat-label">Avg. Rating</div><div class="stat-value" style="color:var(--gold2);">{{ number_format($reviews->avg('rating') ?: 4.8, 1) }} ★</div></div>
  <div class="stat-card"><div class="stat-label">5 Star</div><div class="stat-value" style="font-size:20px;">{{ $reviews->count() > 0 ? round(($reviews->where('rating', 5)->count() / $reviews->count()) * 100) : 75 }}%</div></div>
  <div class="stat-card"><div class="stat-label">4 Star</div><div class="stat-value" style="font-size:20px;">{{ $reviews->count() > 0 ? round(($reviews->where('rating', 4)->count() / $reviews->count()) * 100) : 20 }}%</div></div>
  <div class="stat-card"><div class="stat-label">1–3 Star</div><div class="stat-value" style="font-size:20px;">{{ $reviews->count() > 0 ? round(($reviews->where('rating', '<=', 3)->count() / $reviews->count()) * 100) : 5 }}%</div></div>
</div>
<div class="card">
  <div class="card-head"><div class="card-title">Recent Reviews</div></div>
  @forelse($reviews as $rev)
    <div class="review-item" style="padding: 20px; border-bottom: 1px solid var(--border)">
      <div class="review-head" style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 8px;">
        <div>
          <strong style="font-size:13px;color:var(--text);">{{ $rev->product->name ?? 'Unspecified Product' }}</strong> 
          <span class="review-stars" style="color:var(--gold); margin-left: 8px;">
            @for($i = 0; $i < 5; $i++)
              @if($i < $rev->rating)
                ★
              @else
                ☆
              @endif
            @endfor
          </span>
        </div>
        <span class="badge @if($rev->status == 'Approved' || $rev->status == 'active') badge-green @else badge-amber @endif">{{ ucfirst($rev->status) }}</span>
      </div>
      <div style="font-size:13px;color:var(--text2); font-style: italic;">"{{ $rev->review_text }}"</div>
      <div style="font-size:12px;color:var(--text3);margin-top:6px;">— {{ $rev->customer_name }} &middot; {{ $rev->created_at ? $rev->created_at->format('d M Y') : 'Recent' }}</div>
    </div>
  @empty
    <div style="padding: 30px; text-align:center; color: var(--text3)">No reviews found.</div>
  @endforelse
</div>
@endsection
