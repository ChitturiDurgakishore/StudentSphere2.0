<x-CRUI :role="'cr'" :title="'CR Panel'" :headerTitle="'Dashboard'">
    <x-slot name="MainContent">
        <!-- Logged-in CR Details Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Your Profile</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-light p-2 rounded me-3">
                                <i class="bi bi-person text-primary fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted">Name</small>
                                <h6 class="mb-0">{{ session('name') }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-light p-2 rounded me-3">
                                <i class="bi bi-envelope text-primary fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted">Email</small>
                                <h6 class="mb-0">{{ session('email') }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-light p-2 rounded me-3">
                                <i class="bi bi-123 text-primary fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted">Roll No</small>
                                <h6 class="mb-0">{{ session('rollno') }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-light p-2 rounded me-3">
                                <i class="bi bi-calendar text-primary fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted">Year</small>
                                <h6 class="mb-0">Year {{ session('year') }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-light p-2 rounded me-3">
                                <i class="bi bi-building text-primary fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted">Branch</small>
                                <h6 class="mb-0">{{ session('branch') ?? '-' }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4">
            <!-- Total Files Uploaded -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-info bg-opacity-10 rounded-circle mx-auto mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-file-earmark-text text-info fs-3"></i>
                        </div>
                        <h5 class="text-muted mb-2">Files Uploaded</h5>
                        <h2 class="mb-3">{{ $totalFiles ?? 0 }}</h2>
                        <a href="{{ route('cr.UploadedFilesCheck') }}" class="btn btn-sm btn-outline-info">
                            View All <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Subjects for CR's Year -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-success bg-opacity-10 rounded-circle mx-auto mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-book text-success fs-3"></i>
                        </div>
                        <h5 class="text-muted mb-2">Your Subjects</h5>
                        <h2 class="mb-3">{{ $totalSubjects ?? 0 }}</h2>
                        <a href="#" class="btn btn-sm btn-outline-success">
                            View Subjects <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-warning bg-opacity-10 rounded-circle mx-auto mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-info-circle text-warning fs-3"></i>
                        </div>
                        <h5 class="text-muted mb-2">Quick Actions</h5>
                        <div class="d-grid gap-2">
                            <a href="{{ route('cr.Upload') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-upload me-1"></i> Upload Files
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
</x-CRUI>
