@extends('layouts.frontend')

@section('title', 'Sign In | Nomad Thread')

@section('content')
<section class="auth-section">
  <!-- Subtle background ambient glows -->
  <div class="auth-ambient-glow-1"></div>
  <div class="auth-ambient-glow-2"></div>

  <div class="auth-card">
    
    <div class="auth-header">
      <span class="auth-tag">
        Welcome Back
      </span>
      <h2 class="auth-title">
        Sign In to <em>Nomad</em>
      </h2>
    </div>

    <!-- Alert Messages -->
    @if(session('error'))
      <div class="auth-alert auth-alert-error">
        {{ session('error') }}
      </div>
    @endif
    @if(session('success'))
      <div class="auth-alert auth-alert-success">
        {{ session('success') }}
      </div>
    @endif

    <!-- Form -->
    <form action="{{ route('login.submit') }}" method="POST">
      @csrf

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
          placeholder="••••••••" 
          class="auth-form-input"
        >
        @error('password')
          <span class="auth-form-error">{{ $message }}</span>
        @enderror
      </div>

      <!-- Remember Me & Forgot Password -->
      <div class="auth-checkbox-row">
        <label class="auth-checkbox-label">
          <input type="checkbox" name="remember" class="auth-checkbox-input"> Remember Me
        </label>
      </div>

      <!-- Submit Button -->
      <button type="submit" class="auth-btn-submit">
        Sign In
      </button>

      <!-- Register Link -->
      <div class="auth-footer-link">
        Don't have an account? 
        <a href="{{ route('register') }}">Create Account</a>
      </div>

    </form>

  </div>
</section>
@endsection
