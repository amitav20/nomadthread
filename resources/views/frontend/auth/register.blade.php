@extends('layouts.frontend')

@section('title', 'Create Account | Nomad Thread')

@section('content')
<section style="padding-top: 160px; padding-bottom: 90px; min-height: 85vh; background: var(--bg); display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
  <!-- Subtle background ambient glows -->
  <div style="position: absolute; width: 400px; height: 400px; border-radius: 50%; background: radial-gradient(circle, rgba(201, 168, 76, 0.05) 0%, rgba(0, 0, 0, 0) 70%); top: 10%; left: 5%; pointer-events: none;"></div>
  <div style="position: absolute; width: 450px; height: 450px; border-radius: 50%; background: radial-gradient(circle, rgba(201, 168, 76, 0.03) 0%, rgba(0, 0, 0, 0) 70%); bottom: 10%; right: 5%; pointer-events: none;"></div>

  <div class="login-card" style="background: var(--bg-card); border: 1px solid var(--border); border-radius: 8px; width: 100%; max-width: 440px; padding: 40px; box-shadow: 0 15px 35px rgba(0,0,0,0.6); z-index: 10; font-family: 'Jost', sans-serif; box-sizing: border-box;">
    
    <div style="text-align: center; margin-bottom: 30px;">
      <span style="font-family: 'Jost', sans-serif; font-size: 11px; text-transform: uppercase; letter-spacing: 3px; color: var(--gold); display: block; margin-bottom: 6px;">
        Join Nomad Thread
      </span>
      <h2 style="font-family: 'Playfair Display', serif; font-size: 28px; color: var(--cream); margin: 0; font-weight: 500;">
        Create <em>Account</em>
      </h2>
    </div>

    <!-- Form -->
    <form action="{{ route('register.submit') }}" method="POST">
      @csrf

      <!-- Name -->
      <div style="margin-bottom: 20px;">
        <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Full Name</label>
        <input 
          type="text" 
          name="name" 
          required 
          placeholder="e.g. Priya Sharma" 
          value="{{ old('name') }}" 
          style="width: 100%; background: var(--bg3); border: 1px solid var(--border); border-radius: 4px; padding: 12px; color: #fff; font-family: 'Jost', sans-serif; font-size: 14px; outline: none; box-sizing: border-box; transition: border-color 0.2s;"
          onfocus="this.style.borderColor='var(--gold)';"
          onblur="this.style.borderColor='var(--border)';"
        >
        @error('name')
          <span style="color: var(--red2); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
        @enderror
      </div>

      <!-- Email -->
      <div style="margin-bottom: 20px;">
        <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Email Address</label>
        <input 
          type="email" 
          name="email" 
          required 
          placeholder="e.g. customer@example.com" 
          value="{{ old('email') }}" 
          style="width: 100%; background: var(--bg3); border: 1px solid var(--border); border-radius: 4px; padding: 12px; color: #fff; font-family: 'Jost', sans-serif; font-size: 14px; outline: none; box-sizing: border-box; transition: border-color 0.2s;"
          onfocus="this.style.borderColor='var(--gold)';"
          onblur="this.style.borderColor='var(--border)';"
        >
        @error('email')
          <span style="color: var(--red2); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
        @enderror
      </div>

      <!-- Password -->
      <div style="margin-bottom: 20px;">
        <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Password</label>
        <input 
          type="password" 
          name="password" 
          required 
          placeholder="Min 6 characters" 
          style="width: 100%; background: var(--bg3); border: 1px solid var(--border); border-radius: 4px; padding: 12px; color: #fff; font-family: 'Jost', sans-serif; font-size: 14px; outline: none; box-sizing: border-box; transition: border-color 0.2s;"
          onfocus="this.style.borderColor='var(--gold)';"
          onblur="this.style.borderColor='var(--border)';"
        >
        @error('password')
          <span style="color: var(--red2); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
        @enderror
      </div>

      <!-- Confirm Password -->
      <div style="margin-bottom: 25px;">
        <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Confirm Password</label>
        <input 
          type="password" 
          name="password_confirmation" 
          required 
          placeholder="Repeat password" 
          style="width: 100%; background: var(--bg3); border: 1px solid var(--border); border-radius: 4px; padding: 12px; color: #fff; font-family: 'Jost', sans-serif; font-size: 14px; outline: none; box-sizing: border-box; transition: border-color 0.2s;"
          onfocus="this.style.borderColor='var(--gold)';"
          onblur="this.style.borderColor='var(--border)';"
        >
      </div>

      <!-- Submit Button -->
      <button type="submit" class="btn-checkout" style="width: 100%; border: none; padding: 14px; background: var(--gold); color: var(--bg); font-family: 'Jost', sans-serif; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; border-radius: 4px; cursor: pointer; transition: all 0.2s;">
        Register Account
      </button>

      <!-- Login Link -->
      <div style="text-align: center; margin-top: 25px; font-size: 13.5px; color: var(--text-light);">
        Already have an account? 
        <a href="{{ route('login') }}" style="color: var(--gold); text-decoration: none; font-weight: 600; margin-left: 4px;" onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';">Sign In</a>
      </div>

    </form>

  </div>
</section>
@endsection
