<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $headerTitle ?? 'Dashboard' }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        :root {
            --sidebar-width: 240px;
            --primary-hover: rgba(255, 255, 255, 0.1);
            --active-bg: rgba(13, 110, 253, 0.2);
        }

        body {
            overflow-x: hidden;
        }

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            background: #212529;
            transition: all 0.3s;
            z-index: 1000;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .nav-link {
            border-radius: 6px;
            padding: 10px 15px;
            margin-bottom: 5px;
            transition: all 0.2s;
        }

        .nav-link:hover {
            background: var(--primary-hover);
            transform: translateX(3px);
        }

        .nav-link.active {
            background: var(--active-bg);
            font-weight: 500;
            border-left: 3px solid #0d6efd;
        }

        .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
        }

        .header {
            height: 60px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 100;
        }

        .content-area {
            flex: 1;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .brand {
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 15px;
        }

        .logout-link {
            transition: all 0.2s;
        }

        .logout-link:hover {
            color: #dc3545 !important;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column">
        <!-- Brand / Title -->
        <div class="brand text-center text-white">
            <h4 class="fw-bold mb-0"><i class="bi bi-mortarboard-fill me-2"></i>Student Sphere</h4>
        </div>

        <!-- Navigation -->
        <ul class="nav flex-column flex-grow-1 px-3">
            <li class="nav-item">
                <a href="{{route('cr.dashboard')}}" class="nav-link text-white {{ request()->routeIs('cr.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('cr.GetFiles')}}" class="nav-link text-white {{ request()->routeIs('cr.GetFiles') ? 'active' : '' }}">
                    <i class="bi bi-folder-check"></i>Study Materials
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('cr.Upload')}}" class="nav-link text-white {{ request()->routeIs('cr.Upload') ? 'active' : '' }}">
                    <i class="bi bi-cloud-arrow-up"></i> Upload Files
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('cr.UploadedFilesCheck')}}" class="nav-link text-white {{ request()->routeIs('cr.UploadedFilesCheck') ? 'active' : '' }}">
                    <i class="bi bi-folder-check"></i> My Uploaded Files
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('cr.PreviousMaterials')}}" class="nav-link text-white {{ request()->routeIs('cr.PreviousMaterials') ? 'active' : '' }}">
                    <i class="bi bi-folder-check"></i>Previous Year Materials
                </a>
            </li>
        </ul>

        <!-- Logout at bottom -->
        <div class="px-3 pb-4">
            <a href="{{route('student.logout')}}" class="nav-link text-white logout-link">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>

    <!-- Main content area -->
    <div class="main-content">
        <!-- Header -->
        <header class="header bg-white d-flex align-items-center px-4">
            <h5 class="mb-0 text-dark">{{ $headerTitle ?? 'CR Dashboard' }}</h5>
        </header>

        <!-- Dynamic content -->
        <main class="content-area">
            {{ $MainContent }}
        </main>
    </div>

</body>

</html>
