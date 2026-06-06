<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NomadThread — Admin Console Login</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styling -->
    <style>
        :root {
            --slate-950: #020617;
            --slate-900: #0f172a;
            --slate-800: #1e293b;
            --slate-400: #94a3b8;
            --slate-200: #e2e8f0;
            --teal-400: #2dd4bf;
            --teal-500: #14b8a6;
            --rose-500: #f43f5e;
            --rose-950: #4c0519;
            --font-outfit: 'Outfit', sans-serif;
            --font-sans: 'Instrument Sans', sans-serif;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--slate-950);
            color: var(--slate-200);
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        /* Moving ambient background glow */
        .ambient-glow {
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(45, 212, 191, 0.08) 0%, rgba(15, 118, 110, 0.02) 50%, rgba(0, 0, 0, 0) 100%);
            top: -200px;
            left: -200px;
            z-index: 1;
            animation: float 20s ease-in-out infinite alternate;
        }

        .ambient-glow-2 {
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(14, 116, 144, 0.06) 0%, rgba(2, 6, 23, 0) 70%);
            bottom: -150px;
            right: -150px;
            z-index: 1;
            animation: float-reverse 25s ease-in-out infinite alternate;
        }

        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(150px, 100px) scale(1.2); }
        }

        @keyframes float-reverse {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(-100px, -150px) scale(1.1); }
        }

        /* Glassmorphic Login Container */
        .login-card {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.04);
            border-radius: 24px;
            width: 100%;
            max-width: 440px;
            padding: 48px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            z-index: 10;
            position: relative;
            box-sizing: border-box;
        }

        .login-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .logo {
            font-family: var(--font-outfit);
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 0.15em;
            background: linear-gradient(to right, var(--teal-400), #06b6d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-transform: uppercase;
            margin-bottom: 8px;
            display: inline-block;
        }

        .subtitle {
            color: var(--slate-400);
            font-size: 14px;
            margin: 0;
            letter-spacing: 0.02em;
        }

        /* Form elements */
        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--slate-400);
            margin-bottom: 8px;
            letter-spacing: 0.03em;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            background-color: rgba(2, 6, 23, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 14px 16px;
            color: #fff;
            font-family: var(--font-sans);
            font-size: 15px;
            box-sizing: border-box;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
        }

        .form-input:focus {
            border-color: var(--teal-400);
            box-shadow: 0 0 0 2px rgba(45, 212, 191, 0.15), inset 0 2px 4px rgba(0,0,0,0.3);
            background-color: rgba(2, 6, 23, 0.7);
        }

        /* Checkbox */
        .checkbox-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
            font-size: 13.5px;
            color: var(--slate-400);
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            cursor: pointer;
            user-select: none;
        }

        .checkbox-input {
            appearance: none;
            background-color: rgba(2, 6, 23, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.08);
            width: 18px;
            height: 18px;
            border-radius: 6px;
            margin-right: 8px;
            outline: none;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .checkbox-input:checked {
            background-color: var(--teal-500);
            border-color: var(--teal-400);
        }

        .checkbox-input:checked::after {
            content: "✓";
            color: #fff;
            position: absolute;
            font-size: 12px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-weight: bold;
        }

        /* Button */
        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, var(--teal-500) 0%, #0f766e 100%);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-family: var(--font-sans);
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(20, 184, 166, 0.2);
            position: relative;
            overflow: hidden;
        }

        .btn-submit::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(20, 184, 166, 0.35);
            background: linear-gradient(135deg, var(--teal-400) 0%, var(--teal-500) 100%);
        }

        .btn-submit:hover::after {
            transform: translateX(100%);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Error/Alert messages */
        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13.5px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            line-height: 1.4;
        }

        .alert-error {
            background-color: var(--rose-950);
            border: 1px solid rgba(244, 63, 94, 0.2);
            color: #fca5a5;
        }

        .alert-success {
            background-color: rgba(20, 184, 166, 0.15);
            border: 1px solid rgba(20, 184, 166, 0.2);
            color: var(--teal-400);
        }

        .field-error {
            color: var(--rose-500);
            font-size: 12.5px;
            margin-top: 6px;
            display: block;
        }

        .input-error {
            border-color: rgba(244, 63, 94, 0.3) !important;
        }

        .input-error:focus {
            box-shadow: 0 0 0 2px rgba(244, 63, 94, 0.15) !important;
        }
    </style>
</head>
<body>

    <!-- Ambient Glows -->
    <div class="ambient-glow"></div>
    <div class="ambient-glow-2"></div>

    <!-- Login Box -->
    <div class="login-card">
        
        <div class="login-header">
            <span class="logo">Nomad Thread</span>
            <p class="subtitle">Admin Console Login</p>
        </div>

        <!-- System Alerts -->
        @if(session('error'))
            <div class="alert alert-error">
                <span>⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                <span>✓</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('backend.login.submit') }}" method="POST">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-wrapper">
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="form-input @error('email') input-error @enderror" 
                        value="{{ old('email') }}" 
                        placeholder="admin@nomadthread.test" 
                        required 
                        autofocus
                    >
                </div>
                @error('email')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-wrapper">
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="form-input @error('password') input-error @enderror" 
                        placeholder="••••••••" 
                        required
                    >
                </div>
                @error('password')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="checkbox-container">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember" class="checkbox-input">
                    Remember session
                </label>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-submit">
                Access Console
            </button>

        </form>

    </div>

</body>
</html>
