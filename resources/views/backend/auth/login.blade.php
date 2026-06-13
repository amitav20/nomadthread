<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NomadThread — Admin Console Login</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Unified Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="admin-body login-page-bg">

    <!-- Ambient Glows -->
    <div class="ambient-glow"></div>
    <div class="ambient-glow-2"></div>

    <!-- Login Box -->
    <div class="login-card">
        
        <div class="login-header">
            <span class="logo-admin">Nomad Thread</span>
            <p class="subtitle-admin">Admin Console Login</p>
        </div>

        <!-- System Alerts -->
        @if(session('error'))
            <div class="alert-admin alert-error-admin">
                <span>⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="alert-admin alert-success-admin">
                <span>✓</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('backend.login.submit') }}" method="POST">
            @csrf

            <!-- Email -->
            <div class="form-group-admin">
                <label for="email" class="form-label-admin">Email Address</label>
                <div class="input-wrapper">
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="form-input-admin @error('email') input-error-admin @enderror" 
                        value="{{ old('email') }}" 
                        placeholder="admin@nomadthread.test" 
                        required 
                        autofocus
                    >
                </div>
                @error('email')
                    <span class="field-error-admin">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group-admin">
                <label for="password" class="form-label-admin">Password</label>
                <div class="input-wrapper">
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="form-input-admin @error('password') input-error-admin @enderror" 
                        placeholder="••••••••" 
                        required
                    >
                </div>
                @error('password')
                    <span class="field-error-admin">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="checkbox-container-admin">
                <label class="checkbox-label-admin">
                    <input type="checkbox" name="remember" class="checkbox-input-admin">
                    Remember session
                </label>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-submit-admin">
                Access Console
            </button>

        </form>

    </div>

</body>
</html>

