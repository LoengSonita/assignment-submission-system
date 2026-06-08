<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Assignment Submission System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            min-height: 100vh;
        }
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
            opacity: 0.3;
        }
        .hero-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            padding: 50px;
            position: relative;
            z-index: 1;
        }
        .feature-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 20px;
            background: white;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .feature-icon {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        .btn-custom {
            padding: 12px 35px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-custom-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
        }
        .btn-custom-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            color: white;
        }
        .btn-custom-outline {
            background: transparent;
            border: 2px solid white;
            color: white;
        }
        .btn-custom-outline:hover {
            background: white;
            color: var(--primary);
            transform: translateY(-2px);
        }
        .navbar-custom {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .footer {
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 30px 0;
            margin-top: 60px;
        }
        @media (max-width: 768px) {
            .hero-card {
                padding: 30px;
                margin: 20px;
            }
            .display-4 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                <i class="fas fa-graduation-cap me-2 text-primary"></i>
                Assignment System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    @auth
                        <li class="nav-item">
                            <a class="btn btn-primary ms-3" href="{{ url('/dashboard') }}">
                                <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-outline-primary me-2" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i> Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="hero-card text-center">
                        <i class="fas fa-graduation-cap fa-4x text-primary mb-4"></i>
                        <h1 class="display-4 fw-bold mb-3">Assignment Submission System</h1>
                        <p class="lead text-muted mb-4">
                            A complete platform for managing assignments, submissions, and grades efficiently.
                        </p>
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn btn-custom btn-custom-primary">
                                    <i class="fas fa-tachometer-alt me-2"></i> Go to Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-custom btn-custom-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i> Get Started
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-custom btn-custom-outline">
                                    <i class="fas fa-user-plus me-2"></i> Create Account
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container py-5" id="features">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Key Features</h2>
            <p class="text-muted">Everything you need to manage assignments effectively</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card p-4 text-center h-100 shadow-sm">
                    <div class="feature-icon bg-primary bg-opacity-10">
                        <i class="fas fa-chalkboard-user fa-3x text-primary"></i>
                    </div>
                    <h5 class="fw-bold mb-3">For Teachers</h5>
                    <p class="text-muted">Create courses, manage assignments, grade submissions, and provide feedback to students.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card p-4 text-center h-100 shadow-sm">
                    <div class="feature-icon bg-success bg-opacity-10">
                        <i class="fas fa-user-graduate fa-3x text-success"></i>
                    </div>
                    <h5 class="fw-bold mb-3">For Students</h5>
                    <p class="text-muted">Submit assignments, track grades, receive feedback, and manage your coursework.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card p-4 text-center h-100 shadow-sm">
                    <div class="feature-icon bg-warning bg-opacity-10">
                        <i class="fas fa-crown fa-3x text-warning"></i>
                    </div>
                    <h5 class="fw-bold mb-3">For Admins</h5>
                    <p class="text-muted">Manage users, roles, courses, and generate comprehensive reports.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="container py-5" id="about">
        <div class="row g-4 text-center">
            <div class="col-md-3">
                <div class="p-4">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h3 class="fw-bold" id="userCount">0+</h3>
                    <p class="text-muted">Active Users</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4">
                    <i class="fas fa-book fa-3x text-success mb-3"></i>
                    <h3 class="fw-bold" id="courseCount">0+</h3>
                    <p class="text-muted">Courses</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4">
                    <i class="fas fa-tasks fa-3x text-info mb-3"></i>
                    <h3 class="fw-bold" id="assignmentCount">0+</h3>
                    <p class="text-muted">Assignments</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4">
                    <i class="fas fa-paper-plane fa-3x text-warning mb-3"></i>
                    <h3 class="fw-bold" id="submissionCount">0+</h3>
                    <p class="text-muted">Submissions</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} Assignment Submission System. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animate stats on load
        document.addEventListener('DOMContentLoaded', function() {
            // Fetch stats from API (optional)
            fetch('/api/stats')
                .then(response => response.json())
                .then(data => {
                    animateNumber('userCount', data.users || 0);
                    animateNumber('courseCount', data.courses || 0);
                    animateNumber('assignmentCount', data.assignments || 0);
                    animateNumber('submissionCount', data.submissions || 0);
                })
                .catch(() => {
                    // Use static data or skip
                    console.log('Stats API not available');
                });
        });

        function animateNumber(elementId, target) {
            let element = document.getElementById(elementId);
            if (!element) return;
            let current = 0;
            let increment = target / 50;
            let timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.innerText = target + '+';
                    clearInterval(timer);
                } else {
                    element.innerText = Math.floor(current) + '+';
                }
            }, 20);
        }
    </script>
</body>
</html>
