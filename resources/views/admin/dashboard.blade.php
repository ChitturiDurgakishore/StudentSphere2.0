<x-admin-ui :role="'admin'" :title="'Admin Panel'" :headerTitle="'Dashboard Overview'">
    <x-slot name="MainContent">
        <div class="row g-4">
            <!-- Students Card -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Students</h6>
                                <h3 class="mb-0">{{ $totalStudents ?? '--' }}</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="bi bi-people-fill text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.users') }}" class="text-decoration-none small">
                                View all students <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CRs Card -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Class Representatives</h6>
                                <h3 class="mb-0">{{ $totalCRs ?? '--' }}</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="bi bi-person-badge-fill text-success fs-4"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.users') }}" class="text-decoration-none small">
                                Manage CRs <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Files Card -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Files Uploaded</h6>
                                <h3 class="mb-0">{{ $totalFiles ?? '--' }}</h3>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="bi bi-folder-fill text-info fs-4"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.UploadedFiles') }}" class="text-decoration-none small">
                                View all files <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .card {
                transition: transform 0.2s ease, box-shadow 0.2s ease;
                border-radius: 10px;
            }
            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
            }
            .bg-opacity-10 {
                background-color: rgba(var(--bs-primary-rgb), 0.1);
            }
        </style>
    </x-slot>
</x-admin-ui>
