<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Medical Record System - Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #1e40af;
            --primary-light: #3b82f6;
            --secondary: #06b6d4;
            --accent: #c084fc;
            --accent-light: #f0f9ff;
            --success: #10b981;
            --danger: #ef4444;
            --glass-dark: rgba(15, 23, 42, 0.8);
            --glass-light: rgba(255, 255, 255, 0.1);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 25%, #312e81 50%, #1e293b 75%, #0f172a 100%);
            background-size: 400% 400%;
            animation: gradientShift 20s ease infinite;
            position: relative;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Animated Particles Background */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            overflow: hidden;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.8), rgba(6, 182, 212, 0.3));
            border-radius: 50%;
            opacity: 0;
        }

        .particle.active {
            animation: float-particle 20s linear infinite;
        }

        @keyframes float-particle {
            0% {
                opacity: 0;
                transform: translateY(100vh) translateX(0px);
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                opacity: 0;
                transform: translateY(-100vh) translateX(100px);
            }
        }

        /* Animated Background Blobs */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            overflow: hidden;
        }

        .blob {
            position: absolute;
            opacity: 0.08;
            filter: blur(80px);
            mix-blend-mode: screen;
        }

        .blob-1 {
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, #3b82f6, transparent);
            top: -200px;
            left: -200px;
            animation: blob-animation-1 25s infinite ease-in-out;
        }

        .blob-2 {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, #06b6d4, transparent);
            bottom: -100px;
            right: -100px;
            animation: blob-animation-2 30s infinite ease-in-out;
        }

        .blob-3 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, #c084fc, transparent);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: blob-animation-3 35s infinite ease-in-out;
        }

        @keyframes blob-animation-1 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(50px, -50px) scale(1.1); }
            66% { transform: translate(-30px, 30px) scale(0.9); }
        }

        @keyframes blob-animation-2 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(-50px, 50px) scale(0.9); }
            66% { transform: translate(30px, -30px) scale(1.1); }
        }

        @keyframes blob-animation-3 {
            0%, 100% { transform: translate(-50%, -50%) scale(1); }
            50% { transform: translate(-50%, -50%) scale(1.15); }
        }

        /* Login Container */
        .login-container {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Enhanced Glassmorphism Card */
        .login-card {
            backdrop-filter: blur(20px);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.02) 100%);
            border: 1.5px solid rgba(255, 255, 255, 0.15);
            border-radius: 32px;
            padding: 60px 48px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3),
                        inset 0 1px 2px rgba(255, 255, 255, 0.1),
                        inset 0 0 40px rgba(59, 130, 246, 0.05);
            animation: slideInUp 0.7s cubic-bezier(0.34, 1.56, 0.64, 1);
            transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.95);
                filter: blur(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        .login-card:hover {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.03) 100%);
            border-color: rgba(255, 255, 255, 0.25);
            box-shadow: 0 25px 80px rgba(59, 130, 246, 0.15),
                        inset 0 1px 2px rgba(255, 255, 255, 0.2),
                        inset 0 0 60px rgba(59, 130, 246, 0.08);
            transform: translateY(-5px);
        }

        /* Header Section */
        .login-header {
            text-align: center;
            margin-bottom: 50px;
            position: relative;
        }

        .logo-container {
            position: relative;
            width: 90px;
            height: 90px;
            margin: 0 auto 30px;
        }

        .logo-icon {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--secondary) 100%);
            border-radius: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 45px;
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.3),
                        inset 0 -2px 8px rgba(0, 0, 0, 0.2),
                        inset 0 2px 8px rgba(255, 255, 255, 0.1);
            animation: logoFloat 3.5s cubic-bezier(0.45, 0, 0.55, 1) infinite;
            position: relative;
            color: white;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0px) rotateZ(0deg); }
            50% { transform: translateY(-15px) rotateZ(5deg); }
        }

        .logo-icon::before {
            content: '';
            position: absolute;
            inset: -3px;
            background: linear-gradient(45deg, var(--primary-light), var(--secondary), var(--accent));
            border-radius: 28px;
            opacity: 0.3;
            filter: blur(10px);
            animation: logoGlow 3.5s ease-in-out infinite;
        }

        @keyframes logoGlow {
            0%, 100% { opacity: 0.2; }
            50% { opacity: 0.5; }
        }

        .login-header h1 {
            font-size: 32px;
            font-weight: 800;
            background: linear-gradient(135deg, #ffffff 0%, #e0f2fe 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 12px;
            letter-spacing: -0.8px;
        }

        .login-header .tagline {
            color: rgba(255, 255, 255, 0.7);
            font-size: 15px;
            font-weight: 500;
            letter-spacing: 0.3px;
            margin-bottom: 4px;
        }

        .login-header .subtitle {
            color: rgba(59, 130, 246, 0.8);
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        /* Form Section */
        .form-group {
            margin-bottom: 28px;
            animation: fadeInUp 0.6s ease-out;
            animation-fill-mode: both;
        }

        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }
        .form-group:nth-child(3) { animation-delay: 0.3s; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-label {
            display: block;
            margin-bottom: 10px;
            color: rgba(255, 255, 255, 0.95);
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            color: rgba(59, 130, 246, 0.5);
            font-size: 18px;
            pointer-events: none;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
            z-index: 2;
        }

        .form-input {
            width: 100%;
            padding: 16px 16px 16px 52px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.03) 100%);
            border: 1.5px solid rgba(255, 255, 255, 0.12);
            border-radius: 14px;
            color: white;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
            backdrop-filter: blur(10px);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .form-input:focus {
            outline: none;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0.05) 100%);
            border-color: rgba(59, 130, 246, 0.5);
            box-shadow: 0 0 30px rgba(59, 130, 246, 0.25),
                        inset 0 1px 3px rgba(255, 255, 255, 0.1);
        }

        .form-input:focus ~ .input-icon {
            color: var(--primary-light);
            transform: scale(1.15);
        }

        .form-input.error {
            border-color: rgba(239, 68, 68, 0.5);
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.08) 0%, rgba(239, 68, 68, 0.03) 100%);
        }

        .form-input.error:focus {
            box-shadow: 0 0 30px rgba(239, 68, 68, 0.25),
                        inset 0 1px 3px rgba(255, 255, 255, 0.1);
        }

        /* Error Messages */
        .error-message {
            color: #fca5a5;
            font-size: 13px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            animation: slideError 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes slideError {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Alert Messages */
        .form-alert {
            animation: slideInDown 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.03) 100%);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 28px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-alert.error {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);
            border-color: rgba(239, 68, 68, 0.3);
            color: #fecaca;
        }

        .form-alert.success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
            border-color: rgba(16, 185, 129, 0.3);
            color: #a7f3d0;
        }

        /* Checkbox & Links Row */
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            gap: 16px;
            flex-wrap: wrap;
            animation: fadeInUp 0.6s ease-out;
            animation-delay: 0.4s;
            animation-fill-mode: both;
        }

        .remember-group {
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
        }

        .checkbox {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: var(--primary-light);
            appearance: none;
            -webkit-appearance: none;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.03) 100%);
            border: 1.5px solid rgba(255, 255, 255, 0.15);
            border-radius: 6px;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
            position: relative;
        }

        .checkbox:hover {
            border-color: rgba(59, 130, 246, 0.4);
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
        }

        .checkbox:checked {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--secondary) 100%);
            border-color: var(--secondary);
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.3),
                        inset 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .checkbox:checked::after {
            content: '✓';
            position: absolute;
            color: white;
            font-size: 12px;
            font-weight: bold;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .remember-label {
            color: rgba(255, 255, 255, 0.85);
            font-size: 14px;
            cursor: pointer;
            user-select: none;
            transition: color 0.3s ease;
            font-weight: 500;
        }

        .remember-label:hover {
            color: white;
        }

        .forgot-link {
            color: var(--secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
            position: relative;
        }

        .forgot-link:hover {
            color: var(--primary-light);
        }

        .forgot-link::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-light), var(--secondary));
            transition: width 0.4s cubic-bezier(0.23, 1, 0.320, 1);
        }

        .forgot-link:hover::after {
            width: 100%;
        }

        /* Login Button */
        .btn-login {
            width: 100%;
            padding: 18px 24px;
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.6px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
            box-shadow: 0 15px 40px rgba(59, 130, 246, 0.35),
                        inset 0 -2px 8px rgba(0, 0, 0, 0.2),
                        inset 0 2px 8px rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.6s ease-out;
            animation-delay: 0.45s;
            animation-fill-mode: both;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 50px rgba(59, 130, 246, 0.45),
                        inset 0 -2px 8px rgba(0, 0, 0, 0.15),
                        inset 0 2px 8px rgba(255, 255, 255, 0.15);
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:active {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3),
                        inset 0 -2px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-login:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Register Link */
        .register-section {
            text-align: center;
            margin-top: 32px;
            padding-top: 32px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            animation: fadeInUp 0.6s ease-out;
            animation-delay: 0.5s;
            animation-fill-mode: both;
        }

        .register-text {
            color: rgba(255, 255, 255, 0.85);
            font-size: 14px;
            font-weight: 500;
        }

        .register-link {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
            position: relative;
            cursor: pointer;
        }

        .register-link:hover {
            transform: translateY(-2px);
            filter: brightness(1.2);
        }

        .register-link::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-light), var(--secondary));
            transition: width 0.4s cubic-bezier(0.23, 1, 0.320, 1);
        }

        .register-link:hover::after {
            width: 100%;
        }

        /* Loading Animation */
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @keyframes pulse-ring {
            0% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
            }
        }

        .btn-login.loading {
            opacity: 0.85;
        }

        .btn-login.loading span {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            margin-left: 8px;
            animation: spin 0.8s linear infinite;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-card {
                padding: 50px 36px;
            }

            .login-header h1 {
                font-size: 28px;
            }

            .logo-icon {
                width: 80px;
                height: 80px;
                font-size: 40px;
            }
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 40px 24px;
                max-width: 100%;
            }

            .login-header {
                margin-bottom: 40px;
            }

            .login-header h1 {
                font-size: 24px;
            }

            .logo-icon {
                width: 70px;
                height: 70px;
                font-size: 35px;
            }

            .form-input {
                padding: 14px 14px 14px 48px;
                font-size: 15px;
            }

            .form-footer {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .forgot-link {
                align-self: flex-start;
            }

            .btn-login {
                padding: 16px 20px;
                font-size: 15px;
            }
        }

        /* Accessibility */
        .form-input:focus-visible {
            outline: 2px solid var(--primary-light);
            outline-offset: 2px;
        }

        .btn-login:focus-visible {
            outline: 2px solid rgba(255, 255, 255, 0.5);
            outline-offset: 2px;
        }

        a:focus-visible {
            outline: 2px solid var(--secondary);
            outline-offset: 2px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <!-- Animated Particle Background -->
    <div class="particles" id="particleContainer"></div>

    <!-- Animated Gradient Blobs -->
    <div class="animated-bg">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>

    <!-- Main Login Container -->
    <div class="login-container">
        <div class="login-card">
            <!-- Header Section -->
            <div class="login-header">
                <div class="logo-container">
                    <div class="logo-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                </div>
                <h1>Welcome Back</h1>
                <div class="tagline">Student Medical Record System</div>
                <div class="subtitle">
                    <i class="fas fa-stethoscope"></i>
                    Health & Academic Portal
                </div>
            </div>

            <!-- Display Validation Errors -->
            @if ($errors->any())
                <div class="form-alert error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Invalid credentials. Please try again.</span>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" id="loginForm" autocomplete="off">
                @csrf

                <!-- Email Input -->
                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope" style="margin-right: 6px; opacity: 0.7;"></i>
                        Email Address
                    </label>
                    <div class="input-wrapper">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input @error('email') error @enderror"
                            placeholder="Enter your email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            aria-label="Email Address"
                        >
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                    @error('email')
                        <div class="error-message">
                            <i class="fas fa-times-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock" style="margin-right: 6px; opacity: 0.7;"></i>
                        Password
                    </label>
                    <div class="input-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input @error('password') error @enderror"
                            placeholder="Enter your password"
                            required
                            aria-label="Password"
                        >
                        <i class="fas fa-lock input-icon"></i>
                    </div>
                    @error('password')
                        <div class="error-message">
                            <i class="fas fa-times-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="form-footer">
                    <div class="remember-group">
                        <input
                            type="checkbox"
                            id="remember"
                            name="remember"
                            class="checkbox"
                            {{ old('remember') ? 'checked' : '' }}
                            aria-label="Remember me"
                        >
                        <label for="remember" class="remember-label">Remember me</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <button type="submit" class="btn-login" id="submitBtn">
                    <i class="fas fa-arrow-right" style="margin-right: 8px;"></i>
                    Sign In Now
                </button>
            </form>

            <!-- Register Section -->
            @if (Route::has('register'))
                <div class="register-section">
                    <span class="register-text">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="register-link">Create Account</a>
                    </span>
                </div>
            @endif
        </div>
    </div>

    <!-- Enhanced Scripts -->
    <script>
        // Particle Animation System
        function createParticles() {
            const container = document.getElementById('particleContainer');
            if (!container) return;

            const particleCount = window.innerWidth > 768 ? 50 : 20;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle active';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 20 + 's';
                particle.style.animationDuration = (15 + Math.random() * 15) + 's';
                container.appendChild(particle);
            }
        }

        // Initialize particles on load
        window.addEventListener('load', createParticles);

        // Form submission handling
        const loginForm = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');

        if (loginForm && submitBtn) {
            loginForm.addEventListener('submit', function(e) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span></span> Signing in...';
            });
        }

        // Enhanced input focus effects
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                if (this.parentElement) {
                    this.parentElement.style.transform = 'scale(1.02)';
                }
            });

            input.addEventListener('blur', function() {
                if (this.parentElement) {
                    this.parentElement.style.transform = 'scale(1)';
                }
            });

            // Real-time validation feedback
            input.addEventListener('input', function() {
                if (this.classList.contains('error') && this.value.trim()) {
                    this.classList.remove('error');
                }
            });
        });

        // Smooth page load animation
        window.addEventListener('load', function() {
            document.body.style.opacity = '1';
        });

        // Prevent form resubmission on page refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        // Accessibility: Enhanced keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && document.activeElement === document.getElementById('password')) {
                if (loginForm) {
                    loginForm.dispatchEvent(new Event('submit'));
                }
            }
        });

        // Responsive particle adjustment
        window.addEventListener('resize', function() {
            const container = document.getElementById('particleContainer');
            if (container) {
                container.innerHTML = '';
                createParticles();
            }
        });
    </script>
</body>
</html>
