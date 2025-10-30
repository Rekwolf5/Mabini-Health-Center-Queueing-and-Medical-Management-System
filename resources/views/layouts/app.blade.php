<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mabini Health Center')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2>Health Center System</h2>
            </div>
            
            <ul class="sidebar-menu">
                <li class="{{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('staff.dashboard') }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('patients.*') ? 'active' : '' }}">
                    <a href="{{ route('patients.index') }}">
                        <i class="fas fa-user-injured"></i>
                        <span>Patients</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('queue.*') ? 'active' : '' }}">
                    <a href="{{ route('queue.index') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Queue</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('medicines.*') ? 'active' : '' }}">
                    <a href="{{ route('medicines.index') }}">
                        <i class="fas fa-capsules"></i>
                        <span>Medicines</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <a href="{{ route('reports.index') }}">
                        <i class="fas fa-file-medical-alt"></i>
                        <span>Reports</span>
                    </a>
                </li>
                
                @if(Auth::user()->role === 'staff' || Auth::user()->role === 'admin')
                <li class="{{ request()->routeIs('staff.*') ? 'active' : '' }}">
                    <a href="{{ route('staff.queue.management') }}">
                        <i class="fas fa-tasks"></i>
                        <span>Staff Tools</span>
                    </a>
                </li>
                @endif
                
                @if(Auth::user()->role === 'admin')
                <li class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-cog"></i>
                        <span>Admin Panel</span>
                    </a>
                </li>
                @endif
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <header class="top-header">
                <div class="header-left">
                    <h1>@yield('page-title', 'Dashboard')</h1>
                </div>
                <div class="header-right">
                    <div class="user-info">
                        <i class="fas fa-user-md"></i>
                        <span>{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
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
