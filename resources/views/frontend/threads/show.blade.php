@extends('layouts.frontend')

@section('title', $thread->title . ' | NomadThread')

@section('content')
<div class="forum-section">
  <div class="section-inner max-width-960">
    
    <!-- Back Button -->
    <a href="{{ route('threads.index') }}" class="thread-back-link">← Back to discussions</a>

    <!-- Thread Details -->
    <article class="thread-details-container reveal">
      <div class="thread-meta margin-bottom-20">
        <span class="thread-badge">{{ $thread->location }}</span>
        <span>&bull;</span>
        <span class="thread-author">Posted by {{ $thread->user->name }}</span>
        <span>&bull;</span>
        <span>{{ $thread->created_at->format('M d, Y') }} ({{ $thread->created_at->diffForHumans() }})</span>
      </div>
      
      <h1 class="thread-details-title">{{ $thread->title }}</h1>
      
      <div class="thread-divider"></div>
      
      <div class="thread-content-body">
        {!! nl2br(e($thread->content)) !!}
      </div>
    </article>

    <!-- Comments Section -->
    <div class="reveal comments-container-margin">
      <h3 class="comments-section-title">Discussion Responses</h3>
      
      <!-- New Reply Form -->
      <div class="comment-form-card">
        <div class="comment-form-title">Write a supportive reply</div>
        <textarea class="comment-textarea" placeholder="Share your recommendations or thoughts with the community..." rows="4" id="commentText"></textarea>
        <button type="button" class="comment-submit-btn" onclick="const ta = document.getElementById('commentText'); if(ta.value.trim()) { showToast('Reply submitted successfully!'); ta.value = ''; } else { showToast('Please enter a message first.'); }">Post Reply</button>
      </div>

      <!-- Pre-rendered Comments List -->
      <div class="comments-list">
        <div class="comment-card">
          <div class="comment-meta">
            <span class="comment-author">Liam Henderson</span>
            <span>2 hours ago</span>
          </div>
          <p class="comment-text">
            This is incredibly detailed! Thanks for sharing this. I’m moving to this location next month and will definitely refer to these recommendations. Saved!
          </p>
        </div>

        <div class="comment-card">
          <div class="comment-meta">
            <span class="comment-author">Chloe Dubois</span>
            <span>5 hours ago</span>
          </div>
          <p class="comment-text">
            Agreed. I visited this spot last autumn and the speed was top-notch. Also, the food there is amazing! Highly recommended.
          </p>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
