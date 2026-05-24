<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Student Medical Record System - Secure Login Portal">
    <meta name="theme-color" content="#1e40af">
    <title>@yield('title', 'Student Medical Record System')</title>
    
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('styles')
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

    <!-- Main Content -->
    <div class="login-container">
        @yield('content')
    </div>

    <!-- Scripts -->
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

        // Enhanced input focus effects
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
                this.parentElement.parentElement.style.opacity = '1';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
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
            const passwordInput = document.getElementById('password');
            const loginForm = document.getElementById('loginForm');
            if (e.key === 'Enter' && document.activeElement === passwordInput && loginForm) {
                loginForm.dispatchEvent(new Event('submit'));
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

    @yield('scripts')
</body>
</html>
