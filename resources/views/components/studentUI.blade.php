<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <!-- Bootstrap Icons -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #e6f0ff;
            --secondary: #3f37c9;
            --dark: #212529;
            --light: #f8f9fa;
            --danger: #e63946;
            --success: #2a9d8f;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body,
        html {
            height: 100%;
            background-color: #f4f6f8;
        }

        /* Layout */
        .layout {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header */
        header {
            background-color: #fff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        header h1 {
            color: var(--primary);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        header h1 i {
            font-size: 1.5rem;
        }

        header .profile {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-weight: 500;
            color: var(--dark);
        }

        header .profile .badge {
            background-color: var(--primary-light);
            color: var(--primary);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        header .profile .badge i {
            font-size: 1rem;
        }

        /* Body */
        .body {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        /* Sidebar */
        aside {
            width: 260px;
            background-color: #fff;
            padding: 2rem 1rem;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
        }

        aside nav {
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        aside nav a {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.25rem;
            margin-bottom: 0.5rem;
            text-decoration: none;
            color: #495057;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s ease;
            gap: 0.75rem;
        }

        aside nav a:hover {
            background-color: var(--primary-light);
            color: var(--primary);
            transform: translateX(5px);
        }

        aside nav a i {
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }

        aside nav a.logout {
            color: var(--danger);
            margin-top: auto;
        }

        aside nav a.logout:hover {
            background-color: rgba(230, 57, 70, 0.1);
        }

        /* Main content */
        main {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
            background-color: #f8f9fa;
        }

        main .card {
            background-color: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: none;
            margin-bottom: 2rem;
        }

        main h2 {
            margin-bottom: 1.5rem;
            color: var(--dark);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        main h2 i {
            color: var(--primary);
        }

        /* Footer */
        footer {
            background-color: #fff;
            text-align: center;
            padding: 1.25rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            aside {
                width: 220px;
                padding: 1.5rem 1rem;
            }
        }

        @media (max-width: 768px) {
            .body {
                flex-direction: column;
            }

            aside {
                width: 100%;
                padding: 1rem;
            }

            aside nav {
                flex-direction: row;
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            aside nav a {
                margin-bottom: 0;
            }

            aside nav a.logout {
                margin-top: 0;
                margin-left: auto;
            }

            main {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="layout">
        <!-- Header -->
        <header>
            <h1>
                <i class="bi bi-mortarboard"></i>
                Student Sphere
            </h1>
            <div class="profile">
                <span class="badge">
                    <i class="bi bi-person-circle"></i>
                    {{ Auth::user()->name }}
                </span>
            </div>
        </header>

        <!-- Body -->
        <div class="body">
            <!-- Sidebar -->
            <aside>
                <nav>
                    <a href="{{ route('student.Materials') }}">
                        <i class="bi bi-journal-bookmark"></i>
                        Study Materials
                    </a>
                    <a href="#">
                        <i class="bi bi-robot"></i>
                        Chatbot
                    </a>
                    <a href="#">
                        <i class="bi bi-person"></i>
                        Profile
                    </a>
                    <a href="{{ route('student.logout') }}" class="logout">
                        <i class="bi bi-box-arrow-right"></i>
                        Logout
                    </a>
                </nav>
            </aside>

            <!-- Main Content -->
            <main>
                <div class="card">

                    {{ $MainContent }}
                </div>
            </main>
        </div>

        <!-- Footer -->
        <footer>
            &copy; {{ date('Y') }} Student Sphere. All rights reserved.
        </footer>
    </div>
</body>

</html>
