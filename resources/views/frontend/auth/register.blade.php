@extends('layouts.frontend')

@section('title', 'Create Account | Nomad Thread')

@section('content')
<section class="auth-section">
  <!-- Subtle background ambient glows -->
  <div class="auth-ambient-glow-1"></div>
  <div class="auth-ambient-glow-2"></div>

  <div class="auth-card">
    
    <div class="auth-header">
      <span class="auth-tag">
        Join Nomad Thread
      </span>
      <h2 class="auth-title">
        Create <em>Account</em>
      </h2>
    </div>

    <!-- Form -->
    <form action="{{ route('register.submit') }}" method="POST">
      @csrf

      <!-- Name -->
      <div class="auth-form-group">
        <label class="auth-form-label">Full Name</label>
        <input 
          type="text" 
          name="name" 
          required 
          placeholder="e.g. Priya Sharma" 
          value="{{ old('name') }}" 
          class="auth-form-input"
        >
        @error('name')
          <span class="auth-form-error">{{ $message }}</span>
        @enderror
      </div>

      <!-- Email -->
      <div class="auth-form-group">
        <label class="auth-form-label">Email Address</label>
        <input 
          type="email" 
          name="email" 
          required 
          placeholder="e.g. customer@example.com" 
          value="{{ old('email') }}" 
          class="auth-form-input"
        >
        @error('email')
          <span class="auth-form-error">{{ $message }}</span>
        @enderror
      </div>

      <!-- Password -->
      <div class="auth-form-group">
        <label class="auth-form-label">Password</label>
        <input 
          type="password" 
          name="password" 
          required 
          placeholder="Min 6 characters" 
          class="auth-form-input"
        >
        @error('password')
          <span class="auth-form-error">{{ $message }}</span>
        @enderror
      </div>

      <!-- Confirm Password -->
      <div class="auth-form-group margin-bottom-25">
        <label class="auth-form-label">Confirm Password</label>
        <input 
          type="password" 
          name="password_confirmation" 
          required 
          placeholder="Repeat password" 
          class="auth-form-input"
        >
      </div>

      <!-- Submit Button -->
      <button type="submit" class="auth-btn-submit">
        Register Account
      </button>

      <!-- Login Link -->
      <div class="auth-footer-link">
        Already have an account? 
        <a href="{{ route('login') }}">Sign In</a>
      </div>

    </form>

  </div>
</section>
@endsection
