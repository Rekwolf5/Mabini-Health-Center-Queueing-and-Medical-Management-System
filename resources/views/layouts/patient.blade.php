<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Patient Portal - Mabini Health Center')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="app-container">
        <!-- Patient Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2>Patient Portal</h2>
            </div>
            
            <ul class="sidebar-menu">
                <li class="{{ request()->routeIs('patient.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('patient.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('patient.profile') ? 'active' : '' }}">
                    <a href="{{ route('patient.profile') }}">
                        <i class="fas fa-user"></i>
                        <span>My Profile</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('patient.medical-history') ? 'active' : '' }}">
                    <a href="{{ route('patient.medical-history') }}">
                        <i class="fas fa-file-medical-alt"></i>
                        <span>Medical History</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <header class="top-header">
                <div class="header-left">
                    <h1>@yield('page-title', 'Patient Portal')</h1>
                </div>
                <div class="header-right">
                    <div class="user-info">
                        <i class="fas fa-user"></i>
                        <span>{{ Auth::guard('patient')->user()->full_name }}</span>
                        <form method="POST" action="{{ route('patient.logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="logout-btn">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <div class="content">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
