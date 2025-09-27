<x-CRUI :role="'cr'" :title="'CR Panel'" :headerTitle="'Dashboard'">
    <x-slot name="MainContent">
        <div class="container-fluid py-3">
            <h3 class="mb-4 text-center">📋 Your Dashboard</h3>

            <div class="row g-3">
                <!-- Name Box -->
                <div class="col-md-4">
                    <div class="card text-center shadow-sm h-100">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <i class="bi bi-person text-primary fs-2 mb-2"></i>
                            <h6 class="text-muted">Name</h6>
                            <h5>{{ session('name') }}</h5>
                        </div>
                    </div>
                </div>

                <!-- Email Box -->
                <div class="col-md-4">
                    <div class="card text-center shadow-sm h-100">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <i class="bi bi-envelope text-primary fs-2 mb-2"></i>
                            <h6 class="text-muted">Email</h6>
                            <h5>{{ session('email') }}</h5>
                        </div>
                    </div>
                </div>

                <!-- Roll No Box -->
                <div class="col-md-4">
                    <div class="card text-center shadow-sm h-100">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <i class="bi bi-list-ol text-primary fs-2 mb-2"></i>
                            <h6 class="text-muted">Roll No</h6>
                            <h5>{{ session('rollno') }}</h5>
                        </div>
                    </div>
                </div>

                <!-- Year Box -->
                <div class="col-md-4">
                    <div class="card text-center shadow-sm h-100">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <i class="bi bi-calendar text-primary fs-2 mb-2"></i>
                            <h6 class="text-muted">Year</h6>
                            <h5>Year {{ session('year') }}</h5>
                        </div>
                    </div>
                </div>

                <!-- Branch Box -->
                <div class="col-md-4">
                    <div class="card text-center shadow-sm h-100">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <i class="bi bi-collection text-primary fs-2 mb-2"></i>
                            <h6 class="text-muted">Branch</h6>
                            <h5>{{ session('branch') ?? '-' }}</h5>
                        </div>
                    </div>
                </div>

                <!-- Additional Box Example (Placeholder for future info) -->
                <div class="col-md-4">
                    <div class="card text-center shadow-sm h-100">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <i class="bi bi-info-circle text-primary fs-2 mb-2"></i>
                            <h6 class="text-muted">Status</h6>
                            <h5>Active</h5>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <style>
            .card {
                border-radius: 10px;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }
            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
            }
        </style>
    </x-slot>
</x-CRUI>
