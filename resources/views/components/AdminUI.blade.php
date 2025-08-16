<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .nav-link {
            transition: all 0.2s ease;
            border-radius: 4px;
            padding: 8px 12px !important;
            margin-bottom: 4px;
        }
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(4px);
        }
        .sidebar-heading {
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .section-heading {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        .user-greeting {
            font-weight: 500;
        }
        main {
            background-color: #f8f9fa;
        }
        .logout-link {
            transition: all 0.2s ease;
        }
        .logout-link:hover {
            opacity: 0.8;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="d-flex vh-100">

    <!-- Sidebar -->
    <aside class="bg-dark text-white p-3" style="width: 250px;">
        <h3 class="mb-4 sidebar-heading">{{ $title ?? 'Admin Panel' }}</h3>
        <nav class="nav flex-column">
            <a class="nav-link text-white" href="{{route('admin.dashboard')}}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard Overview
            </a>

            <h6 class="section-heading text-muted mt-3">Users</h6>
            <a class="nav-link text-white ms-3" href="{{ route('admin.users') }}">
                <i class="bi bi-people me-2"></i> View Users
            </a>

            <h6 class="section-heading text-muted mt-3">Subjects</h6>
            <a class="nav-link text-white ms-3" href="{{route('admin.subjects')}}">
                <i class="bi bi-book me-2"></i> View Subjects
            </a>

            <h6 class="section-heading text-muted mt-3">Files</h6>
            <a class="nav-link text-white ms-3" href="{{route('admin.UploadedFiles')}}">
                <i class="bi bi-folder me-2"></i> View Files
            </a>

            <h6 class="section-heading text-muted mt-3">Account</h6>
            <a class="nav-link text-white ms-3" href="#">
                <i class="bi bi-key me-2"></i> Change Password
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-grow-1 d-flex flex-column">

        <!-- Header -->
        <header class="bg-white p-3 shadow-sm d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ $headerTitle ?? 'Dashboard' }}</h4>
            <div>
                <span class="me-3 user-greeting">Hello, {{ auth()->user()->name ?? 'Admin' }}</span>
                <a href="#" class="text-danger logout-link">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </a>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow-1 p-4 overflow-auto">
            <div class="container-fluid py-3 bg-white rounded shadow-sm">
                {{ $MainContent }}
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white p-3 text-center border-top">
            <small class="text-muted">&copy; {{ date('Y') }} StudentSphere. All rights reserved.</small>
        </footer>
    </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</body>
</html>
