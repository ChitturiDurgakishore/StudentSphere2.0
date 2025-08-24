<x-studentUI>
    <x-slot name="MainContent">
    <!-- User Details Card -->
    <section class="profile-card">
        <div class="card-header">
            <svg class="header-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <h3>Student Profile</h3>
        </div>
        <div class="profile-grid">
            <div class="profile-field">
                <span class="field-label">Full Name</span>
                <span class="field-value">{{ Auth::user()->name }}</span>
            </div>
            <div class="profile-field">
                <span class="field-label">Email</span>
                <span class="field-value">{{ Auth::user()->email }}</span>
            </div>
            <div class="profile-field">
                <span class="field-label">Roll No</span>
                <span class="field-value">{{ Auth::user()->rollno ?? 'N/A' }}</span>
            </div>
            <div class="profile-field">
                <span class="field-label">Branch & Year</span>
                <span class="field-value">{{ Auth::user()->branch ?? 'N/A' }} ({{ Auth::user()->year ?? 'N/A' }})</span>
            </div>
        </div>
    </section>

    <!-- About StudentSphere Card -->
    <section class="about-card">
        <div class="card-header">
            <svg class="header-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
            </svg>
            <h3>About StudentSphere</h3>
        </div>
        <div class="about-content">
            <p>
                StudentSphere is a modern learning platform designed to revolutionize your academic experience.
                We provide centralized access to study materials, AI-powered interactive assistants, and personalized
                learning resources tailored to your curriculum.
            </p>
            <ul class="feature-list">
                <li><i class="bi bi-journal-bookmark"></i> Organized digital library of course materials</li>
                <li><i class="bi bi-robot"></i> Smart chatbots for instant academic support</li>
                <li><i class="bi bi-graph-up"></i> Personalized dashboard tracking your progress</li>
                <li><i class="bi bi-plug"></i> Seamless integration with all your learning tools</li>
            </ul>
        </div>
    </section>

    <style>
        /* Base Styles */
        :root {
            --primary: #4361ee;
            --primary-light: #e6f0ff;
            --dark: #2c3e50;
            --gray: #7f8c8d;
            --light-gray: #f8f9fa;
            --white: #ffffff;
            --shadow: 0 4px 12px rgba(0,0,0,0.08);
            --radius: 12px;
        }

        /* Profile Card */
        .profile-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 1.75rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.12);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .card-header h3 {
            color: var(--dark);
            font-size: 1.35rem;
            font-weight: 600;
            margin: 0;
        }

        .header-icon {
            width: 24px;
            height: 24px;
            stroke: var(--primary);
        }

        .profile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.75rem;
        }

        .profile-field {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .field-label {
            font-size: 0.85rem;
            color: var(--gray);
            font-weight: 500;
        }

        .field-value {
            font-weight: 500;
            color: var(--dark);
            font-size: 1.05rem;
        }

        /* About Card */
        .about-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 1.75rem;
            box-shadow: var(--shadow);
        }

        .about-content {
            color: var(--dark);
            line-height: 1.7;
            background: var(--light-gray);
            padding: 1.5rem;
            border-radius: 8px;
        }

        .about-content p {
            margin-bottom: 1.25rem;
            color: #34495e;
        }

        .feature-list {
            margin: 0;
            padding-left: 0;
            display: grid;
            gap: 0.75rem;
            list-style: none;
        }

        .feature-list li {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0;
        }

        .feature-list i {
            color: var(--primary);
            font-size: 1.1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .profile-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 480px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }

            .profile-card, .about-card {
                padding: 1.5rem;
            }
        }
    </style>
    </x-slot>
</x-studentUI>
